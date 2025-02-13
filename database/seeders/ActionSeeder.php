<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Action;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = Customer::first();
        $employee = Employee::first();

        Action::create([
            'customer_id' => $customer->id,
            'employee_id' => $employee->id,
            'type' => 'call',
            'result' => 'Customer was interested in the product.',
        ]);

        Action::create([
            'customer_id' => $customer->id,
            'employee_id' => $employee->id,
            'type' => 'visit',
            'result' => 'Customer requested a demo.',
        ]);
    }
}
