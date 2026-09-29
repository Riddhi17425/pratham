<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SettingsController extends Controller
{
    /**
     * Settings list page.
     */
    public function index()
    {
        return view('admin.settings.index');
    }

    /**
     * DataTable ajax feed for the settings list.
     */
    public function getSettingsData()
    {
        $settings = Setting::select('settings.*');

        return DataTables::of($settings)
            ->addIndexColumn()
            ->editColumn('address', fn ($row) => e(Str::limit($row->address, 80)))
            ->editColumn('phone', fn ($row) => e($row->phone))
            ->editColumn('email', fn ($row) => e($row->email))
            ->addColumn('status', function ($row) {
                $badge = $row->status === 'Active' ? 'success' : 'secondary';
                return '<span class="badge bg-' . $badge . '">' . $row->status . '</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('settings.edit', $row->id);
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger btn-delete-setting" data-id="' . $row->id . '"><i class="bi bi-trash"></i> Delete</button>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Show add setting form.
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Store a new setting.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        Setting::create($this->cleanOfficeNumber($validated));

        return redirect()->route('settings.index')->with('toast_success', 'Setting created successfully.');
    }

    /**
     * Show edit setting form.
     */
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);

        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update an existing setting.
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        $validated = $request->validate($this->rules(), $this->messages());

        $setting->update($this->cleanOfficeNumber($validated));

        return redirect()->route('settings.index')->with('toast_success', 'Setting updated successfully.');
    }

    /**
     * Delete a setting (called via ajax from the list page).
     */
    public function destroy($id)
    {
        Setting::findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Setting deleted successfully.']);
    }

    /**
     * Server-side validation rules.
     */
    protected function rules(): array
    {
        return [
            'address'       => 'required|string|max:500',
            'phone'         => ['required', 'string', 'regex:/^[0-9+\-()\s]{7,20}$/'],
            'email'         => 'required|email|max:255',
            'office_number' => ['nullable', 'string', 'max:255', 'regex:/^[0-9+\-()\s]{7,20}(\s*,\s*[0-9+\-()\s]{7,20})*$/'],

            'linkedin_url'  => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url'   => 'nullable|url|max:255',
            'whatsapp_url'  => 'nullable|url|max:255',
            'facebook_url'  => 'nullable|url|max:255',

            'status'        => 'required|in:Active,In-Active',
        ];
    }

    /**
     * Tidy the comma separated office numbers ("a , b,c" => "a,b,c").
     */
    protected function cleanOfficeNumber(array $validated): array
    {
        if (! empty($validated['office_number'])) {
            $numbers = array_filter(array_map('trim', explode(',', $validated['office_number'])));
            $validated['office_number'] = implode(',', $numbers);
        }

        return $validated;
    }

    /**
     * Custom validation messages.
     */
    protected function messages(): array
    {
        return [
            'phone.regex'         => 'Please enter a valid phone number.',
            'office_number.regex' => 'Enter valid office numbers separated by commas.',
        ];
    }
}
