<?php

namespace App\Http\Controllers\Admin\Stores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Stores\StoreRequest;
use App\Interfaces\Stores\StoreInterface;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    private $storeRepoInterface;
    public function __construct(StoreInterface $storeRepoInterface)
    {
        $this->storeRepoInterface = $storeRepoInterface;
    }

    public function index()
    {
        return $this->storeRepoInterface->index();
    }

    public function getStoreData()
    {
        return $this->storeRepoInterface->getStoreData();
    }

    public function create()
    {
        return $this->storeRepoInterface->create();
    }

    public function store(StoreRequest $request)
    {
        return $this->storeRepoInterface->store($request);
    }

    public function show($id)
    {
        return $this->storeRepoInterface->show($id);
    }

    public function edit($id)
    {
        return $this->storeRepoInterface->edit($id);
    }

    public function update(StoreRequest $request, $id)
    {
        return $this->storeRepoInterface->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->storeRepoInterface->destroy($id);
    }

    public function exportExcel()
    {
        return $this->storeRepoInterface->exportExcel();
    }

    public function exportPdf()
    {
        return $this->storeRepoInterface->exportPdf();
    }

    public function searchByName(Request $request)
    {
        return $this->storeRepoInterface->searchByName($request);
    }
}
