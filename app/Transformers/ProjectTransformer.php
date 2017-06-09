<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 19/01/2017
 * Time: 15:33
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['members'];

    public function transform(Project $project) {

        return [

            'id' => $project->id,
            'Cliente' => $project->client_id,
            'Proprietário' => $project->owner_id,
            'Projeto' => $project->name,
            'Descrição' => $project->description,
            'Progresso' => $project->progress,
            'Status' => $project->status,
            'Prazo' => $project->due_date,

        ];
    }

    public function includeMembers(Project $project) {

        return $this->collection($project->members, new ProjectMemberTransformer());

    }

}