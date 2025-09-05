<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeownerImportRequest;
use App\Services\PersonNameParserService;
use Illuminate\Http\JsonResponse;

class HomeownerImportController extends Controller
{
    public function import(HomeownerImportRequest $request): JsonResponse
    {
        $people = [];

        $file = $request->file('file');
        $filePath = $file->getRealPath();
        $service = new PersonNameParserService();

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
