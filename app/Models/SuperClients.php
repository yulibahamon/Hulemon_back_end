<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuperClients extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'super_clients';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'nit',
        'name',
        'address',
        'company_id',
        'country_id',
        'department_id',
        'city_id',
        'contact_name',
        'cellphone',
        'email',
        'url',
        'billing',
        'position',
        'description_categories',
        'whatsapp_numbers_support',
        'whatsapp_number_support_selected',
        'distance_max_seconds',
        'max_offices_secondary',
        'automatic_assignment',
        'max_assigned_services',
        'unallocated_service_mail',
        'minutes_assigned',
        'try_max_send',
        'time_transfer_payment',
        'flag_bonos_coupons',
        'wp_buttons',
        'bono_message',
        'latitud_direccion',
        'longitud_direccion',
        'facebook_social_media',
        'facebook_social_media_url',
        'instagram_social_media',
        'instagram_social_media_url',
        'twitter_social_media',
        'twitter_social_media_url',
        'youtube_social_media',
        'youtube_social_media_url',
        'linkedin_social_media',
        'linkedin_social_media_url',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nit' => 'string',
        'name' => 'string',
        'address' => 'string',
        'company_id' => 'integer',
        'country_id' => 'integer',
        'department_id' => 'integer',
        'city_id' => 'integer',
        'contact_name' => 'string',
        'cellphone' => 'string',
        'email' => 'string',
        'url' => 'string',
        'billing' => 'integer',
        'position' => 'integer',
        'description_categories' => 'string',
        'whatsapp_number_support_selected' => 'integer'

    ];

}
