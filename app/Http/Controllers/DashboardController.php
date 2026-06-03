<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if($user->hasRole('owner')) {
            return view('dashboard.owner');
        }

        if($user->hasRole('manager')) {
            return view('dashboard.manager');
        }

        if($user->hasRole('supervisor')) {
            return view('dashboard.supervisor');
        }

        if($user->hasRole('cashier')) {
            return view('dashboard.cashier');
        }

        if($user->hasRole('warehouse')) {
            return view('dashboard.warehouse');
        }

        abort(403);
    }
}
