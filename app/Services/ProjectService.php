<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 16/01/2017
 * Time: 11:30
 *
 *
 */

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Filesystem\Filesystem;

class ProjectService
{

    /**
     * ProjectService constructor.
     * @param ProjectRepository $repository
     * @param ProjectValidator $validator
    */

    /**
     * @var ProjectRepository
     */
    protected $repository;
    /**
     * @var ProjectValidator
     */
    protected $validator;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Storage
     */
    private $storage;


    public function __construct(ProjectRepository $repository, ProjectValidator $validator, Filesystem $filesystem, Storage $storage)
    {

        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;

    }

    public function create(array $data) {

        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }

    }

    public function update(array $data, $id) {

        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }

    }

    public function addMember($projectId, $memberId) {



    }

    public function removeMember($projectId, $memberId) {



    }

    public function isMember($projectId, $memberId) {

        $project = $this->repository->skipPresenter()->find($projectId);
        if(count($project->members->find($memberId))) {
            return $project->members->find($memberId);
        }

        return ['error' => true, 'Membro não pertence ao projeto!'];

    }

    public function showMembers($projectId) {

        $project = $this->repository->skipPresenter()->find($projectId);
        return $project->members;

    }

    public function createFile(array $data) {

        $project = $this->repository->skipPresenter()->find($data['project_id']);
        #dd($project);
        $projectFile = $project->files()->create($data);

        $this->storage->put($projectFile->id.".".$data['extension'], $this->filesystem->get($data['file']));

    }
}