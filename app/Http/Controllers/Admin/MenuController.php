<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $menus = Menu::with('subcategory.category')->latest()->paginate(10);

        return view('admin.menus.index', compact('menus'));
    }

    public function create(): View
    {
        return view('admin.menus.create', ['categories' => Category::with('subcategories')->get()]);
    }

    public function store(MenuRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu ditambahkan.');
    }

    public function edit(Menu $menu): View
    {
        return view('admin.menus.edit', [
            'menu' => $menu,
            'categories' => Category::with('subcategories')->get(),
        ]);
    }

    public function update(MenuRequest $request, Menu $menu): RedirectResponse
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $this->deleteImage($menu);
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu diperbarui.');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $this->deleteImage($menu);
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu dihapus.');
    }

    private function deleteImage(Menu $menu): void
    {
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }
    }
}
