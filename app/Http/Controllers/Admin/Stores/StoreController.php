<?php

namespace App\Http\Controllers\Admin\Stores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Stores\StoreRequest;
use App\Interfaces\Stores\StoreInterface;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    private $storeInterface;
    public function __construct(StoreInterface $storeInterface)
    {
        $this->storeInterface = $storeInterface;
    }

    public function index()
    {
        return $this->storeInterface->index();
    }

    public function getStoreData()
    {
        return $this->storeInterface->getStoreData();
    }

    public function create()
    {
        return $this->storeInterface->create();
    }

    public function store(StoreRequest $request)
    {
        return $this->storeInterface->store($request);
    }

    public function show($id)
    {
        return $this->storeInterface->show($id);
    }

    public function edit($id)
    {
        return $this->storeInterface->edit($id);
    }

    public function update(StoreRequest $request, $id)
    {
        return $this->storeInterface->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->storeInterface->destroy($id);
    }

    public function exportExcel()
    {
        return $this->storeInterface->exportExcel();
    }

    public function exportPdf()
    {
        return $this->storeInterface->exportPdf();
    }

    public function searchByName(Request $request)
    {
        return $this->storeInterface->searchByName($request);
    }
}
