<?php

namespace App\Http\Controllers\Admin\Uoms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InvUoms\InvUomRequest;
use App\Interfaces\Uoms\InvUomInterface;
use Illuminate\Http\Request;

class InvUomController extends Controller
{
    private $invUomRepoInterface;

    public function __construct(InvUomInterface $invUomRepoInterface)
    {
        $this->invUomRepoInterface = $invUomRepoInterface;
    }
    
    public function index()
    {
        return $this->invUomRepoInterface->index();
    }

    public function getUomData()
    {
        return $this->invUomRepoInterface->getUomData();
    }

    public function create()
    {
        return $this->invUomRepoInterface->create();
    }

    public function store(InvUomRequest $request)
    {
        return $this->invUomRepoInterface->store($request);
    }

    public function show($id)
    {
        return $this->invUomRepoInterface->show($id);
    }

    public function edit()
    {
        return $this->invUomRepoInterface->edit();
    }

    public function update(InvUomRequest $request)
    {
        return $this->invUomRepoInterface->update($request);
    }

    public function destroy($id)
    {
        return $this->invUomRepoInterface->destroy($id);
    }

    public function exportExcel()
    {
        return $this->invUomRepoInterface->exportExcel();
    }

    public function exportPdf()
    {
        return $this->invUomRepoInterface->exportPdf();
    }

    public function searchByName(Request $request)
    {
        return $this->invUomRepoInterface->searchByName($request);
    }

    public function filterByType(Request $request)
    {
        return $this->invUomRepoInterface->filterByType($request);
    }
}
