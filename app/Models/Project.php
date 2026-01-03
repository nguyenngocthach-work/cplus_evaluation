<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $table = "project";

    protected $fillable = [
        'project_name',
        'description',
        'userId',
        'clientId',
        'industry_id',
        'start_date',
        'end_date',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'clientId');
    }

    public function projectCriteria()
    {
        return $this->hasMany(ProjectCriteria::class, 'project_id');
    }
}