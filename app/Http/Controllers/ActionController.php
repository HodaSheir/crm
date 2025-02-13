<?php

namespace App\Http\Controllers;

use App\Models\Action;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function store(Request $request)
    {
        Action::create($request->all());
        return redirect()->back()->with('success', 'Action recorded successfully.');
    }

    public function update(Request $request, Action $action)
    {
        // Authorization check (only the employee who created the action can update it)
        if (auth()->guard('employee')->check() && $action->employee_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'result' => 'required|string|max:500',
        ]);

        $action->update([
            'result' => $request->result,
        ]);

        return redirect()->back()->with('success', 'Action updated successfully!');
    }
}
