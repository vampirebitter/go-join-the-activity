<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'sponsor_icon','e_card','sponsor_name',
        'contact_name','contact_name',
        'contact_email','project_class',
        'contact_number','student_number',
        'description','website','user_id',
        'is_locked','has_passed','password'
    ];

    public function followers()
    {
        return $this->belongsToMany(User::class,'sponsor_user');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
