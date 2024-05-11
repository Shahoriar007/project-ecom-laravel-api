<?php

namespace App\Http\Controllers\Api\V1\AdminPanel\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Product\StoreProductRequest;
use App\Http\Requests\AdminPanel\Product\UpdateProductRequest;
use App\Transformers\AdminPanel\Product\ProductTransformer;
use Illuminate\Http\Request;
use App\Repositories\AdminPanel\Product\ProductRepository;

class ProductController extends Controller
{

    private ProductRepository $repository;
    public function __construct(ProductRepository $repository)
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
        $filterStatus = $request->input('filterStatus');

        $data = $this->repository->index($show, $sort, $search, $filterStatus);

        return $this->response->paginator($data, new ProductTransformer());
    }

    public function all()
    {
        $data = $this->repository->all();
        return $this->response->collection($data, new ProductTransformer());
    }

    public function activeAll(Request $request)
    {
        $category = $request['category'];
        $subCategory = $request['subCategory'];
        $childCategory = $request['childCategory'];

        $data = $this->repository->activeAll($category, $subCategory, $childCategory);
        return $this->response->collection($data, new ProductTransformer());
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
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $data = $this->repository->store($validated, $request);
        return $this->response->item($data, new ProductTransformer())->setStatusCode(201);
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
        return $this->response->item($data, new ProductTransformer());
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
    public function update(UpdateProductRequest $request, $id)
    {
        $validated = $request->validated();
        $data = $this->repository->update($id, $validated, $request);
        return $this->response->item($data, new ProductTransformer())->setStatusCode(200);
    }

    public function modalTwoUpdate(Request $request, $id)
    {

        info($request->all());
        $validated = $request->validate([
            'stock' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'priority' => 'nullable|integer',
        ]);
        $data = $this->repository->modalTwoUpdate($validated, $id);
        return $this->response->item($data, new ProductTransformer());
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

    public function showWithSlug($slug)
    {
        $data = $this->repository->showWithSlug($slug);
        return $this->response->item($data, new ProductTransformer());
    }

    public function totalProducts()
    {
        $data = $this->repository->totalProducts();
        return $this->response->array(['total_products' => $data]);
    }

    public function searchProduct(Request $request)
    {
        $search = $request->input('search_term');
        $data = $this->repository->searchProduct($search);
        return $this->response->collection($data, new ProductTransformer());
    }

    public function relatedProducts($id, Request $request)
    {
        $avoidProductId = $request['avoid_product_id'];
        $data = $this->repository->relatedProducts($id, $avoidProductId);
        return $this->response->collection($data, new ProductTransformer());
    }

    public function updateStatus($id)
    {
        $data = $this->repository->updateStatus($id);
        return $this->response->item($data, new ProductTransformer());
    }
}
