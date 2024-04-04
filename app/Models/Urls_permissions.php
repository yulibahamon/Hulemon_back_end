<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urls_permissions extends Model
{
    use HasFactory;
    protected $table = 'urls_permissions';

    protected $fillable = [
        'urls_crm_id',
        'id_user',
        //permisos para usuarios
        'visual_users',
        'edit_create_users',
        //permisos para clientes
        'visual_clientes',
        'edit_create_clientes',
    ]; 

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_user');
    }
}

