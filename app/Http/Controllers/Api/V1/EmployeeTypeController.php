<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\EmployeeType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeType\StoreEmployeeTypeRequest;
use App\Http\Requests\EmployeeType\UpdateEmployeeTypeRequest;
use App\Repositories\EmployeeTypeRepository;
use App\Transformers\EmployeeTypeTransformer;

class EmployeeTypeController extends Controller
{

    private EmployeeTypeRepository $repository;

    public function __construct(EmployeeTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function all()
    {
        $data = $this->repository->all();

        return $this->response->collection($data, new EmployeeTypeTransformer());
    }

    public function index()
    {
        $data = $this->repository->index();

        return $this->response->collection($data, new EmployeeTypeTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeTypeRequest $request)
    {

        $validated = $request->validated();
        $data = $this->repository->store($validated);
        return $this->response->item($data, new EmployeeTypeTransformer())->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->repository->findById($id);

        return $this->response->item($data, new EmployeeTypeTransformer());
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
    public function update(UpdateEmployeeTypeRequest $request, $id)
    {
        $validated = $request->validated();
        $data = $this->repository->update($id, $validated);
        return $this->response->item($data, new EmployeeTypeTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return $this->response()->noContent();
    }
}
