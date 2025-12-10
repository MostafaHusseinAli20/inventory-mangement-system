<?php

namespace App\Interfaces\SalesMatrialTypes;

use App\Http\Requests\Admin\SalesMatrialTypes\SalesMatrialTypesRequest;

interface SalesMatrialTypeInterface
{
    public function index();
    public function getSalesMatrialTypeData();
    public function create();
    public function storeData(SalesMatrialTypesRequest $request);
    public function show($id);
    public function edit($id);
    public function updateData(SalesMatrialTypesRequest $request, $id);
    public function destroy($id);

    public function exportExcel();
    public function exportPdf();
}
