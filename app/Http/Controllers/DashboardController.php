<?php

namespace App\Http\Controllers;

use App\Models\School;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSchools = School::count();

        return view('admin.dashboard', compact(
            'totalSchools'
        ));
    }
}