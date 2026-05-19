<?php

namespace App\Packages\ClientInfo\Controllers;

use Illuminate\Http\Request;
use App\Packages\ClientInfo\Services\ClientInfoService;
use App\Http\Controllers\Controller;

class ClientInfoController extends Controller
{
    protected $service;

    public function __construct(ClientInfoService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return response()->json($this->service->getData());
    }
}

