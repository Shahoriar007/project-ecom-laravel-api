<?php

namespace App\Http\Controllers\Api\V1\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AdminPanel\Customer\CustomerRepository;
use App\Transformers\AdminPanel\Customer\CustomerTransformer;

class CustomerController extends Controller
{

    private CustomerRepository $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        info($request);
        $show = $request->input('show', 10);
        $sort = $request->input('sort', []);
        $search = $request->input('q');

        $data = $this->repository->index($show, $sort, $search);

        return $this->response->paginator($data, new CustomerTransformer());
    }

    public function bandActive($id)
    {
        $data = $this->repository->bandActive($id);
        return $this->response->item($data, new CustomerTransformer());
    }
}
