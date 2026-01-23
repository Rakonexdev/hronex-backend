<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraisalType extends Model
{
    use HasFactory;
    protected $table = "appraisal_type";
    protected $fillable = [
        'type_name','active'
    ];
}
