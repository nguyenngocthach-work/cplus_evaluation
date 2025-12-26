<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    //
    protected $table = 'industry';
    
    protected $fillable = [
        'industry_name',
        'description',
        'street',
        'city',
        'state_province',
        'zipcode',
        'country',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}