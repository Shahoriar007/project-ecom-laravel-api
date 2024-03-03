<?php

namespace App\Http\Controllers\Api\V1\AdminPanel\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\AdminPanel\Category\CategoryRepository;
use App\Http\Requests\AdminPanel\Category\StoreCategoryRequest;
use App\Http\Requests\AdminPanel\Category\UpdateCategoryRequest;
use App\Transformers\AdminPanel\Category\CategoryTransformer;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(Request $request)
    {
        $show = $request->input('show', 10);
        $sort = $request->input('sort', []);
        $search = $request->input('q');

        $data = $this->repository->index($show, $sort, $search);
        return $this->response->paginator($data, new CategoryTransformer());
    }

    public function all()
    {
        $data = $this->repository->all();
        return $this->response->collection($data, new CategoryTransformer());
    }

    public function activeAll()
    {
        $data = $this->repository->activeAll();

        return $this->response->collection($data, new CategoryTransformer());
    }

    public function featuredAll()
    {
        $data = $this->repository->featuredAll();

        return $this->response->collection($data, new CategoryTransformer());
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
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        $data = $this->repository->store($validated, $request);

        return $this->response->item($data, new CategoryTransformer())->setStatusCode(201);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = $this->repository->findById($id);

        return $this->response->item($data, new CategoryTransformer());
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
    public function update(UpdateCategoryRequest $request, $id)
    {
        $validated = $request->validated();
        $data = $this->repository->update($id, $validated, $request);
        return $this->response->item($data, new CategoryTransformer())->setStatusCode(200);
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
