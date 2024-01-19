<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AttendanceRepository;
use App\Transformers\AttendanceTransformer;
use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Http\Requests\Attendance\UpdateAttendanceRequest;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private AttendanceRepository $repository;

    public function __construct(AttendanceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all(Request $request)
    {
        $data = $this->repository->all();
        return $this->response->collection($data, new AttendanceTransformer());
    }

    public function index(Request $request)
    {
        $show = $request->input('show', 10);
        $sort = $request->input('sort', []);
        $search = $request->input('q');

        $data = $this->repository->index($show, $sort, $search);
        return $this->response->paginator($data, new AttendanceTransformer());
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
    public function store(StoreAttendanceRequest $request)
    {
        $validated = $request->validated();
        $data = $this->repository->store($validated);
        return $this->response->item($data, new AttendanceTransformer())->setStatusCode(201);
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
        return $this->response->item($data, new AttendanceTransformer());
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
    public function update(UpdateAttendanceRequest $request, $id)
    {
        $validated = $request->validated();
        $data = $this->repository->update($id, $validated);
        return $this->response->item($data, new AttendanceTransformer());
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

    public function isCheckIn(): bool
    {
        return $this->repository->isCheckIn();
    }

    public function checkIn()
    {
        $this->repository->checkIn();
        return $this->response()->noContent();
    }

    public function checkOut()
    {
        return $this->repository->checkOut();
        return $this->response()->noContent();
    }

    public function presentEmployees(Request $request)
    {
        $data = $this->repository->presentEmployees();
        return $this->response->collection($data, new AttendanceTransformer());
    }

    public function leaveEmployees(Request $request)
    {
        $data = $this->repository->leaveEmployees();
        return $this->response->collection($data, new AttendanceTransformer());
    }
}
