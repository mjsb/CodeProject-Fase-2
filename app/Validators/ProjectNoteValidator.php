<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 16/01/2017
 * Time: 11:46
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectNoteValidator extends LaravelValidator {

    protected $rules = [

        'title' => 'required',
        'note' => 'required'

    ];

}