<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Branch;

class BranchReportController extends Controller
{
    public function index()
    {
        $branches = Branch::with([
            'manager',
            'users'
        ])->get();

        return view('reports.branches.index',compact('branches'));
    }
}
