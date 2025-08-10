<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offices =
            [
                [
                    'name' => 'Kantor Pusat Jakarta',
                    'address' => 'Jl. Merdeka No. 1, Jakarta Pusat',
                    'phone' => '021-12345678',
                    'latitude' => -6.175392,
                    'longitude' => 106.827153,
                ],
                [
                    'name' => 'Cabang Surabaya',
                    'address' => 'Jl. Kenjeran No. 45, Surabaya',
                    'phone' => '031-87654321',
                    'latitude' => -7.245971,
                    'longitude' => 112.737826,
                ],
                [
                    'name' => 'Cabang Bandung',
                    'address' => 'Jl. Asia Afrika No. 22, Bandung',
                    'phone' => '022-11223344',
                    'latitude' => -6.921857,
                    'longitude' => 107.607592,
                ],
                [
                    'name' => 'Cabang Medan',
                    'address' => 'Jl. Gatot Subroto No. 10, Medan',
                    'phone' => '061-44332211',
                    'latitude' => 3.595196,
                    'longitude' => 98.672223,
                ],
            ];

        foreach ($offices as $office) {
            Office::firstOrCreate(['name' => $office['name']], $office);
        }
    }
}
