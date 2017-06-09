<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 19/01/2017
 * Time: 15:33
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectNote;
use League\Fractal\TransformerAbstract;

class ProjectNoteTransformer extends TransformerAbstract
{

    #protected $defaultIncludes = ['members'];

    public function transform(ProjectNote $project) {

        return [

            'id' => $project->id,
            'Projeto' => $project->project_id,
            'Título' => $project->title,
            'Nota' => $project->note,

        ];
    }

}