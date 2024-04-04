<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasSuperclients extends Model
{
    use HasFactory;
    protected $table = 'user_has_superclients';

     protected $fillable = [
         'user_id',
         'superclient_id',
         'state',
     ];
 
     public function user()
     {
         return $this->belongsTo(User::class, 'user_id');
     }
 
     public function superclient()
     {
         return $this->belongsTo(SuperClients::class, 'superclient_id');
     }
}
