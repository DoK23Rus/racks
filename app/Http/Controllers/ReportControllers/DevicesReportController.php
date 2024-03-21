<?php

namespace App\Http\Controllers\ReportControllers;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/*
|--------------------------------------------------------------------------
| RAPID APPROACH
|--------------------------------------------------------------------------
|
| Not much business logic, not likely to change.
|
*/

class DevicesReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param  Request  $request
     * @return BinaryFileResponse
     */
    public function __invoke(Request $request): BinaryFileResponse
    {
        $fileName = ExportService::createCsvReport((new Device()), 200, 'id');

        return Response::download($fileName)->deleteFileAfterSend();
    }
}
