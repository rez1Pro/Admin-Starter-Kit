<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        return Inertia::render('Settings/Index', [
            'settings' => [
                'site_name' => config('app.name'),
                'maintenance_mode' => app()->isDownForMaintenance(),
                // Add more settings as needed
            ]
        ]);
    }

    public function update(Request $request)
    {
        dd($request->all());
    }
}
