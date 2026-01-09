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
        'judgment_id',
        'criteriaId',
        'criteria_point',
        'criteria_percentage',
        'criteria_parent_id',
        'criteria_type',
        'criteria_name',
        'count',
    ];

    protected $dates = ['deleted_at'];

    public $timestamps = true;

    public function judgment()
    {
        return $this->belongsTo(Judgment::class, 'judgment_id');
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'criteriaId');
    }
}