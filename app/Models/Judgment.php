<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Judgment extends Model
{
    protected $table = 'judgment';

    protected $fillable = [
        'project_industry_id',
        'project_id',
        'total_score',
        'evaluator_notes',
    ];

    public $timestamps = true;

    public function projectIndustry()
    {
        return $this->belongsTo(ProjectIndustry::class, 'project_industry_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(JudgmentDetail::class, 'judgment_id');
    }
}