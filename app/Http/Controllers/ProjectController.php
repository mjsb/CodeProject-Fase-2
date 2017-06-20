<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $repository;
    private $service;

    public function __construct(ProjectRepository $repository, ProjectService $service )
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index()
    {

        return $this->repository->findWhere(['owner_id'=>\Authorizer::getResourceOwnerId()]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        #return Project::create($request->all());
        return $this->repository->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       /* try {

            if($this->checkProjectPermissions($id) == false) {

                return ['error'=>true, 'Acesso não permitido!'];

            }

            return $this->repository->find($id);

        } catch (ModelNotFoundException $e) {

            return ['error'=>true, 'Projeto não encontrado!'];

        }*/

        #return $this->service->show($id);
        try {

            return $this->repository->with(['owner', 'client'])->find($id);

        } catch (ModelNotFoundException $e) {

            return $this->erroMsgm('Projeto não encontrado.');

        } catch (NoActiveAccessTokenException $e) {

            return $this->erroMsgm('Usuário não está logado.');

        } catch (\Exception $e) {

            return $this->erroMsgm('Ocorreu um erro ao exibir o projeto.');

        }

    }

    public function member($projectId, $memberId) {

        try {

            if($this->checkProjectPermissions($projectId) == false) {

                return ['error'=>true, 'Acesso não permitido!'];

            }

            return $this->service->isMember($projectId, $memberId);

        } catch (ModelNotFoundException $e) {

            return ['error'=>true, 'Membro não encontrado!'];

        }

    }

    public function showMembers($projectId)
    {

        try {

            if($this->checkProjectPermissions($projectId) == false) {

                return ['error'=>true, 'Acesso não permitido!'];

            }

            return $this->service->showMembers($projectId);

        } catch (ModelNotFoundException $e) {

            return ['error'=>true, 'Projeto não encontrado!'];

        }

    }

    public function addmember($projectId, $memberId){

        return $this->service->addMember($projectId, $memberId);

    }

    public function removemember($projectId, $memberId){

        return $this->service->removeMember($projectId, $memberId);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            if($this->checkProjectPermissions($id) == false) {

                return ['error'=>true, 'Acesso não permitido!'];

            }

            $this->service->update($request->all(), $id);
            return ['error'=>false, 'Projeto atualizado!'];

        } catch (ModelNotFoundException $e) {

            return ['error'=>true, 'Projeto não encontrado!'];

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {

            if($this->checkProjectOwner($id) == false) {
                return ['error'=>true, 'Acesso não permitido!'];
            }

            $this->repository->find($id)->delete();
            return ['success'=>true, 'Projeto excluído com sucesso!'];

        } catch (ModelNotFoundException $e) {

            return ['error'=>true, 'Projeto não encontrado!'];

        } catch (\Exception $e) {

            return ['error'=>true, 'Ocorreu algum erro ao excluir o projeto.'];

        }

    }

    private function checkProjectOwner($projectId) {

        $userId = \Authorizer::getResourceOwnerId();
        return $this->repository->isOwner($projectId, $userId);

    }

    private function checkProjectMember($projectId) {

        $userId = \Authorizer::getResourceOwnerId();
        return $this->repository->hasMember($projectId, $userId);

    }

    private function checkProjectPermissions($projectId) {

        if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)) {

            return true;

        }

        return false;
    }

}
