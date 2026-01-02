<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCriteria extends Model
{
    //
    protected $table = 'project_criteria';

    protected $fillable = [
        'project_id',
        'criteria_id',
        'weight',
        'custom_description',
    ];

    public function criteria()
    {
        return $this->belongsToMany(Criteria::class, 'project_criteria')
            ->withPivot(['weight', 'custom_description'])
            ->withTimestamps();
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_criteria')
            ->withPivot(['weight', 'custom_description'])
            ->withTimestamps();
    }
}