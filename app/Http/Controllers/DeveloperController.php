<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function index()
    {
        return view('developer.dashboard');
    }

    public function tenants()
    {
        $tenants = Tenant::all();
        return view('developer.tenants', compact('tenants'));
    }

    public function analytics()
    {
        return view('developer.analytics');
    }
}
