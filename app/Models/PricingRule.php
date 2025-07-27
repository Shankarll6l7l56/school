<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model
{
    protected $table = "pricing_rules";

    protected $fillable = ['rule_type','name','description','is_active'];
}
