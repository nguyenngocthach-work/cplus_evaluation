<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    //
    protected $table = 'criteria';

    protected $fillable = [
        'criteriaPercent',
    ];

    public $timestamps = true;

    public function type()
    {
        return $this->belongsTo(CriteriaType::class, 'criteriaTypeId');
    }

    public function parent()
    {
        return $this->belongsTo(Criteria::class, 'parentId');
    }

    public function children()
    {
        return $this->hasMany(Criteria::class, 'parentId');
    }

}