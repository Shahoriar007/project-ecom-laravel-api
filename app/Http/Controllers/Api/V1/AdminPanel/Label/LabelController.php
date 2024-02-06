<?php

namespace App\Http\Controllers\Api\V1\AdminPanel\Label;

use App\Http\Controllers\Controller;
use App\Repositories\AdminPanel\Label\LabelRepository;
use App\Transformers\AdminPanel\Label\LabelTransformer;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    //
    private LabelRepository $repository;
    public function __construct(LabelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        $data = $this->repository->all();
        return $this->response->collection($data, new LabelTransformer());
    }
}
