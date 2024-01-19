<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use App\Transformers\RoleTransformer;
use App\Transformers\ModuleTransformer;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;

class RoleController extends Controller
{
    private RoleRepository $repository;

    public function __construct(RoleRepository $repository)
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

        return $this->response->paginator($data, new RoleTransformer());
    }

    public function all()
    {
        $data = $this->repository->all();

        return $this->response->collection($data, new RoleTransformer());
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
    public function store(StoreRoleRequest $request)
    {
        $data = $this->repository->store($request->validated());

        return $this->response->item($data, new RoleTransformer())
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->repository->show($id);

        return $this->response->item($data, new RoleTransformer());
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
    public function update(UpdateRoleRequest $request, $id)
    {
        $data = $this->repository->update($id, $request->validated());

        return $this->response->item($data, new RoleTransformer());
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

    public function getModulesPermissions()
    {
        $data = $this->repository->getModulesPermissions();

        return $this->response->collection($data, new ModuleTransformer());
    }

    public function updatePermission(Request $request, $id)
    {

        $attach = $request->boolean('attach');
        $permission_id = $request->input('permission_id');

        $data = $this->repository->updatePermission($attach, $permission_id, $id);

        return $this->response->item($data, new RoleTransformer());
    }

    public function priorityWiseRoles()
    {
        $data = $this->repository->priorityWiseRoles();

        return $this->response->collection($data, new RoleTransformer());
    }
}
