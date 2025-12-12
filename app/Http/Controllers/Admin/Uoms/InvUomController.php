<?php

namespace App\Http\Controllers\Admin\Uoms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InvUoms\InvUomRequest;
use App\Interfaces\Uoms\InvUomInterface;
use Illuminate\Http\Request;

class InvUomController extends Controller
{
    private $invUomInterface;

    public function __construct(InvUomInterface $invUomInterface)
    {
        $this->invUomInterface = $invUomInterface;
    }
    
    public function index()
    {
        return $this->invUomInterface->index();
    }

    public function getUomData()
    {
        return $this->invUomInterface->getUomData();
    }

    public function create()
    {
        return $this->invUomInterface->create();
    }

    public function store(InvUomRequest $request)
    {
        return $this->invUomInterface->store($request);
    }

    public function show($id)
    {
        return $this->invUomInterface->show($id);
    }

    public function edit()
    {
        return $this->invUomInterface->edit();
    }

    public function update(InvUomRequest $request)
    {
        return $this->invUomInterface->update($request);
    }

    public function destroy($id)
    {
        return $this->invUomInterface->destroy($id);
    }

    public function exportExcel()
    {
        return $this->invUomInterface->exportExcel();
    }

    public function exportPdf()
    {
        return $this->invUomInterface->exportPdf();
    }

    public function searchByName(Request $request)
    {
        return $this->invUomInterface->searchByName($request);
    }

    public function filterByType(Request $request)
    {
        return $this->invUomInterface->filterByType($request);
    }
}
