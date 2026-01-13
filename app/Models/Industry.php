<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industry extends Model
{
    use SoftDeletes;
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

    protected $dates = ['deleted_at'];
    
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
    public function photos()
    {
        return $this->hasMany(PhotosLocation::class, 'industry_id')->orderBy('created_at');
    }
}