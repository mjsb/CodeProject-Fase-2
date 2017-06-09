<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Entities\ProjectMember;

/**
 * Class ProjectMemberRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectMemberRepositoryEloquent extends BaseRepository implements ProjectMemberRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectMember::class;
    }

   /* public function hasMember($projectId, $memberId) {

        $project-note = $this->skipPresenter()->find($projectId);
        foreach($project-note->members as $member) {

            if($member->id == $memberId) {
                return true;
            }
        }

        return false;

    }*/

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
