<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhotosLocation extends Model
{
    use SoftDeletes;
    
    protected $table = 'photos_location'; 
    protected $primaryKey = 'img_id';
    protected $dates = ['deleted_at'];
    
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