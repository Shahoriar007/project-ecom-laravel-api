<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeaveType\StoreLeaveTypeRequest;
use App\Http\Requests\LeaveType\UpdateLeaveTypeRequest;
use App\Repositories\LeaveTypeRepository;
use App\Transformers\LeaveTypeTransformer;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private LeaveTypeRepository $repository;

    public function __construct(LeaveTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        $data =  $this->repository->all();
        return $this->response->collection($data, new LeaveTypeTransformer());
    }

    public function index()
    {
        $data =  $this->repository->index();
        return $this->response->collection($data, new LeaveTypeTransformer());
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
    public function store(StoreLeaveTypeRequest $request)
    {
        $validated = $request->validated();
        $data = $this->repository->store($validated);
        return $this->response->item($data, new LeaveTypeTransformer())->setStatusCode(201);
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
        return $this->response->item($data, new LeaveTypeTransformer());
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
    public function update(UpdateLeaveTypeRequest $request, $id)
    {
        $validated = $request->validated();
        $data = $this->repository->update($id, $validated);
        return $this->response->item($data, new LeaveTypeTransformer());
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

    public function eligibleAll()
    {
        $data = $this->repository->eligibleAll();

        return $this->response->collection($data, new LeaveTypeTransformer());
    }
}
