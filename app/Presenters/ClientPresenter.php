<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 19/01/2017
 * Time: 16:36
 */

namespace CodeProject\Presenters;

use CodeProject\Transformers\ClientTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ClientPresenter extends FractalPresenter
{

    public function getTransformer()
    {

        return new ClientTransformer();

    }
}