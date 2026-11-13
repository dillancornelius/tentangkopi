<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Subcategory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $minuman = Category::create(['name' => 'Minuman']);
        $makanan = Category::create(['name' => 'Makanan']);

        //Subkategori minuman
        $coldCoffee = $minuman->subcategories()->create(['name' => 'Cold Coffee']);
        $coldNonCoffee = $minuman->subcategories()->create(['name' => 'Cold Non Coffee']);
        $squash = $minuman->subcategories()->create(['name' => 'Squash']);

        $coldCoffee->menus()->createMany([
            ['name' => 'Ice Americano', 'price' => 14000],
            ['name' => 'Ice Cafe Latte', 'price' => 20000],
            ['name' => 'Ice Cappucino', 'price' => 20000],
            ['name' => 'Ice Gula Aren Latte', 'price' => 20000],
            ['name' => 'Ice Caramel Latte', 'price' => 25000],
            ['name' => 'Ice Tiramisu Latte', 'price' => 23000],
            ['name' => 'Ice Pandan Latte', 'price' => 23000],
        ]);

        $coldNonCoffee->menus()->createMany([
            ['name' => 'Ice Chocolate', 'price' => 18000],
            ['name' => 'Ice Red Velvet Latte', 'price' => 23000],
            ['name' => 'Ice Green Matcha Latte', 'price' => 23000],
        ]);

        $squash->menus()->createMany([
            ['name' => 'Orange Squash', 'price' => 15000],
            ['name' => 'Strawberry Squash', 'price' => 15000],
            ['name' => 'Lychee Squash', 'price' => 15000],
        ]);

        //Subkategori makanan
        $toast = $makanan->subcategories()->create(['name' => 'Toast']);

        $toast->menus()->createMany([
            ['name' => 'Eggsis Toast', 'price' => 30000],
            ['name' => 'Crispy Fish Toast', 'price' => 32000],
            ['name' => 'Crispy Chicken Coleslaw Toast', 'price' => 35000],
        ]);
    }   
}
