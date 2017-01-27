<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 16/01/2017
 * Time: 11:46
 */

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator
{

    protected $rules = [

        'name' => 'required|max:255',
        'responsible' => 'required|max:255',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required'

    ];

}