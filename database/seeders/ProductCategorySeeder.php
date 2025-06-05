<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Smartphone', 'created_at' => Carbon::now()],
            ['category_name' => 'Laptop', 'created_at' => Carbon::now()],
            ['category_name' => 'Tablet', 'created_at' => Carbon::now()],
            ['category_name' => 'Smartwatch', 'created_at' => Carbon::now()],
            ['category_name' => 'Desktop PC', 'created_at' => Carbon::now()],
            ['category_name' => 'Camera', 'created_at' => Carbon::now()],
            ['category_name' => 'Headphones', 'created_at' => Carbon::now()],
            ['category_name' => 'Speakers', 'created_at' => Carbon::now()],
            ['category_name' => 'Television', 'created_at' => Carbon::now()],
            ['category_name' => 'Gaming Console', 'created_at' => Carbon::now()],
            ['category_name' => 'Printer', 'created_at' => Carbon::now()],
            ['category_name' => 'Scanner', 'created_at' => Carbon::now()],
            ['category_name' => 'Monitor', 'created_at' => Carbon::now()],
            ['category_name' => 'Router', 'created_at' => Carbon::now()],
            ['category_name' => 'External Storage', 'created_at' => Carbon::now()],
            ['category_name' => 'Smart Home Device', 'created_at' => Carbon::now()],
            ['category_name' => 'Wearables', 'created_at' => Carbon::now()],
            ['category_name' => 'Drones', 'created_at' => Carbon::now()],
            ['category_name' => 'Projector', 'created_at' => Carbon::now()],
            ['category_name' => 'Networking Equipment', 'created_at' => Carbon::now()],
            ['category_name' => 'Software', 'created_at' => Carbon::now()],
            ['category_name' => 'Accessories', 'created_at' => Carbon::now()],
            ['category_name' => 'Electric Scooter', 'created_at' => Carbon::now()],
            ['category_name' => 'Fitness Tracker', 'created_at' => Carbon::now()],
            ['category_name' => 'Virtual Reality Headset', 'created_at' => Carbon::now()]
        ];

        foreach ($categories as $category) {
            DB::table('product_categories')->insert($category);
        }
    }
}
