<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;


class ProjectService {

    protected $repository;
    protected $validator;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator) {

        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data) {

        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        }
        catch(ValidatorException $e){
            $error = $e->getMessageBag();
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

    public function update(array $data, $id) {

        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        }
        catch(ValidatorException $e){
            $error = $e->getMessageBag();
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

    public function checkProjectOwner($projectId) {

        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->isOwner($projectId,$userId);
    }

    public function checkProjectMember($projectId) {

        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->hasMember($projectId,$userId);
    }

    public function checkProjectPermissions($projectId) {

        if($this->checkProjectOwner($projectId) || $this->checkProjectMember($projectId)){
            return true;
        }

        return false;
    }
}