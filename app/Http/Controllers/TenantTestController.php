<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenantTestController extends Controller
{
    public function verify()
    {
        if (!tenant()) {
            return response('No tenant could be identified from the URL.', 500);
        }

        return response()->json([
            'message' => 'Tenancy initialization is working correctly!',
            'tenant_id' => tenant('id'),
            'database_name' => DB::connection()->getDatabaseName(),
        ]);
    }
}
