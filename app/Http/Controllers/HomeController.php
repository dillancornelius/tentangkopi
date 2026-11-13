<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Subcategory;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $cards = collect(config('cafe.home_cards'));

        $subcategoryIds = Subcategory::whereIn('name', $cards->pluck('subcategory'))->pluck('id', 'name');

        $cards = $cards->map(fn (array $card) => [
            'label' => $card['label'],
            'image' => asset($card['image']),
            'url' => route('menu.index', array_filter(['subcategory' => $subcategoryIds[$card['subcategory']] ?? null])),
            'subcategory' => $card['subcategory'],
        ]);

        $featured = Menu::with('subcategory')->orderBy('id')->limit(4)->get();

        return view('home', compact('cards', 'featured'));
    }
}
