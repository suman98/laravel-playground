<?php

namespace App\Packages\AnotherTest\Controllers;

use Illuminate\Http\Request;
use App\Packages\AnotherTest\Services\AnotherTestService;
use App\Http\Controllers\Controller;

class AnotherTestController extends Controller
{
    protected $service;

    public function __construct(AnotherTestService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return response()->json($this->service->getData());
    }
}

