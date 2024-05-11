<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Eliminar las imagenes
        Storage::deleteDirectory('products');
        //crear una carpeta "products"
        Storage::makeDirectory('products');
        // \App\Models\User::factory(10)->create();
         \App\Models\User::factory()->create([
             'name' => 'Brayan',
             'last_name' => 'Sonco Machaca',
             'document_type' => '1',
             'document_number' => '87654321',
             'phone' => '12345678',
             'email' => 'brayansoncom@gmail.com',
             'password' => bcrypt('password'),
         ]);
        $this->call([
            FamilySeeder::class,
            OptionSeeder::class,
        ]);
        Product::factory(1500)->create();
    }
}
