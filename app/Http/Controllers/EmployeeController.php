<?php

namespace App\Http\Controllers;


use App\Models\Customer;
use App\Models\Action;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::all();
        return view('employee.index', compact('employees'));
    }
    public function dashboard()
    {
        $employee = auth()->guard('employee')->user();

        $unassignedCustomers = Customer::whereDoesntHave('employees')->get();
        $myCustomers = $employee->customers;

        return view('employee.dashboard', compact('unassignedCustomers', 'myCustomers'));
    }
    public function create()
    {
        return view('employee.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'password' => ['required', Password::defaults()],
        ]);

        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created!');
    }

    public function edit(Employee $employee)
    {
        return view('employee.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email,' . $employee->id,
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['sometimes', Password::defaults()];
        }

        $request->validate($rules);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $employee->password,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted!');
    }

    public function addAction(Request $request, $customerId)
    {
        $action = new Action([
            'type' => $request->type,
            'result' => $request->result,
            'customer_id' => $customerId,
            'employee_id' => auth()->id(),
        ]);
        $action->save();

        return redirect()->back()->with('success', 'Action added successfully.');
    }
}