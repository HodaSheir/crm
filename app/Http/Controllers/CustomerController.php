<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = $this->getCustomersBasedOnRole();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        // If admin is logged in, fetch employees for assignment
        if (auth()->guard('admin')->check() || auth()->guard('employee')->check()) {
            $employees = [];

            $employees = Employee::all();
            return view('customers.create', compact('employees'));
        }
        
    }

    public function store(Request $request)
    {
        $validated = $this->validateCustomer($request);
        $customer = Customer::create($validated);
        $this->handleEmployeeAssignment($customer);
        return redirect()->route('customers.index')->with('success', 'Customer created!');

    }

    public function edit(Customer $customer)
    {
        $employees = [];
        if (auth()->guard('admin')->check()) {
            $employees = Employee::all();
        }
        return view('customers.edit', compact('customer', 'employees'));
    }

    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);
        $validated = $this->validateCustomer($request, $customer);
        $customer->update($validated);
        return redirect()->route('customers.index')->with('success', 'Customer updated!');
      
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted!');
    }


    public function show(Customer $customer)
    {
        if (auth()->guard('employee')->check() && !$customer->employees->contains(auth()->id())) {
            abort(403, 'Unauthorized');
        }

        $customer->load('actions.employee');

        return view('customers.show', compact('customer'));
    }
    private function getCustomersBasedOnRole()
    {
        if (Auth::guard('admin')->check()) {
            return Customer::with('employees')->get();
        }

        return Auth::guard('employee')->user()->customers;
    }

    private function validateCustomer(Request $request, ?Customer $customer = null)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                $customer ? 'unique:customers,email,' . $customer->id : 'unique:customers'
            ],
            'phone' => 'nullable|string|max:20',
        ]);
    }

    private function handleEmployeeAssignment(Customer $customer)
    {
        if (Auth::guard('employee')->check()) {
            $employee = Auth::guard('employee')->user();
            $customer->employees()->attach($employee);
        }
    }

}
