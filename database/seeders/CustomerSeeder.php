<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $locations = ['Banani', 'Gulshan', 'Baridhara', 'Uttara', 'Dhanmondi', 'Mirpur', 'Mohakhali'];

        // Generate customers 3 to 150
        for ($i = 3; $i <= 150; $i++) {
            Customer::create([
                'name' => "Customer $i",
                'email' => "customer_$i@gmail.com",
                'phone_number' => '017' . rand(10000000, 99999999), // random valid BD phone
                'location' => $locations[array_rand($locations)],
            ]);
        }
    }
}
