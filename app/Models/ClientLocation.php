<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLocation extends Model
{
    //
    protected $table = 'client_locations';

    protected $fillable = [
        'client_location_id',
        'client_HQ',
        'client_billing',
        'client_country',
        'client_city',
        'client_state_province',
        'client_zipcode',
        'client_id',
    ];

    public $timestamps = true;

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}