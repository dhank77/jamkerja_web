<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payroll\DataPayrollResource;
use App\Models\Payroll\DataPayroll;
use Illuminate\Http\Request;

class PayrollApiController extends Controller
{
    public function index()
    {
        $nip = request('nip');

        $payroll = DataPayroll::where('nip', $nip)->paginate();
        $payroll = DataPayrollResource::collection($payroll);

        return response()->json($payroll);
    }
}
