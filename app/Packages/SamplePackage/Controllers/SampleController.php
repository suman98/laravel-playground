<?php

namespace App\Packages\SamplePackage\Controllers;

use Illuminate\Http\Request;
use App\Packages\SamplePackage\Services\SampleService;
use App\Http\Controllers\Controller;
class SampleController
{
    protected $service;

    public function __construct(SampleService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return response()->json($this->service->getData());
    }
}
