<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $table = 'clients';
    
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

    public $timestamps = true;

    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }   
    
}