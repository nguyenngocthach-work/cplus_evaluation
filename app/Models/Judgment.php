<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Judgment extends Model
{
    protected $table = 'judgment';

    protected $fillable = [
        'project_id',
        'total_score',
        'evaluator_notes',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    public function details()
    {
        return $this->hasMany(JudgmentDetail::class, 'judgment_id');
    }
}