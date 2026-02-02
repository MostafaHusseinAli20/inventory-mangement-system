<?php

namespace App\Http\Controllers\Admin\SalesMatrial;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SalesMatrialTypes\SalesMatrialTypesRequest;
use App\Interfaces\SalesMatrialTypes\SalesMatrialTypeInterface;

class SalesMatrialTypesController extends Controller
{
    private $salesMatrialTypeRepoInterface;

    public function __construct(SalesMatrialTypeInterface $salesMatrialTypeRepoInterface)
    {
        $this->salesMatrialTypeRepoInterface = $salesMatrialTypeRepoInterface;
    }

    public function index()
    {
        return $this->salesMatrialTypeRepoInterface->index();
    }

    public function getSalesMatrialTypeData()
    {
        return $this->salesMatrialTypeRepoInterface->getSalesMatrialTypeData();
    }

    public function create()
    {
        return $this->salesMatrialTypeRepoInterface->create();
    }

    public function storeData(SalesMatrialTypesRequest $request)
    {
        return $this->salesMatrialTypeRepoInterface->storeData($request);
    }

    public function show($id)
    {
        return $this->salesMatrialTypeRepoInterface->show($id);
    }

    public function edit($id)
    {
        return $this->salesMatrialTypeRepoInterface->edit($id);
    }

    public function updateData(SalesMatrialTypesRequest $request, $id)
    {
        return $this->salesMatrialTypeRepoInterface->updateData($request, $id);
    }

    public function destroy($id)
    {
        return $this->salesMatrialTypeRepoInterface->destroy($id);
    }

    public function exportExcel()
    {
        return $this->salesMatrialTypeRepoInterface->exportExcel();
    }

    public function exportPdf()
    {
        return $this->salesMatrialTypeRepoInterface->exportPdf();
    }
}

