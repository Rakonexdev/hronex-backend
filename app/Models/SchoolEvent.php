<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SchoolEvent extends Model implements Auditable
{
    use HasFactory;

    use \OwenIt\Auditing\Auditable;
    protected $table = 'school_events';

    protected $auditEvents = [
        'created',
        'updated',
        'deleted'
    ];

    protected $fillable = [
        'event_title',
        'academic_year',
        'event_details',
        'event_from',
        'event_to',
        'event_type',
        'event_time_from',
        'event_time_to',
        'applicable_to',
        'bg_color',
        'created_by',
        'updated_by'
    ];

    protected $guarded = [];
}
