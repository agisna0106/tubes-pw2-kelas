<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Branch;
use App\Models\User;

use Barryvdh\DomPDF\Facade\Pdf;

class BranchReportController extends Controller
{
    public function index()
    {
        $totalBranches = Branch::count();

        $totalManagers = User::role('manager')->count();

        $branches = Branch::with('manager')
            ->orderBy('name')
            ->get();

        return view(
            'reports.branches.index',
            compact(
                'totalBranches',
                'totalManagers',
                'branches'
            )
        );
    }

    public function pdf()
    {
        $totalBranches = Branch::count();

        $totalManagers = User::role('manager')->count();

        $branches = Branch::with('manager')
            ->orderBy('name')
            ->get();

        $pdf = Pdf::loadView(
            'reports.branches.pdf',
            compact(
                'branches',
                'totalBranches',
                'totalManagers'
            )
        );

        return $pdf->stream('branch-report.pdf');
    }
}
