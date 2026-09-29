<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EventsController extends Controller
{
    // Upload folder (relative to the /public directory)
    protected string $imagePath = 'admin-assets/events/image/';

    // Date format used on the form (stored in the database as Y-m-d)
    protected string $dateFormat = 'd-m-Y';

    /**
     * Events list page.
     */
    public function index()
    {
        return view('admin.events.index');
    }

    /**
     * DataTable ajax feed for the events list.
     */
    public function getEventsData()
    {
        $events = Event::select('events.*');

        return DataTables::of($events)
            ->addIndexColumn()
            ->addColumn('event_date', function ($row) {
                if (! $row->from_date) {
                    return '-';
                }

                $from = $row->from_date->format($this->dateFormat);

                if (! $row->to_date || $row->to_date->isSameDay($row->from_date)) {
                    return $from;
                }

                return $from . ' to ' . $row->to_date->format($this->dateFormat);
            })
            ->orderColumn('event_date', 'from_date $1')
            ->addColumn('image', function ($row) {
                if (! $row->image) {
                    return '-';
                }
                $url = asset($this->imagePath . $row->image);
                return '<img src="' . $url . '" alt="' . e($row->image_alt) . '" style="max-width:60px;max-height:60px;">';
            })
            ->addColumn('status', function ($row) {
                $checked = $row->status === 'Active' ? 'checked' : '';
                return '<div class="form-check form-switch">
                            <input class="form-check-input toggle-status" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                        </div>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('events.edit', $row->id);
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger btn-delete-event" data-id="' . $row->id . '"><i class="bi bi-trash"></i> Delete</button>
                ';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show add event form.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a new event.
     */
    public function store(Request $request)
    {
        $validated = $this->convertDates($request->validate($this->rules()));

        $validated['image'] = $this->uploadImage($request, 'image', $this->imagePath);

        Event::create($validated);

        return redirect()->route('events.index')->with('toast_success', 'Event created successfully.');
    }

    /**
     * Show edit event form.
     */
    public function edit($id)
    {
        $events = Event::findOrFail($id);

        return view('admin.events.edit', compact('events'));
    }

    /**
     * Update an existing event.
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $this->convertDates($request->validate($this->rules($event)));

        if ($request->hasFile('image')) {
            $this->deleteImage($event->image);
            $validated['image'] = $this->uploadImage($request, 'image', $this->imagePath);
        }

        $event->update($validated);

        return redirect()->route('events.index')->with('toast_success', 'Event updated successfully.');
    }

    /**
     * Delete an event and its image (called via ajax from the list page).
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        $this->deleteImage($event->image);

        $event->delete();

        return response()->json(['success' => true, 'message' => 'Event deleted successfully.']);
    }

    /**
     * Switch Active / In-Active from the list page (ajax).
     */
    public function toggleStatus($id)
    {
        $event = Event::findOrFail($id);

        $event->status = $event->status === 'Active' ? 'In-Active' : 'Active';
        $event->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status'  => $event->status,
        ]);
    }

    /**
     * Server-side validation rules (keep in sync with events/_scripts inline validate).
     */
    protected function rules(?Event $event = null): array
    {
        $image = 'image|mimes:jpg,jpeg,png,webp|max:2048';

        return [
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'from_date'   => 'nullable|required_with:to_date|date_format:' . $this->dateFormat,
            'to_date'     => 'nullable|date_format:' . $this->dateFormat . '|after_or_equal:from_date',
            'image'       => ($event ? 'nullable|' : 'required|') . $image,
            'image_alt'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:Active,In-Active',
        ];
    }

    /**
     * Turn the form dates (d-m-Y) into database dates (Y-m-d).
     */
    protected function convertDates(array $validated): array
    {
        foreach (['from_date', 'to_date'] as $field) {
            $validated[$field] = ! empty($validated[$field])
                ? Carbon::createFromFormat($this->dateFormat, $validated[$field])->format('Y-m-d')
                : null;
        }

        return $validated;
    }

    /**
     * Upload a file to the given public path and return the stored filename.
     */
    protected function uploadImage(Request $request, string $field, string $path): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        $file     = $request->file($field);
        $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '_' . time() . '.' . $file->getClientOriginalExtension();

        $file->move(public_path($path), $fileName);

        return $fileName;
    }

    /**
     * Delete a previously uploaded image file, if it exists.
     */
    protected function deleteImage(?string $fileName): void
    {
        if (! $fileName) {
            return;
        }

        $fullPath = public_path($this->imagePath . $fileName);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
