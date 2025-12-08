<?php

namespace App\Http\Controllers\Admin\Treasuries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Treasuries\TreasuryRequest;
use App\Interfaces\Treasuries\TreasuryInterface;
use Illuminate\Http\Request;

class TreasuryController extends Controller
{
    private $treasuryInterface;

    public function __construct(TreasuryInterface $treasuryInterface)
    {
        $this->treasuryInterface = $treasuryInterface;
    }
    
    public function index()
    {
        return $this->treasuryInterface->index();
    }

    public function get_treasury_data()
    {
        return $this->treasuryInterface->get_treasury_data();
    }

    public function create()
    {
        return $this->treasuryInterface->create();
    }

    public function store(TreasuryRequest $request)
    {
        return $this->treasuryInterface->store($request);
    }

    public function exportExcel()
    {
        return $this->treasuryInterface->exportExcel();
    }

    public function exportPdf()
    {
        return $this->treasuryInterface->exportPdf();
    }

    public function show($id)
    {
        return $this->treasuryInterface->show($id);
    }

    public function edit($id)
    {
        return $this->treasuryInterface->edit($id);
    }

    public function update(TreasuryRequest $request, $id)
    {
        return $this->treasuryInterface->update($request, $id);
    }

    public function destroy(Request $request, $id)
    {
        return $this->treasuryInterface->destroy($request, $id);
    }
}
