<?php

namespace App\Models\Masters;
use App\Models\AppraisalReport;
use App\Models\Masters\AppraisalType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appraisal_datas extends Model
{
    use HasFactory;
    protected $table = 'appraisal_data';
    public function appraisalReport()
    {
        return $this->belongsTo(AppraisalReport::class,'id','appraisal_data');
    }
    public function appriasal_type()
    {
        return $this->hasOne(AppraisalType::class,'id','type');
    }
}
