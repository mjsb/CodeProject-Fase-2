<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;
use Illuminate\Http\Request;

class ProjectFileController extends Controller {

    /**
     * @var ProjectFileRepository
     */
    private $repository;

    /**
     * @var ProjectFileService
     */
    private $service;

    public function __construct(ProjectFileRepository $repository, ProjectFileService $service) {

        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {

        return $this->repository->findWhere(['project_id' => $id]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['project_id'] = $request->project_id;
        $data['description'] = $request->description;

        return $this->service->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        if($this->service->checkProjectPermissions($id) == false) {
            return ['error' => 'Acesso Negado!'];
        }

        return $this->repository->find($id);

    }

    public function showFile($id) {

        if($this->service->checkProjectPermissions($id) == false) {
            return ['error' => 'Acesso Negado!'];
        }

        $filePath = $this->service->getFilePath($id);
        $fileContent = file_get_contents($filePath);
        $file64 = base64_encode($fileContent);

        return [
            'file' => $file64,
            'size' => filesize($filePath),
            'name' => $this->service->getFileName($id),
//            'mime_type' => $this->service->getMimeType($id)
        ];

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        if($this->service->checkProjectOwner($id) == false) {
            return ['error' => 'Acesso Negado!'];
        }

        return $this->service->update($request->all(), $id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        if($this->service->checkProjectOwner($id) == false) {
            return ['error' => 'Acesso Negado!'];
        }

        $this->service->delete($id);
    }

}