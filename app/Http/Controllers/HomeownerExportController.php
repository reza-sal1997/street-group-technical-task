<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\HomeownerImportRequest;
use App\Services\HomeownerNameParserService;
use Illuminate\Http\JsonResponse;

class HomeownerExportController extends Controller
{
    public function import(HomeownerImportRequest $request): JsonResponse
    {
        $people = [];

        $file = $request->file('file');
        $filePath = $file->getRealPath();
        $service = new HomeownerNameParserService();

        // Open the file
        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            // This ignores the header row
            fgetcsv($handle);

            // Loop through rows except the header
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $people[] = $service->parse($data[0]);
            }
        }
        fclose($handle);

        return response()->json($people);
    }
}
