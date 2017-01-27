<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


class ProjectFileController extends Controller
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
        //
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

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['project_id'] = $request->project_id;
        $data['description'] = $request->description;

        $this->service->createFile($data);

        //Storage::put($request->name.".".$extension, File::get($file));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {

            if($this->checkProjectPermissions($id) == false) {

                return ['error'=>true, 'Acesso não permitido!'];

            }

            return $this->repository->find($id);

        } catch (ModelNotFoundException $e) {

            return ['error'=>true, 'Projeto não encontrado!'];

        }

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
            return ['success'=>false, 'Projeto excluído com sucesso!'];

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
