<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = faker::create();
        for ($i = 0; $i < 5; $i++) {
             \App\Models\Product::truncate(); // hapus semua dulu
            \App\Models\Kategori::create([
                'nama_kategori' => $faker->sentence(2),
                'slug' => $faker->slug,
                'deskripsi' => $faker->paragraph(2),
            ]);
        }
    }
}
