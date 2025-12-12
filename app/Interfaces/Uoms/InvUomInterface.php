<?php

namespace App\Interfaces\Uoms;

use App\Http\Requests\Admin\InvUoms\InvUomRequest;
use Illuminate\Http\Request;

interface InvUomInterface
{
    public function index();
    public function getUomData();
    public function create();
    public function store(InvUomRequest $request);
    public function show($id);
    public function edit();
    public function update(InvUomRequest $request);
    public function destroy($id);
    public function exportExcel();
    public function exportPdf();
    public function filterByType(Request $request);
    public function searchByName(Request $request);
}
