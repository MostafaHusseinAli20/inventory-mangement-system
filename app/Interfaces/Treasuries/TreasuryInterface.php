<?php

namespace App\Interfaces\Treasuries;

use App\Http\Requests\Admin\Treasuries\TreasuryRequest;
use Illuminate\Http\Request;

interface TreasuryInterface
{
    public function index();
    public function get_treasury_data();
    public function create();
    public function store(TreasuryRequest $request);
    public function exportExcel();
    public function exportPdf();
    public function show($id);
    public function edit($id);
    public function update(TreasuryRequest $request, $id);
    public function destroy(Request $request, $id);
    public function searchByName(Request $request);
}
