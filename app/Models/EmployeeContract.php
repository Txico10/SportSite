<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EmployeeContract extends Pivot
{
    protected $table = 'employee_contracts';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function myCompany()
    {
        return $this->belongsTo(RealState::class, 'real_state_id');
    }
}
