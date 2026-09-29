<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Locator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class LocatorsController extends Controller
{
    /**
     * Locators list page.
     */
    public function index()
    {
        return view('admin.locators.index');
    }

    /**
     * DataTable ajax feed for the locators list.
     */
    public function getLocatorsData()
    {
        $locators = Locator::select('locators.*');

        return DataTables::of($locators)
            ->addIndexColumn()
            ->editColumn('city', fn ($row) => e($row->city))
            ->editColumn('address', fn ($row) => e(Str::limit($row->address, 80)))
            ->editColumn('phone', fn ($row) => e($row->phone))
            ->editColumn('email', fn ($row) => e($row->email))
            ->addColumn('status', function ($row) {
                $checked = $row->status === 'Active' ? 'checked' : '';
                return '<div class="form-check form-switch">
                            <input class="form-check-input toggle-status" type="checkbox" data-id="' . $row->id . '" ' . $checked . '>
                        </div>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('locators.edit', $row->id);
                return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                    <button type="button" class="btn btn-sm btn-danger btn-delete-locator" data-id="' . $row->id . '"><i class="bi bi-trash"></i> Delete</button>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Show add locator form.
     */
    public function create()
    {
        return view('admin.locators.create');
    }

    /**
     * Store a new locator.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        Locator::create($validated);

        return redirect()->route('locators.index')->with('toast_success', 'Locator created successfully.');
    }

    /**
     * Show edit locator form.
     */
    public function edit($id)
    {
        $locator = Locator::findOrFail($id);

        return view('admin.locators.edit', compact('locator'));
    }

    /**
     * Update an existing locator.
     */
    public function update(Request $request, $id)
    {
        $locator = Locator::findOrFail($id);

        $validated = $request->validate($this->rules(), $this->messages());

        $locator->update($validated);

        return redirect()->route('locators.index')->with('toast_success', 'Locator updated successfully.');
    }

    /**
     * Delete a locator (called via ajax from the list page).
     */
    public function destroy($id)
    {
        Locator::findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Locator deleted successfully.']);
    }

    /**
     * Switch Active / In-Active from the list page (ajax).
     */
    public function toggleStatus($id)
    {
        $locator = Locator::findOrFail($id);

        $locator->status = $locator->status === 'Active' ? 'In-Active' : 'Active';
        $locator->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status'  => $locator->status,
        ]);
    }

    /**
     * Server-side validation rules.
     */
    protected function rules(): array
    {
        return [
            'city'    => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone'   => ['required', 'string', 'regex:/^[0-9+\-()\s]{7,20}$/'],
            'email'   => 'required|email|max:255',
            'status'  => 'required|in:Active,In-Active',
        ];
    }

    /**
     * Custom validation messages.
     */
    protected function messages(): array
    {
        return [
            'phone.regex' => 'Please enter a valid phone number.',
        ];
    }
}
