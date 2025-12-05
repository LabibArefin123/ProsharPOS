<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $suppliers = [
            [
                'name' => 'Abdul Karim',
                'email' => 'abdul.karim@example.com',
                'phone_number' => '01711000001',
                'company_name' => 'Karim Trade International',
                'company_number' => 'CTI-1001',
                'license_number' => 'LIC-2024501',
                'location' => 'Dhaka, Bangladesh',
            ],
            [
                'name' => 'Md. Rafiq Hasan',
                'email' => 'rafiq.hasan@example.com',
                'phone_number' => '01711000002',
                'company_name' => 'Hasan Enterprise',
                'company_number' => 'HE-1002',
                'license_number' => 'LIC-2024502',
                'location' => 'Chattogram, Bangladesh',
            ],
            [
                'name' => 'Sadia Ahmed',
                'email' => 'sadia.ahmed@example.com',
                'phone_number' => '01822000003',
                'company_name' => 'Sadia Trading Co.',
                'company_number' => 'STC-1003',
                'license_number' => 'LIC-2024503',
                'location' => 'Sylhet, Bangladesh',
            ],
            [
                'name' => 'Kamrul Islam',
                'email' => 'kamrul.islam@example.com',
                'phone_number' => '01933000004',
                'company_name' => 'Islam Supply House',
                'company_number' => 'ISH-1004',
                'license_number' => 'LIC-2024504',
                'location' => 'Khulna, Bangladesh',
            ],
            [
                'name' => 'Nusrat Jahan',
                'email' => 'nusrat.jahan@example.com',
                'phone_number' => '01644000005',
                'company_name' => 'Jahan Distribution',
                'company_number' => 'JD-1005',
                'license_number' => 'LIC-2024505',
                'location' => 'Rajshahi, Bangladesh',
            ],
            [
                'name' => 'Shahidul Alam',
                'email' => 'shahidul.alam@example.com',
                'phone_number' => '01555000006',
                'company_name' => 'Alam Logistics',
                'company_number' => 'AL-1006',
                'license_number' => 'LIC-2024506',
                'location' => 'Barishal, Bangladesh',
            ],
            [
                'name' => 'Mariya Sultana',
                'email' => 'mariya.sultana@example.com',
                'phone_number' => '01766000007',
                'company_name' => 'Sultana Trade Link',
                'company_number' => 'STL-1007',
                'license_number' => 'LIC-2024507',
                'location' => 'Rangpur, Bangladesh',
            ],
            [
                'name' => 'Jamil Hossain',
                'email' => 'jamil.hossain@example.com',
                'phone_number' => '01477000008',
                'company_name' => 'Jamil Import & Export',
                'company_number' => 'JIE-1008',
                'license_number' => 'LIC-2024508',
                'location' => 'Mymensingh, Bangladesh',
            ],
            [
                'name' => 'Farhana Akter',
                'email' => 'farhana.akter@example.com',
                'phone_number' => '01788000009',
                'company_name' => 'Akter Supplies',
                'company_number' => 'AS-1009',
                'license_number' => 'LIC-2024509',
                'location' => 'Gazipur, Bangladesh',
            ],
            [
                'name' => 'Mahmudul Hasan',
                'email' => 'mahmudul.hasan@example.com',
                'phone_number' => '01899000010',
                'company_name' => 'Hasan Tools & Parts',
                'company_number' => 'HTP-1010',
                'license_number' => 'LIC-2024510',
                'location' => 'Narayanganj, Bangladesh',
            ],
            [
                'name' => 'Rubina Chowdhury',
                'email' => 'rubina.chowdhury@example.com',
                'phone_number' => '01712000011',
                'company_name' => 'Chowdhury Traders',
                'company_number' => 'CT-1011',
                'license_number' => 'LIC-2024511',
                'location' => 'Cumilla, Bangladesh',
            ],
            [
                'name' => 'Shamim Reza',
                'email' => 'shamim.reza@example.com',
                'phone_number' => '01623000012',
                'company_name' => 'Reza Hardware Mart',
                'company_number' => 'RHM-1012',
                'license_number' => 'LIC-2024512',
                'location' => 'Bogra, Bangladesh',
            ],
            [
                'name' => 'Tasnim Hossain',
                'email' => 'tasnim.hossain@example.com',
                'phone_number' => '01834000013',
                'company_name' => 'Tasnim Industrial Supply',
                'company_number' => 'TIS-1013',
                'license_number' => 'LIC-2024513',
                'location' => 'Jashore, Bangladesh',
            ],
            [
                'name' => 'Rashid Ahmed',
                'email' => 'rashid.ahmed@example.com',
                'phone_number' => '01945000014',
                'company_name' => 'Ahmed Engineering Works',
                'company_number' => 'AEW-1014',
                'license_number' => 'LIC-2024514',
                'location' => 'Feni, Bangladesh',
            ],
            [
                'name' => 'Parvin Akhter',
                'email' => 'parvin.akhter@example.com',
                'phone_number' => '01756000015',
                'company_name' => 'Akhter Supply Chain',
                'company_number' => 'ASC-1015',
                'license_number' => 'LIC-2024515',
                'location' => 'Tangail, Bangladesh',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
