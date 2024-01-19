<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Repositories\SettingRepository;
use App\Transformers\SettingTransformer;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private SettingRepository $repository;

    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $data =  $this->repository->index($request);
        return $this->response->item($data, new SettingTransformer());
    }

    public function update(UpdateSettingRequest $request)
    {
        $validated = $request->validated();
        $data = $this->repository->update($validated);
        return $this->response->item($data, new SettingTransformer());
    }
}
