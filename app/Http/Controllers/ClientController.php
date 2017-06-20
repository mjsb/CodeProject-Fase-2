<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Services\ClientService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /*
     * @var ClientRepository
    */

    private $repository;
    private $service;

    public function __construct(ClientRepository $repository, ClientService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->repository->all();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create()
    {
        //
    }
*/
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        #return $this->service->create($request->all());
        #return Client::create($request->all());

        try {

            return $this->service->create($request->all());

        } catch (ValidatorException $e) {

            return Response::json([
                'error' => true,
                'message' => $e->getMessageBag()
            ], 400);

        }

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

            return $this->repository->find($id);

        } catch (ModelNotFoundException $e) {

            return ['error'=>true, 'Cliente não encontrado!'];

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

            $this->repository->find($id)->update($request->all());
            return ['error'=>false, 'Cliente atualizado!'];

        } catch (ModelNotFoundException $e) {

            return ['error'=>true, 'Cliente não encontrado!'];

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

            $this->repository->find($id)->delete();
            return ['success'=>false, 'Cliente excluído com sucesso!'];

        } catch (QueryException $e) {

            return ['error'=>true, 'Cliente não pode ser excluído pois existe um ou mais projetos vinculados a ele.'];

        } catch (ModelNotFoundException $e) {

            return ['error'=>true, 'Cliente não encontrado!'];

        } catch (\Exception $e) {

            return ['error'=>true, 'Ocorreu algum erro ao excluir o cliente.'];

        }

    }
}
