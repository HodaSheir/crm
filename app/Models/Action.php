<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = ['customer_id', 'employee_id', 'type', 'result'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
