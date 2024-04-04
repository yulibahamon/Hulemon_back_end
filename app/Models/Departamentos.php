<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Departamentos extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'departments';

    protected $fillable = [
        'name',
        'shortname',
        'country_id'
    ];

    public function cities()
    {
        return $this->hasMany(\App\Models\Ciudad::class);
    }
}
