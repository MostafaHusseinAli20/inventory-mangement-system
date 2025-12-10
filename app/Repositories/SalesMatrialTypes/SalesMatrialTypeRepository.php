<?php

namespace App\Repositories\SalesMatrialTypes;

use App\Interfaces\SalesMatrialTypes\SalesMatrialTypeInterface;
use App\Http\Requests\Admin\SalesMatrialTypes\SalesMatrialTypesRequest;
use App\Models\Admin;
use App\Models\SalesMatrialType;
use DateTime;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class SalesMatrialTypeRepository implements SalesMatrialTypeInterface
{
    public function index()
    {
        return view('admin.sales-matrial-types.index');
    }

    public function getSalesMatrialTypeData()
    {
        $data = SalesMatrialType::where('com_code', auth()->guard('admin')->user()->com_code)
            ->orderBy('id', 'desc')->paginate(PAGINATE_COUNT);

        if (!empty($data)) {
            foreach ($data as $value) {
                $value->added_by_admin = Admin::where('id', $value->added_by)->value('name');
                if ($value->updated_by != null || $value->updated_by > 0) {
                    $value->updated_by_admin = Admin::where('id', $value->updated_by)->value('name');
                }
            }
        }

        $dt = new DateTime($data['updated_at']);
        $date = $dt->format('Y-m-d');
        $time = $dt->format('h:i');
        $newDateTime = date('A', strtotime($time));
        $newDateTimeType = $newDateTime == 'AM' ? 'صباحا ' : 'مساء';

        return response()->json([
            'data' => $data,
            'date' => $date,
            'time' => $time,
            'newDateTimeType' => $newDateTimeType
        ]);
    }

    public function create()
    {
        return view('admin.sales-matrial-types.create');
    }

    public function storeData(SalesMatrialTypesRequest $request)
    {
        DB::beginTransaction();
        try {
            if(!$request->all() || empty($request->all()) || $request->name == '' || $request->active == '') {
                DB::rollBack();
                return response()->json([
                    'status' => false,  
                    'message' => 'يرجى تعبئة الحقول المطلوبة',
                    'code' => 422
                ], 422);
            }

            SalesMatrialType::create([
                'name' => $request->name,
                'added_by' => auth()->guard('admin')->user()->id,
                'com_code' => auth()->guard('admin')->user()->com_code,
                'active' => $request->active
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'تم الاضافة بنجاح',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    public function show($id)
    {
        return response()->json([
            'data' => SalesMatrialType::where('com_code', auth()->guard('admin')->user()->com_code)
                ->findOrFail($id)
        ]);
    }

    public function edit($id)
    {
        return view('admin.sales-matrial-types.edit');
    }

    public function updateData(SalesMatrialTypesRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            if(!$request->all() || empty($request->all()) || $request->name == '' || $request->active == '') {
                DB::rollBack();
                return response()->json([
                    'status' => false,  
                    'message' => 'يرجى تعبئة الحقول المطلوبة',
                    'code' => 422
                ], 422);
            }
            $update = SalesMatrialType::findOrFail($id);
            if ($update) {
                $update->update([
                    'name' => $request->name,
                    'updated_by' => auth()->guard('admin')->user()->id,
                    'active' => $request->active
                ]);
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'تم التعديل بنجاح',
                ], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            SalesMatrialType::findOrFail($id)->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'تم الحذف بنجاح',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    public function exportExcel()
    {
        $data = SalesMatrialType::where('com_code', auth()->guard('admin')->user()->com_code)
            ->select('id', 'name', 'active')
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
                return ['ID', 'Name', 'Active'];
            }

        }, 'sales-matrial-types.xlsx');
    }

    public function exportPdf()
    {
        $treasuries = SalesMatrialType::where('com_code', auth()->guard('admin')->user()->com_code)
            ->orderBy('id', 'desc')
            ->get();

        $html = '
            <h2 style="text-align:center">Sales Matrial Report</h2>
            <table width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#f0f0f0">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Active?</th>
                </tr>
            </thead>
            <tbody>
        ';

        foreach ($treasuries as $treasury) {
            $html .= '
                <tr>
                    <td>' . $treasury->id . '</td>
                    <td>' . $treasury->name . '</td>
                    <td>' . ($treasury->active ? "Active" : "Inactive") . '</td>
                </tr>
            ';
        }

        $html .= '</tbody></table>';

        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('sales-matrial-types.pdf');
    }
}