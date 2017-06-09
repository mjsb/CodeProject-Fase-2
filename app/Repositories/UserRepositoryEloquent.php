<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 07/06/2017
 * Time: 19:13
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{

        public function model(){

            return User::class;
            
        }
}