<?php

namespace App\Repositories\Stores;
use App\Interfaces\Stores\StoreInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\Stores\StoreRequest;
use App\Models\Admin;
use App\Models\Store;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StoreRepository implements StoreInterface
{
    public function index()
    {
        return view('admin.stores.index');
    }

    public function getStoreData()
    {
        $stores = Store::where('com_code', auth()->guard('admin')->user()->com_code)
            ->orderBy('id', 'desc')->paginate(PAGINATE_COUNT);

        if (!empty($stores)) {
            foreach ($stores as $store) {
                $store->added_by_admin = Admin::where('id', $store->added_by)->value('name');
                if ($store->updated_by != null || $store->updated_by > 0) {
                    $store->updated_by_admin = Admin::where('id', $store->updated_by)->value('name');
                }
            }
        }

        $dt = new DateTime($stores['updated_at']);
        $date = $dt->format('Y-m-d');
        $time = $dt->format('h:i');
        $newDateTime = date('A', strtotime($time));
        $newDateTimeType = $newDateTime == 'AM' ? 'صباحا ' : 'مساء';

        return response()->json([
            'stores' => $stores,
            'date' => $date,
            'time' => $time,
            'newDateTimeType' => $newDateTimeType
        ]);
    }

    public function create()
    {
        return view('admin.stores.create');
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            if(
                !$request->all() ||
                empty($request->all()) ||
                $request->name == '' || 
                $request->active == '' ||
                $request->phone == '' ||
                $request->address == ''
                ){
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'يرجى تعبئة الحقول المطلوبة',
                    'code' => 422
                ], 422);
            }

            Store::create([
                'name' => $request->name,
                'active' => $request->active,
                'phone' => $request->phone,
                'address' => $request->address,
                'added_by' => auth()->guard('admin')->user()->id,
                'com_code' => auth()->guard('admin')->user()->com_code,
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'تم الإضافة بنجاح',
                'code' => 200
            ], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function show($id)
    {
        return response()->json([
            'data' => Store::where('com_code', auth()->guard('admin')->user()->com_code)
                ->findOrFail($id)
        ]);
    }

    public function edit($id)
    {
        return view('admin.stores.edit');
    }

    public function update(StoreRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            if(
                !$request->all() ||
                empty($request->all()) ||
                $request->name == '' || 
                $request->active == '' ||
                $request->phone == '' ||
                $request->address == ''
                ){
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'يرجى تعبئة الحقول المطلوبة',
                    'code' => 422
                ], 422);
            }

            $store = Store::where('com_code', auth()->guard('admin')->user()->com_code)
                ->findOrFail($id);

            $store->update([
                'name' => $request->name,
                'active' => $request->active,
                'phone' => $request->phone,
                'address' => $request->address,
                'updated_by' => auth()->guard('admin')->user()->id
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'تم الإضافة بنجاح',
                'code' => 200
            ], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $store = Store::where('com_code', auth()->guard('admin')->user()->com_code);
        $store->findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'تم الحذف بنجاح',
            'code' => 200
        ]);
    }

    public function exportExcel()
    {
        $data = Store::where('com_code', auth()->guard('admin')->user()->com_code)
            ->select('id', 'name', 'address', 'phone', 'active')
            ->orderBy('id', 'desc')
            ->get();

        return Excel::download(new class ($data) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {

            public $rows;

            public function __construct($rows)
            {
                $this->rows = $rows;
            }

            public function collection()
            {
                return $this->rows;
            }

            public function headings(): array
            {
                return ['ID', 'Name', 'Address', 'Phone', 'Active?'];
            }

        }, 'stores.xlsx');
    }

    public function exportPdf()
    {
        $stores = Store::where('com_code', auth()->guard('admin')->user()->com_code)
            ->orderBy('id', 'desc')
            ->get();

        $html = '
            <h2 style="text-align:center">Treasuries Report</h2>
            <table width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#f0f0f0">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Active?</th>
                </tr>
            </thead>
            <tbody>
        ';

        foreach ($stores as $store) {
            $html .= '
                <tr>
                    <td>' . $store->id . '</td>
                    <td>' . $store->name . '</td>
                    <td>' . $store->address . '</td>
                    <td>' . $store->phone . '</td>
                    <td>' . ($store->active ? "Active" : "Inactive") . '</td>
                </tr>
            ';
        }

        $html .= '</tbody></table>';

        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('stores.pdf');
    }

    public function searchByName(Request $request)
    {
        $stores = Store::where('com_code', auth()->guard('admin')->user()->com_code)
            ->where('name', 'like', '%' . $request->name . '%')
            ->paginate(PAGINATE_COUNT);

        $stores = $stores->map(function ($item) {
          $dt = new DateTime($item->updated_at);
            $item->date = $dt->format('Y-m-d');
            $item->time = $dt->format('h:i');
            $newDateTime = date('A', strtotime($item->time));
            $item->newDateTimeType = $newDateTime == 'AM' ? 'صباحا' : 'مساء';
            $item->added_by_admin = Admin::where('id', $item->added_by)->value('name');
            $item->updated_by_admin = Admin::where('id', $item->updated_by)->value('name');

            return $item;  
        });

        return response()->json([
            'status' => true,
            'stores' => $stores
        ]);
    }
}