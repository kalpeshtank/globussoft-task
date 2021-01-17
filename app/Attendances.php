<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendances extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'month', 'year', 'in_time', 'out_time', 'is_late', 'is_early', 'is_holiday'
    ];

}
