<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Category;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        // Category → Brand Mapping
        $brandMap = [

            // Electronics
            'Electronics' => [
                'Walton (Electronics)',
                'Singer (Electronics)',
                'LG (Electronics)',
                'Sony (Electronics)',
                'Sharp (Electronics)',
                'Panasonic (Electronics)',
                'Hisense (Electronics)',
                'Haier (Electronics)',
                'Conion (Electronics)',
            ],

            // Mobile & Accessories
            'Mobile & Accessories' => [
                'Samsung (Mobile)',
                'Xiaomi (Mobile)',
                'Realme (Mobile)',
                'Oppo (Mobile)',
                'Vivo (Mobile)',
                'iPhone (Mobile)',
                'OnePlus (Mobile)',
                'Nokia (Mobile)',
                'Motorola (Mobile)',
                'Huawei (Mobile)',
                'Itel (Mobile)',
                'Tecno (Mobile)',
                'Lava (Mobile)',
                'Symphony (Mobile)',
                'Anker (Mobile)',
                'Remax (Mobile)',
            ],

            // Computer & Laptop
            'Computer & Laptop' => [
                'Dell (Computer)',
                'HP (Computer)',
                'Lenovo (Computer)',
                'Acer (Computer)',
                'Asus (Computer)',
                'Apple (Computer)',
                'Microsoft (Computer)',
                'Gigabyte (Computer)',
                'Corsair (Computer)',
                'Logitech (Computer)',
                'Razer (Computer)',
                'MSI (Computer)',
            ],

            // Home Appliances
            'Home Appliances' => [
                'Marcel (Home Appliance)',
                'Vision (Home Appliance)',
                'Singer (Home Appliance)',
                'Sharp (Home Appliance)',
                'Panasonic (Home Appliance)',
                'Conion (Home Appliance)',
                'Miyako (Home Appliance)',
            ],

            // Kitchen Appliances
            'Kitchen Appliances' => [
                'Miyako (Kitchen)',
                'Philips (Kitchen)',
                'Prestige (Kitchen)',
                'Tefal (Kitchen)',
                'Conion (Kitchen)',
                'Vision (Kitchen)',
            ],

            // Grocery & Food
            'Grocery & Food' => [
                'Pran (Grocery)',
                'Radhuni (Grocery)',
                'Square (Grocery)',
                'ACI Pure (Grocery)',
                'Teer (Grocery)',
                'Fresh (Grocery)',
                'IFAD (Grocery)',
                'Nestle (Grocery)',
                'Bombay Sweets (Grocery)',
                'Olympic (Grocery)',
            ],

            // Beverages
            'Beverages' => [
                'Coca-Cola (Beverage)',
                'Pepsi (Beverage)',
                'Sprite (Beverage)',
                'Mountain Dew (Beverage)',
                'Pran Juice (Beverage)',
                'Shezan (Beverage)',
                'RC Cola (Beverage)',
                '7UP (Beverage)',
                'Red Bull (Beverage)',
            ],

            // Cosmetics & Beauty
            'Cosmetics & Beauty' => [
                'Jui (Cosmetics)',
                'Meril (Cosmetics)',
                'Keya (Cosmetics)',
                'Aromatic (Cosmetics)',
                'Nivea (Cosmetics)',
                'L’Oreal (Cosmetics)',
                'Maybelline (Cosmetics)',
                'MAC (Cosmetics)',
                'Focallure (Cosmetics)',
                'Garnier (Cosmetics)',
            ],

            // Fashion & Clothing
            'Fashion & Clothing' => [
                'Aarong (Fashion)',
                'Yellow (Fashion)',
                'Sailor (Fashion)',
                'Cats Eye (Fashion)',
                'Ecstasy (Fashion)',
                'Infinity (Fashion)',
                'Gucci (Fashion)',
                'Zara (Fashion)',
                'H&M (Fashion)',
            ],

            // Footwear
            'Footwear' => [
                'Apex (Footwear)',
                'Bata (Footwear)',
                'Lotto (Footwear)',
                'Nike (Footwear)',
                'Adidas (Footwear)',
                'Puma (Footwear)',
            ],

            // Stationery & Office Supplies
            'Stationery & Office Supplies' => [
                'Matador (Stationery)',
                'Deli (Stationery)',
                'Kores (Stationery)',
                'Pilot (Stationery)',
                'Faber-Castell (Stationery)',
            ],

            // Furniture
            'Furniture' => [
                'Hatil (Furniture)',
                'Partex (Furniture)',
                'Regal (Furniture)',
                'Otobi (Furniture)',
                'IKEA (Furniture)',
            ],

            // Plastics & Household
            'Plastics & Household' => [
                'RFL Plastics (Household)',
                'Bashundhara (Household)',
                'Kitchen Queen (Household)',
                'Click (Household)',
            ],

            // Hardware & Tools
            'Hardware & Tools' => [
                'Bosch (Hardware)',
                'Makita (Hardware)',
                'Stanley (Hardware)',
                'DeWalt (Hardware)',
                'Black+Decker (Hardware)',
            ],

            // Automobile Accessories
            'Automobile Accessories' => [
                'Mobil (Automobile)',
                'Honda (Automobile)',
                'Yamaha (Automobile)',
                'Toyota (Automobile)',
                'Suzuki (Automobile)',
            ],

            // Sports & Fitness
            'Sports & Fitness' => [
                'Nike (Sports)',
                'Adidas (Sports)',
                'Puma (Sports)',
                'Kappa (Sports)',
                'Decathlon (Sports)',
            ],

            // Toys & Kids
            'Toys & Kids' => [
                'Hot Wheels (Toys)',
                'Barbie (Toys)',
                'Lego (Toys)',
                'Disney (Toys)',
                'Hasbro (Toys)',
            ],

            // Medicine & Healthcare
            'Medicine & Healthcare' => [
                'Square Pharma (Medicine)',
                'ACI Pharma (Medicine)',
                'Beximco Pharma (Medicine)',
                'Incepta (Medicine)',
            ],

            // Watches & Accessories
            'Watches & Accessories' => [
                'Casio (Watch)',
                'Rolex (Watch)',
                'Titan (Watch)',
                'Fossil (Watch)',
                'Tissot (Watch)',
            ],

            // Jewelry
            'Jewelry' => [
                'Aarong Jewelry (Jewelry)',
                'Diamond World (Jewelry)',
                'Apan Jewellers (Jewelry)',
                'Swarovski (Jewelry)',
                'Chowdhury Jewelers (Jewelry)',
            ],

            // Agriculture Supplies
            'Agriculture Supplies' => [
                'ACI Seeds (Agri)',
                'Metal Seeds (Agri)',
                'BRAC Seeds (Agri)',
            ],

            // Pet Supplies
            'Pet Supplies' => [
                'Drools (Pet)',
                'Whiskas (Pet)',
                'Pedigree (Pet)',
                'Me-O (Pet)',
            ],
        ];

        $adminId = 1;

        foreach ($brandMap as $categoryName => $brands) {

            $category = Category::where('name', $categoryName)->first();

            if (!$category) continue;

            foreach ($brands as $brand) {
                Brand::create([
                    'name'        => $brand,
                    'category_id' => $category->id,
                    'description' => $brand . ' brand',
                    'created_by'  => $adminId,
                ]);
            }
        }
    }
}
