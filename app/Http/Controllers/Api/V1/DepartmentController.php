<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DepartmentRepository;
use App\Transformers\DepartmentTransformer;
use App\Http\Requests\Department\StoreDepartment;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DepartmentController extends Controller
{

    private DepartmentRepository $repository;

    public function __construct(DepartmentRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $show = $request->input('show', 10);
        $sort = $request->input('sort', []);
        $search = $request->input('q');

        $data = $this->repository->index($show, $sort, $search);
        return $this->response->paginator($data, new DepartmentTransformer());
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
    public function store(StoreDepartment $request)
    {
        $validated = $request->validated();
        $data = $this->repository->store($validated);
        return $this->response->item($data, new DepartmentTransformer())->setStatusCode(201);
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
        return $this->response->item($data, new DepartmentTransformer());
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
    public function update(UpdateDepartmentRequest $request, $id)
    {
        $validated = $request->validated();
        $data = $this->repository->update($id, $validated);
        return $this->response->item($data, new DepartmentTransformer());
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

    public function syncUserToDepartment(Request $request)
    {
        $this->repository->syncUserToDepartment($request);

        return $this->response()->noContent();
    }
}
