<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotosLocation extends Model
{
    //
    protected $table = 'photos_location'; 
    protected $primaryKey = 'img_id';

    public $timestamps = false;

    protected $fillable = [
        'industry_id',
        'img_url',
    ];

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }
}