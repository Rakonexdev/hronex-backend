<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScfData extends Model
{
    use HasFactory;
    protected $table = "scf_data";
    protected $fillable =[
        'scf','status'
    ];
}
