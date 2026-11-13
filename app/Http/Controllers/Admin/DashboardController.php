<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        // Awal hari menurut zona waktu kafe, dikonversi ke UTC (waktu di database).
        $startOfDay = now(config('cafe.timezone'))->startOfDay()->utc();

        $today = Order::where('created_at', '>=', $startOfDay);

        $stats = [
            'orders_today' => (clone $today)->count(),
            'revenue_today' => (int) (clone $today)->where('status', '!=', OrderStatus::Cancelled->value)->sum('total'),
            'pending' => Order::where('status', OrderStatus::Pending->value)->count(),
            'menus' => Menu::count(),
            'customers' => User::where('role', UserRole::User->value)->count(),
        ];

        $recentOrders = Order::with('items')->latest()->limit(6)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
