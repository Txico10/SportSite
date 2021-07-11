<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogsParameter extends Model
{
    protected $fillable = ['title','description','icon'];

    public function logs()
    {
        return $this->hasMany(Log::class, 'logs_parameter_id', 'id');
    }
}
