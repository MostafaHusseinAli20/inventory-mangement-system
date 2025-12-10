<?php

namespace App\Http\Controllers\Admin\Treasuries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Treasuries\TreasuryDeliveryRequest;
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

    public function searchByName(Request $request)
    {
        return $this->treasuryInterface->searchByName($request);
    }

    public function destroy(Request $request, $id)
    {
        return $this->treasuryInterface->destroy($request, $id);
    }

    public function detailsPage($id)
    {
        return $this->treasuryInterface->detailsPage($id);
    }

    public function details(Request $request, $id)
    {
        return $this->treasuryInterface->details($request, $id);
    }

    public function treasury_delivery_create()
    {
        return $this->treasuryInterface->treasury_delivery_create();
    }

    public function treasury_delivery_store(TreasuryDeliveryRequest $request, $id)
    {
        return $this->treasuryInterface->treasury_delivery_store($request, $id);
    }

    public function get_treasury_delivery_data(Request $request)
    {
        return $this->treasuryInterface->get_treasury_delivery_data($request);
    }

    public function treasury_delivery_destroy($id)
    {
        return $this->treasuryInterface->treasury_delivery_destroy($id);
    }
}
