<?php

namespace App\Http\Controllers\Admin\Treasuries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Treasuries\TreasuryDeliveryRequest;
use App\Http\Requests\Admin\Treasuries\TreasuryRequest;
use App\Interfaces\Treasuries\TreasuryInterface;
use Illuminate\Http\Request;

class TreasuryController extends Controller
{
    private $treasuryRepoInterface;

    public function __construct(TreasuryInterface $treasuryRepoInterface)
    {
        $this->treasuryRepoInterface = $treasuryRepoInterface;
    }
    
    public function index()
    {
        return $this->treasuryRepoInterface->index();
    }

    public function get_treasury_data()
    {
        return $this->treasuryRepoInterface->get_treasury_data();
    }

    public function create()
    {
        return $this->treasuryRepoInterface->create();
    }

    public function store(TreasuryRequest $request)
    {
        return $this->treasuryRepoInterface->store($request);
    }

    public function exportExcel()
    {
        return $this->treasuryRepoInterface->exportExcel();
    }

    public function exportPdf()
    {
        return $this->treasuryRepoInterface->exportPdf();
    }

    public function show($id)
    {
        return $this->treasuryRepoInterface->show($id);
    }

    public function edit($id)
    {
        return $this->treasuryRepoInterface->edit($id);
    }

    public function update(TreasuryRequest $request, $id)
    {
        return $this->treasuryRepoInterface->update($request, $id);
    }

    public function searchByName(Request $request)
    {
        return $this->treasuryRepoInterface->searchByName($request);
    }

    public function destroy(Request $request, $id)
    {
        return $this->treasuryRepoInterface->destroy($request, $id);
    }

    public function detailsPage($id)
    {
        return $this->treasuryRepoInterface->detailsPage($id);
    }

    public function details(Request $request, $id)
    {
        return $this->treasuryRepoInterface->details($request, $id);
    }

    public function treasury_delivery_create()
    {
        return $this->treasuryRepoInterface->treasury_delivery_create();
    }

    public function treasury_delivery_store(TreasuryDeliveryRequest $request, $id)
    {
        return $this->treasuryRepoInterface->treasury_delivery_store($request, $id);
    }

    public function get_treasury_delivery_data(Request $request)
    {
        return $this->treasuryRepoInterface->get_treasury_delivery_data($request);
    }

    public function treasury_delivery_destroy($id)
    {
        return $this->treasuryRepoInterface->treasury_delivery_destroy($id);
    }
}
