<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AttendanceActivityRepository;
use App\Transformers\AttendanceActivityTransformer;
use App\Http\Requests\AttendanceActivity\StoreAttendanceActivityRequest;
use App\Http\Requests\AttendanceActivity\UpdateAttendanceActivityRequest;

class AttendanceActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private AttendanceActivityRepository $repository;

    public function __construct(AttendanceActivityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $data =  $this->repository->all();
        return $this->response->collection($data, new AttendanceActivityTransformer());
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
    public function store(StoreAttendanceActivityRequest  $request)
    {
        $validated = $request->validated();
        $data = $this->repository->store($validated);
        return $this->response->item($data, new AttendanceActivityTransformer())->setStatusCode(201);
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
        return $this->response->item($data, new AttendanceActivityTransformer());
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
    public function update(UpdateAttendanceActivityRequest $request, $id)
    {
        $validated = $request->validated();
        $data = $this->repository->update($id, $validated);
        return $this->response->item($data, new AttendanceActivityTransformer());
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
