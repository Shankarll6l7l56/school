<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseFare extends Model
{
    protected $table ="	base_fares";
    protected $fillable = ['pricing_rule_id','amount'];
}
