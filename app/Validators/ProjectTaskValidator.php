<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 16/01/2017
 * Time: 11:46
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectTaskValidator extends LaravelValidator {

    protected $rules = [

        'name' => 'required|max:255',
        'start_date' => 'date',
        'due_date' => 'date',
        'status' => 'integer',

    ];

}