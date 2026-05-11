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
        'notes_1',
        'notes_2',
        'notes_3',
        'notes_4',
        'userId',
        'clientId',
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

    public function industries()
    {
        return $this->belongsToMany(
            Industry::class,
            'project_industry',
            'project_id',
            'industry_id'
        )->whereNull('project_industry.deleted_at');
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
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }

    public function projectIndustries()
    {
        return $this->hasMany(ProjectIndustry::class, 'project_id', 'project_id');
    }

    public function targets()
    {
        return $this->hasMany(
            ProjectCriteriaTarget::class,
            'parent_criteria_id',
            'criteria_id'
        )->whereColumn(
            'project_criteria_target.project_id',
            'project_criteria.project_id'
        );
    }
}