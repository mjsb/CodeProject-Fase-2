<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 13/01/2017
 * Time: 19:13
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{

        public function model(){

            return Client::class;
            
        }
}