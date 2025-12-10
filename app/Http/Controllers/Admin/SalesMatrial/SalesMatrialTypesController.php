<?php

namespace App\Http\Controllers\Admin\SalesMatrial;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SalesMatrialTypes\SalesMatrialTypesRequest;
use App\Interfaces\SalesMatrialTypes\SalesMatrialTypeInterface;

class SalesMatrialTypesController extends Controller
{
    private $salesMatrialTypeInterface;

    public function __construct(SalesMatrialTypeInterface $salesMatrialTypeInterface)
    {
        $this->salesMatrialTypeInterface = $salesMatrialTypeInterface;
    }

    public function index()
    {
        return $this->salesMatrialTypeInterface->index();
    }

    public function getSalesMatrialTypeData()
    {
        return $this->salesMatrialTypeInterface->getSalesMatrialTypeData();
    }

    public function create()
    {
        return $this->salesMatrialTypeInterface->create();
    }

    public function storeData(SalesMatrialTypesRequest $request)
    {
        return $this->salesMatrialTypeInterface->storeData($request);
    }

    public function show($id)
    {
        return $this->salesMatrialTypeInterface->show($id);
    }

    public function edit($id)
    {
        return $this->salesMatrialTypeInterface->edit($id);
    }

    public function updateData(SalesMatrialTypesRequest $request, $id)
    {
        return $this->salesMatrialTypeInterface->updateData($request, $id);
    }

    public function destroy($id)
    {
        return $this->salesMatrialTypeInterface->destroy($id);
    }

    public function exportExcel()
    {
        return $this->salesMatrialTypeInterface->exportExcel();
    }

    public function exportPdf()
    {
        return $this->salesMatrialTypeInterface->exportPdf();
    }
}

