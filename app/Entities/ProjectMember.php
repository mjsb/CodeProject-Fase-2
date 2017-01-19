<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    //
    protected $fillable = [

        'project_id',
        'member_id'

    ];

    public function client() {

        return $this->belongsTo(Client::class);

    }

    public function user() {

        return $this->belongsTo(User::class, 'owner_id');

    }

    public function notes() {

        return $this->hasMany(ProjectNote::class);

    }
}
