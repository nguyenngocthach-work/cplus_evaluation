<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JudgmentDetail extends Model
{
    //
    use SoftDeletes;

    protected $table = 'judgment_detail';

    protected $fillable = [
        'sessionId',
        'criteriaId',
        'projectId',
        'criteria_point',
        'criteria_name',
        'evaluator_notes',
        'total_score',
    ];
}