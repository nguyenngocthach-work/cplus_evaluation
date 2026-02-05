<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectIndustry extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'industry_id',
    ];

    protected $table = 'project_industry';

    public function project ()
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }

    public function industry ()
    {
        return $this->belongsTo(Industry::class, 'industry_id', 'id');
    }

    public function judgment()
    {
        return $this->hasOne(Judgment::class, 'project_industry_id', 'id');
    }
}
