<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;


class ProjectNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $repository;
    private $service;

    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service )
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index($id)
    {
        //
        return $this->repository->findWhere(['project_id' => $id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   /* public function create()
    {
        //
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id) {
        //
        #return Project::create($request->all());
        #return $this->repository->create($request->all());

        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->create($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $noteId)
    {
        //
        #return Project::find($id);
        #return $this->repository->with('user')->with('client')->find($id);
        #return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);

        /*

        $result = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
        if(isset($result['data']) && count($result['data']) == 1) {
            $result = ['data' => $result['data'][0]];
        }

        return $result;

        */

        $result = $this->repository->findWhere(['project_id'=>$id, 'id'=>$noteId]);
        if(isset($result['data']) && count($result['data'])==1) {

            $result = [

                'data' => $result['data'][0]

            ];

        }

        return $result;

        #return $this->service->show($noteId);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /* public function edit($id)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($noteId)
    {
        //
        #Project::find($id)->delete();
        #$this->repository->find($id)->delete();
        return $this->service->delete($noteId);
    }
}
