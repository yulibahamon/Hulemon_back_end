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
        'lastnames',
        'typeDocument',
        'documentNumber',
        'gender',
        'birthday',
        'phone',
        'email',
        'city',
        'reason',
        'restaurant',
        'reasonForContact',
        'clientPTI',
        'file'
    ];

    public $casts = [
        'id' => 'integer',
        'names' => 'string',
        'lastnames' => 'string',
        'typeDocument' => 'integer',
        'documentNumber' => 'string',
        'gender' => 'integer',
        'birthday' => 'date',
        'phone' => 'string',
        'email' => 'string',
        'city' => 'integer',
        'reason' => 'integer',
        'restaurant'  => 'integer',
        'reasonForContact' => 'string',
        'clientPTI' => 'boolean',
        'file' => 'string'
    ];

    public static $rules = [
        'names' => 'required|max:100',
        'lastnames' => 'required|max:100',
        'typeDocument' => 'required|exists:type_documents,id',
        'documentNumber' => 'required|max:100',
        'gender' => 'required|exists:genders,id',
        'birthday' => 'date',
        'phone' => 'required|max:100',
        'email' => 'required|max:191',
        'city' => 'required|exists:cities,id',
        'reason' => 'required|exists:reasons,id',
        'restaurant'  => 'required|exists:offices,id',
        'reasonForContact' => 'required',
        'clientPTI' => 'required'
    ];
}
