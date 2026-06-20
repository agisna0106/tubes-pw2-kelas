<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use Barryvdh\DomPDF\Facade\Pdf;

class InventoryReportController extends Controller
{
    public function index(Request $request)
    {
        $query = StockMovement::with([
            'product',
            'user'
        ]);

        if ($request->start_date && $request->end_date) {

            $query->whereBetween(
                'created_at',
                [
                    $request->start_date,
                    $request->end_date
                ]
            );
        }

        $movements = $query
            ->latest()
            ->get();

        return view(
            'reports.inventory.index',
            compact('movements')
        );
    }

    public function pdf(Request $request)
    {
        $query = StockMovement::with([
            'product',
            'user'
        ]);

        if ($request->start_date && $request->end_date) {

            $query->whereBetween(
                'created_at',
                [
                    $request->start_date,
                    $request->end_date
                ]
            );
        }

        $movements = $query->get();

        $pdf = Pdf::loadView(
            'reports.inventory.pdf',
            compact('movements')
        );

        return $pdf->download(
            'inventory-report.pdf'
        );
    }
}
