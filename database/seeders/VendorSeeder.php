<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // [
            //     'vendor_id' => 1,
            //     'opco_id' => 1,
            //     'Jarak' => 110.0, 
            //     'latitude' => -7.07847,  // Latitude
            //     'longitude' => 112.62756, // Longitude
            //     'Vendor' => "Freeport",
            //     'Komoditi' => "Copper Slag",
            //     'Desa' => "Manyarejo",
            //     'Kecamatan' => "Manyar",
            //     'Kabupaten' => "Gresik",
            //     'Kap_ton_thn' =>  900000, 
            //     'Konsumsi_ton_thn' => "Real: 2022: 134.671 ton, 2023: 125.011 ton, Jan-Mei 2024: 64.440 ton Renc: Jun-Des 2024: 60.000 ton, 2025: 160.000 ton, 2026: 160.000 ton",
            // ],
            // [
            //     'vendor_id' => 2,
            //     'opco_id' => 1,
            //     'Jarak' => 104.0, 
            //     'latitude' => -7.14841,  // Latitude
            //     'longitude' => 112.63947, // Longitude
            //     'Vendor' => "Petrokimia",
            //     'Komoditi' => "Purified Gypsum",
            //     'Desa' => "Karangpoh",
            //     'Kecamatan' => "Gresik",
            //     'Kabupaten' => "Gresik",
            //     'Kap_ton_thn' =>1200000, 
            //     'Konsumsi_ton_thn' => "Real: 2022: 139.678 ton, 2023: 185.786 ton, Jan-Mei 2024: 66.645 ton Renc: Jun-Des 2024: 90.000 ton, 2025: 161.000 ton, 2026: 161.000 ton",
            // ],
            // [
            //     'vendor_id' => 3,
            //     'opco_id' => 1,
            //     'Jarak' => 102.0, 
            //     'latitude' => -7.142910,  // Latitude
            //     'longitude' => 112.630540, // Longitude
            //     'Vendor' => "Smelting",
            //     'Komoditi' => "Purified Gypsum",
            //     'Desa' => "Roomo",
            //     'Kecamatan' => "Manyar",
            //     'Kabupaten' => "Gresik",
            //     'Kap_ton_thn' =>720000, 
            //     'Konsumsi_ton_thn' => "Real: 2022: 44.530 ton, 2023: 35.113 ton, Jan-Mei 2024: 36.869 ton Renc: Jun-Des 2024: 40.000 ton, 2025: 50.000 ton, 2026: 60.000 ton",
            // ],
            // [
            //     'vendor_id' => 4,
            //     'opco_id' => 1,
            //     'Jarak' => 175.0, 
            //     'latitude' => -6.449240,  // Latitude
            //     'longitude' => 110.739290, // Longitude
            //     'Vendor' => "PLN TJB",
            //     'Komoditi' => "Purified Gypsum",
            //     'Desa' => "Tubanan",
            //     'Kecamatan' => "Kembang",
            //     'Kabupaten' => "Jepara",
            //     'Kap_ton_thn' =>120000, 
            //     'Konsumsi_ton_thn' => "Real: 2022: 22.963 ton, 2023: 7.090 ton, Jan-Mei 2.",
            // ],
            // [
            //     'vendor_id' => 5,
            //     'opco_id' => 1,
            //     'Jarak' => 16.5, 
            //     'latitude' => -6.811510,  // Latitude
            //     'longitude' => 111.993110, // Longitude
            //     'Vendor' => "PLN Tj. Awar2",
            //     'Komoditi' => "Fly Ash",
            //     'Desa' => "Wadung",
            //     'Kecamatan' => "Jenu",
            //     'Kabupaten' => "Tuban",
            //     'Kap_ton_thn' =>96000, 
            //     'Konsumsi_ton_thn' => "Real: 2022: 61.240 ton, 2023: 59.956 ton, Jan-Mei 2024: 18.875 ton",
            // ],
            // [
            //     'vendor_id' => 6,
            //     'opco_id' => 1,
            //     'Jarak' => 267.0, 
            //     'latitude' => -7.288500,  // Latitude
            //     'longitude' => 112.213240, // Longitude
            //     'Vendor' => "POMI Paiton",
            //     'Komoditi' => "Fly Ash",
            //     'Desa' => "Bhinor",
            //     'Kecamatan' => "Paiton",
            //     'Kabupaten' => "Probolinggo",
            //     'Kap_ton_thn' =>36000, 
            //     'Konsumsi_ton_thn' => "Real: 2022: 139.678 ton, 2023: 185.786 ton, Jan-Mei 2024: 66.645 ton Renc: Jun-Des 2024: 90.000 ton, 2025: 161.000 ton, 2026: 161.000 ton",
            // ],
            // [
            //     'vendor_id' => 7,
            //     'opco_id' => 1,
            //     'Jarak' => 150.0, 
            //     'latitude' => -7.552420,  // Latitude
            //     'longitude' => 112.615190, // Longitude
            //     'Vendor' => "Daesang",
            //     'Komoditi' => "Fly Ash",
            //     'Desa' => "Sedati",
            //     'Kecamatan' => "Ngoro",
            //     'Kabupaten' => "Mojokerto",
            //     'Kap_ton_thn' =>12000, 
            //     'Konsumsi_ton_thn' => "Real: 2022: 8.875 ton, 2023: 11.326 ton, Jan-Mei 2024: 5.273 ton",
            // ],
            // [
            //     'vendor_id' => 8,
            //     'opco_id' => 1,
            //     'Jarak' => 175.0, 
            //     'latitude' => -6.449240,  // Latitude
            //     'longitude' => 110.739290, // Longitude
            //     'Vendor' => "PLN TJB",
            //     'Komoditi' => "Fly Ash",
            //     'Desa' => "Tubanan",
            //     'Kecamatan' => "Kembang",
            //     'Kabupaten' => "Jepara",
            //     'Kap_ton_thn' =>24000, 
            //     'Konsumsi_ton_thn' => "Real: 2022: 10.571 ton, 2023: 8.300 ton, Jan-Mei 2...",
            // ],
            // [
            //     'vendor_id' => 9,
            //     'opco_id' => 2,
            //     'Jarak' => 185.0, 
            //     'latitude' => -7.07847,  // Latitude
            //     'longitude' => 112.62756, // Longitude
            //     'Vendor' => "Freeport",
            //     'Komoditi' => "Copper Slag",
            //     'Desa' => "Manyarejo",
            //     'Kecamatan' => "Manyar",
            //     'Kabupaten' => "Gresik",
            //     'kap_ton_thn' =>  900000, 
            //     'Konsumsi_ton_thn' => "Real: 2022: 34.697 ton, 2023: 22.105 ton, Jan-Mei 2024: 12.019 tonRenc: Jun-Des 2024: 12.000 ton, 2025: 36.000 ton, 2026: 36.000 ton",
            // ],
            [
                'vendor_id' => 10,
                'opco_id' => 2,
                'Jarak' => 104.0, 
                'latitude' => -7.14841,  // Latitude
                'longitude' => 112.63947, // Longitude
                'Vendor' => "Petrokimia",
                'Komoditi' => "Purified Gypsum",
                'Desa' => "Karangpoh",
                'Kecamatan' => "Gresik",
                'Kabupaten' => "Gresik",
                'kap_ton_thn' =>1200000, 
                'Konsumsi_ton_thn' => "Real: 2022: 31.356 ton, 2023: 55.988 ton, Jan-Mei 2024: 17.165 ton Renc: Jun-Des 2024: 20.000 ton, 2025: 42.000 ton, 2026: 42.000 ton",
            ],
            [
                'vendor_id' => 11,
                'opco_id' => 2,
                'Jarak' => 177.0, 
                'latitude' => -7.142910,  // Latitude
                'longitude' => 112.630540, // Longitude
                'Vendor' => "Smelting",
                'Komoditi' => "Purified Gypsum",
                'Desa' => "Roomo",
                'Kecamatan' => "Manyar",
                'Kabupaten' => "Gresik",
                'kap_ton_thn' =>720000, 
                'Konsumsi_ton_thn' => "Real: 2022: - , 2023: 6.230 ton, Jan-Mei 2024: -  Renc: Jun-Des 2024: - , 2025: 2.000 ton, 2026: -",
            ],
            [
                'vendor_id' => 12,
                'opco_id' => 2,
                'Jarak' => 119.0, 
                'latitude' => -6.449240,  // Latitude
                'longitude' => 110.739290, // Longitude
                'Vendor' => "PLN TJB",
                'Komoditi' => "Purified Gypsum",
                'Desa' => "Tubanan",
                'Kecamatan' => "Kembang",
                'Kabupaten' => "Jepara",
                'kap_ton_thn' =>120000, 
                'Konsumsi_ton_thn' => "Real: 2022: 1.392 ton, 2023: 14.744 ton, Jan-Mei 2024: 8.035 ton Renc: Jun-Des 2024: 12.000 ton, 2025: 36.000 ton, 2026: 36.000 ton",
            ],
            [
                'vendor_id' => 13,
                'opco_id' => 2,
                'Jarak' => 119.0, 
                'latitude' => -6.449240,  // Latitude
                'longitude' => 110.739290, // Longitude
                'Vendor' => "PLN TJB",
                'Komoditi' => "Fly Ash",
                'Desa' => "Tubanan",
                'Kecamatan' => "Kembang",
                'Kabupaten' => "Jepara",
                'kap_ton_thn' =>24000, 
                'Konsumsi_ton_thn' => "Real: 2022: 3.614 ton, 2023: 13.205 ton, Jan-Mei 2024: 1.341 ton",
            ],
        ];

        DB::table('m_vendor')->insert($data);
    }
}
