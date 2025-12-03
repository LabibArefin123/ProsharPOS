<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Mobile & Accessories',
            'Computer & Laptop',
            'Home Appliances',
            'Kitchen Appliances',
            'Grocery & Food',
            'Beverages',
            'Cosmetics & Beauty',
            'Fashion & Clothing',
            'Footwear',
            'Stationery & Office Supplies',
            'Furniture',
            'Plastics & Household',
            'Hardware & Tools',
            'Automobile Accessories',
            'Sports & Fitness',
            'Toys & Kids',
            'Medicine & Healthcare',
            'Watches & Accessories',
            'Jewelry',
            'Agriculture Supplies',
            'Pet Supplies',
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name'        => $cat,
                'slug'        => Str::slug($cat),
                'description' => $cat . ' category',
                'status'      => 1,
            ]);
        }
    }
}
