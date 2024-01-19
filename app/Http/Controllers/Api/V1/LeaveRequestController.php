<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeaveRequest\StoreLeaveRequest;
use App\Http\Requests\LeaveRequest\UpdateLeaveRequest;
use App\Repositories\LeaveRequestRepository;
use App\Transformers\LeaveRequestTransformer;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private LeaveRequestRepository $repository;

    public function __construct(LeaveRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $show = $request->input('show', 10);
        $sort = $request->input('sort', []);

        $data = $this->repository->index($show, $sort);

        return $this->response->paginator($data, new LeaveRequestTransformer());
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
    public function store(StoreLeaveRequest $request)
    {

        $validated = $request->validated();
        $data = $this->repository->store($validated);
        return $this->response->item($data, new LeaveRequestTransformer())->setStatusCode(201);
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
        return $this->response->item($data, new LeaveRequestTransformer());
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
    public function update(UpdateLeaveRequest $request, $id)
    {
        $validated = $request->validated();
        $data = $this->repository->update($id, $validated);
        return $this->response->item($data, new LeaveRequestTransformer());
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

    public function approve($id)
    {
        return $this->repository->approve($id);

        return $this->response()->noContent();
    }
}
