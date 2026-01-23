<?php

namespace App\Models\Gratuity;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GratuityStatus extends Model implements Auditable
{
    use HasFactory;

    use \OwenIt\Auditing\Auditable;
    protected $table = 'gratuity_status';

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];

    protected $fillable = [
        'gratuity_id',
        'source_id',
        'dest_id',
        'gratuity_status',
        'comment'
    ];   
    

    public function gratuity()
    {
        return $this->belongsTo(Gratuity::class);
    }
    
}