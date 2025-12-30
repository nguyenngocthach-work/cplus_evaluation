<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $table = "project";

    protected $fillable = [
        'project_name',
        'clientId',
        'industry_id',
        'start_day',
        'end_day',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongTo(User::class, 'userId');
    }

    public function industry()
    {
        return $this->belongTo(Industry::class, 'industry_id');
    }

    public function client()
    {
        return $this->belongTo(Client::class, 'clientId');
    }
}