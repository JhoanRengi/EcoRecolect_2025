<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollectorCompany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CollectorCompanyController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['status'] = $data['status'] ?? 'active';

        CollectorCompany::create($data);

        return back()->with('success', 'Empresa recolectora creada correctamente.');
    }

    public function destroy(CollectorCompany $company): RedirectResponse
    {
        $company->delete();

        return back()->with('success', 'Empresa eliminada correctamente.');
    }
}

