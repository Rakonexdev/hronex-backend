<?php

namespace App\Models;
use App\Models\AppraisalReport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appraisal extends Model
{
    use HasFactory;
    public function appraisalReport()
    {
        return $this->belongsTo(AppraisalReport::class);
    }
}
