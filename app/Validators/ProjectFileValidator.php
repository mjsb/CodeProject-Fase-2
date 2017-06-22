<?php
namespace CodeProject\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{
    protected $rules = [

        /*'project_id' => 'required',
        'name' => 'required|max:255',
        'file' => 'required|mimes:jpeg,jpg,png,gif,pdf,zip,doc,docx,rar',
        'description' => 'required|max:255',*/

        ValidatorInterface::RULE_CREATE => [
            'file' => 'required|mimes:jpeg,jpg,png,gif,pdf,zip,doc,docx,rar',
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]

    ];

}