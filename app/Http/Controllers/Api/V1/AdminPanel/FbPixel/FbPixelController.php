<?php

namespace App\Http\Controllers\Api\V1\AdminPanel\FbPixel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\AdminPanel\FbPixel\FbPixelRepository;
use App\Transformers\AdminPanel\FbPixel\FbPixelTransformer;
use App\Http\Requests\AdminPanel\FbPixel\StoreFbPixelRequest;

class FbPixelController extends Controller
{
    private FbPixelRepository $repository;

    public function __construct(FbPixelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(StoreFbPixelRequest $request)
    {
        $validated = $request->validated();
        $data = $this->repository->store($validated, $request);
        return $this->response->item($data, new FbPixelTransformer());
    }

    public function destroy($id)
    {
        $this->repository->delete($id);

        return $this->response()->noContent();
    }



}
