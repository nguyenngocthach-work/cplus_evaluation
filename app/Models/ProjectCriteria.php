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
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}