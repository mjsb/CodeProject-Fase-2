<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 19/01/2017
 * Time: 15:33
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\Client;
use League\Fractal\TransformerAbstract;

class ClientTransformer extends TransformerAbstract
{

    #protected $defaultIncludes = ['members'];

    public function transform(Client $client) {

        return [

            'id' => $client->id,
            'Nome' => $client->name,
            'Responsável' => $client->responsible,
            'E-mail' => $client->email,
            'Telefone' => $client->phone,
            'Endereço' => $client->address,
            'Obs.' => $client->obs,

        ];
    }

}