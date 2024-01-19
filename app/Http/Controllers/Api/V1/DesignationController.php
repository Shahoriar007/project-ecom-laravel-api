<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DesignationRepository;
use App\Transformers\DesignationTransformer;
use App\Http\Requests\Designation\StoreDesignationRequest;
use App\Http\Requests\Designation\UpdateDesignationRequest;

class DesignationController extends Controller
{

    private DesignationRepository $repository;

    public function __construct(DesignationRepository $repository)
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

        return $this->response->paginator($data, new DesignationTransformer());
    }

    public function all()
    {
        $data = $this->repository->all();

        return $this->response->collection($data, new DesignationTransformer());
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
    public function store(StoreDesignationRequest $request)
    {

        $validated = $request->validated();
        $data = $this->repository->store($validated);
        return $this->response->item($data, new DesignationTransformer())->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->repository->findById($id);
        return $this->response->item($data, new DesignationTransformer());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit(Designation $designation)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDesignationRequest $request, $id)
    {

        $validated = $request->validated();
        $data = $this->repository->update($id, $validated);
        return $this->response->item($data, new DesignationTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return $this->response()->noContent();
    }
}
