<?php

namespace Database\Seeders;

use App\Models\page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        page::create([
            'name' => 'Contact Us',
            'slug' => 'contact-us',
            'content' => '<h2 class=""><span style="font-family: Helvetica;"><br></span></h2><h2 class=""><span style="font-family: Helvetica;"><br></span></h2><h2 class=""><span style="font-family: Helvetica;">No dolore ipsum accusam no lorem.</span></h2><h3 class="">123 Street, New York, USA<br>exampl@example.com<br>000 000 0000</h3>',
        ]);
    }
}