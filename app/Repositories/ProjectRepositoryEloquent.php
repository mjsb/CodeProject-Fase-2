<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 13/01/2017
 * Time: 19:13
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\Project;
use Prettus\Repository\Eloquent\BaseRepository;

class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{

        public function model(){

            return Project::class;
            
        }
}