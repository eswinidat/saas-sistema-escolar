<?php

namespace App\Modules\Billing\Http\Controllers;

use App\Modules\Billing\Models\SunatSetting;
use App\Modules\Core\Http\Controllers\ModuleController;
use Illuminate\Http\Request;

class SunatSettingController extends ModuleController
{
    public function edit()
    {
        if (! $this->currentSchoolId()) {
            return view('modules.settings.no-school', ['title' => 'Configuración SUNAT']);
        }

        $settings = SunatSetting::firstOrNew(['school_id' => $this->currentSchoolId()]);
        $school = \App\Models\School::find($this->currentSchoolId());

        return view('modules.billing.settings.edit', [
            'settings' => $settings,
            'school' => $school,
            'providers' => SunatSetting::PROVIDERS,
        ]);
    }

    public function update(Request $request)
    {
        $schoolId = $this->requireSchoolId();

        $data = $request->validate([
            'business_name' => ['required', 'string', 'max:200'],
            'ruc' => ['required', 'string', 'size:11'],
            'commercial_name' => ['nullable', 'string', 'max:200'],
            'address' => ['nullable', 'string'],
            'ubigeo' => ['nullable', 'string', 'size:6'],
            'boleta_series' => ['required', 'string', 'max:4'],
            'factura_series' => ['required', 'string', 'max:4'],
            'nota_credito_series' => ['required', 'string', 'max:4'],
            'ose_provider' => ['required', 'string'],
            'ose_api_url' => ['nullable', 'url'],
            'ose_api_token' => ['nullable', 'string'],
            'is_production' => ['boolean'],
        ]);

        SunatSetting::updateOrCreate(
            ['school_id' => $schoolId],
            [
                ...$data,
                'is_production' => $request->boolean('is_production'),
                'is_active' => true,
            ]
        );

        return redirect()->route('billing.settings.edit')
            ->with('success', 'Configuración SUNAT guardada.');
    }
}
