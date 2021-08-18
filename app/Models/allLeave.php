<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class allLeave extends Model
{
    use HasFactory;

    public function empolyee()
    {
        return $this->belongsTo('App\Employee');
    }

}
