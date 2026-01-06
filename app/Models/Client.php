<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    
    protected $table = 'clients';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'client_name',
        'contact_number',
        'notes',
        'email',
        'company_name',
        'client_contact_name',
        'client_active',
        'userId',
        'project_id',
    ];

    protected $dates = ['deleted_at'];
    
    public $timestamps = true;

    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }   
    public function location()
    {
        return $this->hasOne(ClientLocation::class, 'client_id', 'id');
    }
}