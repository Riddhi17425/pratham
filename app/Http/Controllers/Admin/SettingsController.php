<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * The one and only settings page (form opens directly).
     * If no record exists yet, an empty one is shown; it is created on first save.
     */
    public function edit()
    {
        $setting = Setting::first() ?? new Setting();
        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Save the settings (create the row the first time, update it afterwards).
     */
    public function update(Request $request)
    {
        $validated = $this->cleanOfficeNumber(
            $request->validate($this->rules(), $this->messages())
        );

        $setting = Setting::first();

        if ($setting) {
            $setting->update($validated);
        } else {
            Setting::create($validated);
        }

        return redirect()->route('settings.edit')->with('toast_success', 'Settings updated successfully.');
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
            'whatsapp_url' => 'nullable|string|max:255',
            'facebook_url'  => 'nullable|url|max:255',
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
