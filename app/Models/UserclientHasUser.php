<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserclientHasUser extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'userclient_has_user';

    public $fillable = [
        'id_user_client',
        'id_user',
        'phone',
        'email',
        'origen'
    ];
}
