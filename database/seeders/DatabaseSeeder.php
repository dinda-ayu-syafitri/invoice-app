<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Counter;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Counter::factory(1)->create();
        // \App\Models\Product::factory(5)->create();
        // \App\Models\Customer::factory(5)->create();
        // \App\Models\Invoice::factory(5)->create();
        \App\Models\InvoiceItem::factory(5)->create();
    }
}
