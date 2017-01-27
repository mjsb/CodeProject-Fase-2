<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProjectFile extends Model implements Transformable
{
    //
    use TransformableTrait;

    protected $fillable = [

        'name',
        'description',
        'extension'

    ];

    public function project() {

        return $this->belongsTo(Project::class);

    }

    public function user() {

        return $this->belongsTo(User::class, 'owner_id');

    }

    public function notes() {

        return $this->hasMany(ProjectNote::class);

    }

    public function members() {

        return $this->belongsToMany(User::class,'project_members','project_id','member_id');

    }
}
