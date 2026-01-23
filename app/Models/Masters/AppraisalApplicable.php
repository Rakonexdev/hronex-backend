<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraisalApplicable extends Model
{
    use HasFactory;
    protected $table = "appraisal_applicable";
    protected $fillable = [
'applicable','status'
    ];
}
