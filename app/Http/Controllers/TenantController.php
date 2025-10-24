<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stancl\Tenancy\Database\Models\Domain;
use App\Models\Tenant;

class TenantController extends Controller
{
    public function showCreateForm()
    {
        return view('tenants.create');
    }

    public function create(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|string|max:255',
            'domain' => 'required|string|max:255'
        ]);

        try {
            // Create the tenant
            $tenant = Tenant::create(['id' => $request->tenant_id]);

            $tenant->domains()->create(['domain' => $request->domain]);
            // The database will be created automatically by the package's pipeline.
            // Get the created domain for the response
            $domain = $tenant->domains->first();

            return redirect()->route('tenants.create.form')
                ->with('success', 'Tenant created successfully. You can now access it at: http://' . $domain->domain);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create tenant',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
