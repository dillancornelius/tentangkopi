<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'subcategory' => ['nullable', 'integer'],
            'search' => ['nullable', 'string', 'max:100'],
            'sort' => ['nullable', 'in:price_asc,price_desc,name_asc'],
        ]);

        $menus = Menu::with('subcategory')
            ->when($filters['subcategory'] ?? null, fn ($query, $id) => $query->where('subcategory_id', $id))
            ->search($filters['search'] ?? null)
            ->sortBy($filters['sort'] ?? null)
            ->get();

        $categories = Category::with('subcategories')->get();

        return view('menu.index', [
            'menus' => $menus,
            'categories' => $categories,
            'filters' => $filters,
        ]);
    }
}
