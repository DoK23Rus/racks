<?php

namespace App\Http\Controllers\ReportControllers;

use App\Http\Controllers\Controller;
use App\Models\Rack;
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

class RacksReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function __invoke(Request $request): BinaryFileResponse
    {
        $fileName = ExportService::createCsvReport((new Rack()), 200, 'id');

        return Response::download($fileName)->deleteFileAfterSend();
    }
}
