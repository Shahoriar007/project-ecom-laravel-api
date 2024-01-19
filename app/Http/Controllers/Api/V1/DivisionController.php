<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DivisionRepository;
use App\Transformers\DivisionTransformer;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Division\StoreDivisionRequest;
use App\Http\Requests\Division\UpdateDivisionRequest;

class DivisionController extends Controller
{
    private DivisionRepository $repository;

    public function __construct(DivisionRepository $repository)
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

        return $this->response->paginator($data, new DivisionTransformer());
    }

    public function all()
    {
        $data = $this->repository->all();

        return $this->response->collection($data, new DivisionTransformer());
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
    public function store(StoreDivisionRequest $request)
    {
        $validated = $request->validated();

        $data = $this->repository->store($validated);

        return $this->response->item($data, new DivisionTransformer())
            ->setStatusCode(Response::HTTP_CREATED);
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

        return $this->response->item($data, new DivisionTransformer());
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
    public function update(UpdateDivisionRequest $request, $id)
    {
        $validated = $request->validated();
        $data = $this->repository->update($id, $validated);
        return $this->response->item($data, new DivisionTransformer());
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
