<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 13/01/2017
 * Time: 19:13
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\Project;
use CodeProject\Presenters\ProjectPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{

    public function model(){

        return Project::class;

    }

    /**
     * Boot up the repository, pushing criteria
     */

    public function isOwner($projectId, $userId) {

        if(count($this->findWhere(['id' => $projectId, 'owner_id' => $userId]))) {
            return true;
        }

        return false;
    }

    public function hasMember($projectId, $memberId) {

        $project = $this->find($projectId);
        foreach($project->members as $member) {

            if($member->id == $memberId) {
                return true;
            }
        }

        return false;

    }

    public function presenter() {

        return ProjectPresenter::class;

    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}