<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
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

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['name' => $name],
                [
                    'slug' => Str::slug($name),
                    'description' => $name . ' category',
                    'status' => 1,
                ]
            );
        }
    }
}
