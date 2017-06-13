<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 16/01/2017
 * Time: 11:30
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectNoteService
{

    /**
     * ClientService constructor.
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteValidator $validator
    */

    protected $repository;
    protected $validator;

    public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
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

        // enviar email
        // didparar notificação
        // postar tweet

        #return$this->repository->create($data);

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

    /*

    public function show($noteId) {

        try{

            return  $this->repository->find($noteId);

        }catch (ModelNotFoundException $e) {

            return [

                'error'=>true,
                'message'=>'nota nao encontrado!'

            ];

        }catch (QueryException $e){

            return[

                'error'=>true,
                'message'=>'Erro'

            ];

        }catch (Exception $e){

            return[

                'error'=>true,
                'message'=>'Ocorreu algum erro ao buscar este nota'

            ];

        }

    }

    public function delete($noteId) {

        try {

            $this->repository->delete($noteId);

            return [

                'success'=>true,
                'message' => 'nota deletada com sucesso!'

            ];

        } catch (ModelNotFoundException $e) {

            return [

                'error' => true,
                'message' => 'nota nao encontrado!'

            ];

        } catch (QueryException $e) {

            return [

                'error' => true,
                'message' => 'Erro'

            ];

        } catch (Exception $e) {

            return [

                'error' => true,
                'message' => 'Ocorreu algum erro ao deletar este nota'

            ];

        }

    }*/
}