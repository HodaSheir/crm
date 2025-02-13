<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        if(Auth::guard('admin')->user()){
            $employees = Employee::all();
            $customers = Customer::all();
            return view('admin.dashboard', compact('employees', 'customers'));
        }
        return redirect()->route('admin.login');
      
    }

    public function assignCustomerToEmployee(Request $request, $customerId)
    {
        if (Auth::guard('admin')->user()) {
            $customer = Customer::findOrFail($customerId);
            $employee = Employee::findOrFail($request->employee_id);

            $customer->employees()->attach($employee->id);

            return redirect()->back()->with('success', 'Customer assigned to employee successfully.');
        }
        return redirect()->route('admin.login');
    }
}
