<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EventsController extends Controller
{
    // Upload folder (relative to the /public directory)
    protected string $imagePath = 'admin-assets/events/image/';

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
            ->addColumn('image', function ($row) {
                if (! $row->image) {
                    return '-';
                }
                $url = asset($this->imagePath . $row->image);
                return '<img src="' . $url . '" alt="' . e($row->image_alt) . '" style="max-width:60px;max-height:60px;">';
            })
            ->addColumn('status', function ($row) {
                $badge = $row->status === 'Active' ? 'success' : 'secondary';
                return '<span class="badge bg-' . $badge . '">' . $row->status . '</span>';
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
        $validated = $request->validate($this->rules());

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

        $validated = $request->validate($this->rules($event));

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
     * Server-side validation rules (keep in sync with events/_scripts inline validate).
     */
    protected function rules(?Event $event = null): array
    {
        $image = 'image|mimes:jpg,jpeg,png,webp|max:2048';

        return [
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'date'        => 'nullable|date',
            'image'       => ($event ? 'nullable|' : 'required|') . $image,
            'image_alt'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:Active,In-Active',
        ];
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