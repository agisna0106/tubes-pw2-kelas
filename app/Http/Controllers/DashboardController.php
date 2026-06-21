<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use App\Models\SaleDetail;
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

        $todaySales = Sale::whereDate(
            'transaction_date',
            today()
        )->sum('total');

        $monthlySales = Sale::whereMonth(
            'transaction_date',
            now()->month
        )->sum('total');

        $transactionCount = Sale::count();

        $cashierCount = User::role('cashier')->count();

        $lowStocks = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->get();

        $recentTransactions = Sale::with([
                'branch',
                'cashier'
            ])
            ->latest()
            ->take(5)
            ->get();

        return view(
            'dashboard.owner',
            compact(
                'totalBranches',
                'totalUsers',
                'totalProducts',
                'currentStock',
                'todaySales',
                'monthlySales',
                'transactionCount',
                'cashierCount',
                'lowStocks',
                'recentTransactions'
            )
        );
    }

    public function manager()
    {
        $user = auth()->user();

        $branchId = $user->branch_id;

        $totalProducts = Product::count();

        $currentStock = Product::sum('stock');

        $todaySales = Sale::where('branch_id', $branchId)
            ->whereDate('transaction_date', today())
            ->sum('total');

        $todayTransactions = Sale::where('branch_id', $branchId)
            ->whereDate('transaction_date', today())
            ->count();

        $lowStocks = Product::where('stock', '<=', 10)
            ->orderBy('stock')
            ->take(5)
            ->get();

        $latestTransactions = Sale::where('branch_id', $branchId)
            ->latest()
            ->take(5)
            ->get();

        return view(
            'dashboard.manager',
            compact(
                'totalProducts',
                'currentStock',
                'todaySales',
                'todayTransactions',
                'lowStocks',
                'latestTransactions'
            )
        );
    }

    public function supervisor()
    {
        $totalCategories = Category::count();

        $totalProducts = Product::count();

        $currentStock = Product::sum('stock');

        $lowStockCount = Product::where('stock', '<=', 10)->count();

        $lowStocks = Product::with('category')
            ->where('stock', '<=', 10)
            ->orderBy('stock')
            ->take(5)
            ->get();

        $latestProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view(
            'dashboard.supervisor',
            compact(
                'totalCategories',
                'totalProducts',
                'currentStock',
                'lowStockCount',
                'lowStocks',
                'latestProducts'
            )
        );
    }

    public function warehouse()
    {
        $totalProducts = Product::count();

        $currentStock = Product::sum('stock');

        $stockInToday = StockMovement::where('type', 'IN')
            ->whereDate('created_at', today())
            ->sum('quantity');

        $stockOutToday = StockMovement::where('type', 'OUT')
            ->whereDate('created_at', today())
            ->sum('quantity');

        $lowStocks = Product::with('category')
            ->where('stock', '<=', 10)
            ->orderBy('stock')
            ->take(5)
            ->get();

        $latestMovements = StockMovement::with([
            'product',
            'user'
        ])
        ->latest()
        ->take(5)
        ->get();

        return view(
            'dashboard.warehouse',
            compact(
                'totalProducts',
                'currentStock',
                'stockInToday',
                'stockOutToday',
                'lowStocks',
                'latestMovements'
            )
        );
    }

    public function cashier()
    {
        $todaySales = Sale::where(
            'cashier_id',
            auth()->id()
        )
        ->whereDate(
            'transaction_date',
            today()
        )
        ->sum('total');

        $todayTransactions = Sale::where(
            'cashier_id',
            auth()->id()
        )
        ->whereDate(
            'transaction_date',
            today()
        )
        ->count();

        $productsSold = SaleDetail::whereHas('sale', function ($query) {

            $query->where(
                'cashier_id',
                auth()->id()
            )
            ->whereDate(
                'transaction_date',
                today()
            );

        })->sum('qty');

        $averageTransaction =
            $todayTransactions == 0
            ? 0
            : $todaySales / $todayTransactions;

        $recentTransactions = Sale::where(
            'cashier_id',
            auth()->id()
        )
        ->latest()
        ->take(5)
        ->get();

        return view(
            'dashboard.cashier',
            compact(
                'todaySales',
                'todayTransactions',
                'productsSold',
                'averageTransaction',
                'recentTransactions'
            )
        );
    }
}
