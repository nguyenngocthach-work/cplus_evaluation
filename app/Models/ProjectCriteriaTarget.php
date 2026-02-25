<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCriteriaTarget extends Model
{
    protected $table = 'project_criteria_target';

    protected $fillable = [
        'project_id',
        'industry_id',
        'project_criteria_id',
        'criteria_id',
        'parent_criteria_id',
        'criteria_type_id',
        'target_value',
        'weight',
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }

    public function parentCriteria()
    {
        return $this->belongsTo(Criteria::class, 'parent_criteria_id');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }
    public function projectCriteria()
    {
        return $this->belongsTo(ProjectCriteria::class, 'project_criteria_id');
    }
}