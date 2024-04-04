<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'status';


    public $fillable = [
        'ldn_id',
        'name',
        'position',
        'logoCompleted',
        'logoIncomplete',
        'flag_cancel',
        'flag_delivered',
        'flag_messenger',
        'color',
        'stage',
        'operator',
        'value'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ldn_id' => 'integer',
        'name' => 'string',
        'position' => 'integer',
        'logoCompleted' => 'string',
        'logoIncomplete' => 'string',
        'flag_cancel' => 'integer',
        'flag_delivered' => 'integer',
        'flag_messenger' => 'integer',
        'color' => 'string',
        'stage' => 'integer',
        'operator' => 'string',
        'value' => 'integer'
    ];
}
