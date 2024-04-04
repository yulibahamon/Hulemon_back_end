<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTimeLines extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'order_time_lines';


    public $fillable = [
        'id',
        'order_id',
        'ldn_id',
        'accumulated_time',
        'time1',
        'time2',
        'time3',
        'time4',
        'time5',
        'time6',
        'time7',
        'time8',
        'time9',
        'time10',
        'latlng1',
        'latlng2',
        'latlng3',
        'latlng4',
        'latlng5',
        'latlng6',
        'latlng7',
        'latlng8',
        'latlng9',
        'latlng10',
    ];
}
