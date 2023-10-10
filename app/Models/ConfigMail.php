<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigMail extends Model
{
    protected $table= 'config_mails';
    protected $fillable = [
        'mail',
        'password',
        'send'
    ];
    
    public $timestamps = false;

    public function scopeGetList($query) {
        return $query->select('config_mails.*')->orderBy('send', 'ASC');
    }
}
