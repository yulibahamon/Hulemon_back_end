<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedesSociales extends Model
{
    use HasFactory;


    public $table = 'establishment_social_media';


    public $fillable = [
        'social_network',
        'url',
        'super_client_id',
        'status'
    ];

    public function red_social()
    {
        return $this->belongsTo(ElementosOpcion::class, 'social_network', 'id');
    }
}
