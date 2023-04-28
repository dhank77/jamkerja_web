<?php

namespace App\Http\Controllers;

use App\Http\Resources\LogResource;
use App\Models\Logs;

class LogController extends Controller
{
    public function index()
    {
        $model_type = request('model_type');
        $model_id = request('model_id');
        $data = LogResource::collection(Logs::with(['user', 'target'])->where('model_type', $model_type)->where('model_id', $model_id)->get());
        return response()->json($data);
    }
}
