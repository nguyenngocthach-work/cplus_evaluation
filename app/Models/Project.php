<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    //
    use SoftDeletes;
    protected $table = "project";

    protected $primaryKey = 'project_id';

    protected $fillable = [
        'project_name',
        'description',
        'userId',
        'clientId',
        'industry_id',
        'start_date',
        'end_date',
        'status'
    ];

    protected $dates = ['deleted_at'];

    public $timestamps = true;

    public function getRouteKeyName()
    {
        return 'project_id';
    }

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

    public function criteria()
    {
        return $this->belongsToMany(
            Criteria::class,
            'project_criteria',
            'project_id',
            'criteria_id'
        )->withPivot(['weight', 'custom_description']);
    }

    public function judgment()
    {
        return $this->hasOne(Judgment::class, 'project_id', 'project_id');
    }
}