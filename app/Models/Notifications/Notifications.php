<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'notify_to',
        'title',
        'data',
        'title_date',
        'link',
        'pushed_at',
        'read_at'
    ];

    protected $guarded = [];

}
