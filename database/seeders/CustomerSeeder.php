<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'Customer One',
            'email' => 'customer1@example.com',
            'phone' => '1234567890',
        ]);

        Customer::create([
            'name' => 'Customer Two',
            'email' => 'customer2@example.com',
            'phone' => '0987654321',
        ]);
    }
}
