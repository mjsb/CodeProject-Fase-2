<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectFileValidator;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Filesystem\Filesystem;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class ProjectFileService {

    protected $repository;
    protected $projectRepository;
    protected $validator;
    private $fileSystem;
    private $storage;

    public function __construct(ProjectFileRepository $repository, ProjectRepository $projectRepository, ProjectFileValidator $validator, Filesystem $filesystem, Storage $storage){

        $this->repository = $repository;
        $this->projectRepository = $projectRepository;
        $this->validator = $validator;
        $this->fileSystem = $filesystem;
        $this->storage = $storage;

    }

    public function create(array $data) {

        try{
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
            $project = $this->projectRepository->skipPresenter()->find($data['project_id']);
            $projectFile = $project->files()->create($data);
            $this->storage->put($projectFile->getFileName(), $this->fileSystem->get($data['file']));

            return $projectFile;
        }
        catch(ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

    public function update(array $data, $id) {

        try{
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            return $this->repository->update($data, $id);
        }
        catch(ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

    public function delete($id) {

        $projectFile = $this->repository->skipPresenter()->find($id);
        if($this->storage->exists($projectFile->getFileName())) {
            $this->storage->delete($projectFile->getFileName());
            $projectFile->delete();
        }
    }

    public function getFilePath($id) {

        $projectFile = $this->repository->skipPresenter()->find($id);
        return $this->getBaseURL($projectFile);

    }

    private function getBaseURL($projectFile) {

        switch ($this->storage->getDefaultDriver()){
            case 'local':
                return $this->storage->getDriver()->getAdapter()->getPathPrefix()
                    .'/'.$projectFile->getFileName();
        }
    }

    public function getFileName($id) {

        $projectFile = $this->repository->skipPresenter()->find($id);
        return $projectFile->getFileName();

    }

}