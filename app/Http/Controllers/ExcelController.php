<?php

namespace App\Http\Controllers;

use App\Contracts\Excel\ExcelSaveDataServiceInterface;
use App\Contracts\Excel\ExcelMapDataServiceInterface;
use App\Http\Requests\ImportRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RawImport;

class ExcelController extends Controller
{
    protected ExcelSaveDataServiceInterface $saveData;
    protected ExcelMapDataServiceInterface $validate;

    public function __construct(ExcelSaveDataServiceInterface $saveDataServiceInterface, ExcelMapDataServiceInterface $excelMapDataServiceInterface)
    {
        $this->saveData = $saveDataServiceInterface;
        $this->validate = $excelMapDataServiceInterface;
    }

    public function upload(ImportRequest $request)
    {
        $request->validated();
        $errorsText = '';

        try {
            $importRows = new RawImport($this->validate);
            Excel::import($importRows, $request->file('file'));
            $this->saveData->save($importRows->getResults()['valid']);
            foreach ($importRows->getResults()['invalid'] as $invalidRow) {
                $rowNumber = $invalidRow['number_row_error'];
                $errors = $invalidRow['errors'];
                $errorsList = implode(', ', $errors);
                $errorsText .= "{$rowNumber} - {$errorsList}\n";
            }
            file_put_contents(public_path('result.txt'), $errorsText);
            return response()->json(['message' => 'Файл успешно загружен и обработан'], 200);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['error' => 'Ошибка при обработке файла', 'details' => $e->getMessage()], 500);
        }
    }
}