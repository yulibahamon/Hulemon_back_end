<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientPTI extends Model
{
    use SoftDeletes;

    public $table = 'pti_clients';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'names',
        'phone',
        'email',
        'city',
        'reason',
        'reasonForContact',
        'clientPTI',
        'file'
    ];

}
