<?php

namespace App\Interfaces\Stores;

use App\Http\Requests\Admin\Stores\StoreRequest;
use Illuminate\Http\Request;

interface StoreInterface
{
    public function index();
    public function getStoreData();
    public function create();
    public function store(StoreRequest $request);
    public function show($id);
    public function edit($id);
    public function update(StoreRequest $request, $id);
    public function destroy($id);
    public function exportExcel();
    public function exportPdf();
    public function searchByName(Request $request);
}
