<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackWorkProgress extends Model
{
    protected $table= 'trackworkprogress';
    protected $fillable = [
        'id',
        'thang',
        'quy',
        'donvichutri',
        'doiviphoihop',
        'content',
        'note',
        'status',
        'minhchung',
        'file',
        'quyetdinh'
    ];
}
