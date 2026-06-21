<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Branch;
use App\Models\Product;
// use App\Models\Sale;
use App\Models\StockMovement;

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

    public function owner()
    {
        $totalBranches = Branch::count();

        $totalUsers = User::count();

        $totalProducts = Product::count();

        $currentStock = Product::sum('stock');

        $lowStocks = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->get();

        return view(
            'dashboard.owner',
            compact(
                'totalBranches',
                'totalUsers',
                'totalProducts',
                'currentStock',
                // 'todaySales',
                // 'monthlySales',
                // 'transactionCount',
                // 'cashierCount',
                'lowStocks'
                // 'recentTransactions'
            )
        );
    }
}
