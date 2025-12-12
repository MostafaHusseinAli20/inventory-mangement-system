<?php

namespace App\Repositories\Uoms;

use App\Interfaces\Uoms\InvUomInterface;
use App\Http\Requests\Admin\InvUoms\InvUomRequest;
use App\Models\Admin;
use App\Models\InvUom;
use DateTime;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvUomRepository implements InvUomInterface
{
    public function index()
    {
        return view('admin.uoms.index');
    }

    public function getUomData()
    {
        $data = InvUom::where('com_code', auth()->guard('admin')->user()->com_code)
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
            'uoms' => $data,
            'date' => $date,
            'time' => $time,
            'newDateTimeType' => $newDateTimeType
        ]);
    }

    public function create()
    {
        return view('admin.uoms.create');
    }

    public function store(InvUomRequest $request)
    {
        DB::beginTransaction();
        try {
            if (
                !$request->all() ||
                empty($request->all()) ||
                $request->name == '' ||
                $request->active == '' ||
                $request->is_master == ''
            ) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'يرجى تعبئة الحقول المطلوبة',
                    'code' => 422
                ], 422);
            }

            InvUom::create([
                'name' => $request->name,
                'active' => $request->active,
                'is_master' => $request->is_master,
                'added_by' => auth()->guard('admin')->user()->id,
                'com_code' => auth()->guard('admin')->user()->com_code,
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
                'code' => 500
            ], 500);
        }
    }

    public function show($id)
    {
        return response()->json([
            'data' => InvUom::where('com_code', auth()->guard('admin')->user()->com_code)
                ->findOrFail($id)
        ]);
    }

    public function edit()
    {
        return view('admin.uoms.edit');
    }

    public function update(InvUomRequest $request)
    {
        DB::beginTransaction();
        try {
            if (
                !$request->all() ||
                empty($request->all()) ||
                $request->name == '' ||
                $request->active == '' ||
                $request->is_master == ''
            ) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'يرجى تعبئة الحقول المطلوبة',
                    'code' => 422
                ], 422);
            }

            $InvUom = InvUom::where('com_code', auth()->guard('admin')->user()->com_code)
                ->findOrFail($request->id);

            $InvUom->update([
                'name' => $request->name,
                'active' => $request->active,
                'is_master' => $request->is_master,
                'updated_by' => auth()->guard('admin')->user()->id
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'تم التعديل بنجاح',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            InvUom::where('com_code', auth()->guard('admin')->user()->com_code)
                ->findOrFail($id)->delete();
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
                'code' => 500
            ], 500);
        }
    }

    public function exportExcel()
    {
        $data = InvUom::where('com_code', auth()->guard('admin')->user()->com_code)
            ->select('id', 'name', 'is_master', 'active')
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
                return ['ID', 'Name', 'Main?', 'Active'];
            }

        }, 'uoms.xlsx');
    }

    public function exportPdf()
    {
        $treasuries = InvUom::where('com_code', auth()->guard('admin')->user()->com_code)
            ->orderBy('id', 'desc')
            ->get();

        $html = '
            <h2 style="text-align:center">Uoms Report</h2>
            <table width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#f0f0f0">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Main?</th>
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
                    <td>' . ($treasury->is_master ? "Yes" : "No") . '</td>
                    <td>' . ($treasury->active ? "Active" : "Inactive") . '</td>
                </tr>
            ';
        }

        $html .= '</tbody></table>';

        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('uoms.pdf');
    }

    public function searchByName(Request $request)
    {
        $uoms = InvUom::where('com_code', auth()->guard('admin')->user()->com_code)
            ->where('name', 'like', '%' . $request->name . '%')
            ->paginate(PAGINATE_COUNT);

        $uoms = $uoms->map(function ($item) {
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
            'uoms' => $uoms,
        ], 200);
    }

    public function filterByType(Request $request)
    {
        if ($request->filter == 1) {
            $uoms = InvUom::where('com_code', auth()->guard('admin')->user()->com_code)
                ->where('is_master', 1)
                ->orderBy('id', 'desc')
                ->paginate(PAGINATE_COUNT);
        } else if ($request->filter == 0) {
            $uoms = InvUom::where('com_code', auth()->guard('admin')->user()->com_code)
                ->where('is_master', 0)
                ->orderBy('id', 'desc')
                ->paginate(PAGINATE_COUNT);
        } else {
            $uoms = InvUom::where('com_code', auth()->guard('admin')->user()->com_code)
                ->orderBy('id', 'desc')
                ->paginate(PAGINATE_COUNT);
        }

        // $uoms = $uoms->map(function ($item) {
        //     $dt = new DateTime($item->updated_at);
        //     $item->date = $dt->format('Y-m-d');
        //     $item->time = $dt->format('h:i');
        //     $newDateTime = date('A', strtotime($item->time));
        //     $item->newDateTimeType = $newDateTime == 'AM' ? 'صباحا' : 'مساء';
        //     $item->added_by_admin = Admin::where('id', $item->added_by)->value('name');
        //     $item->updated_by_admin = Admin::where('id', $item->updated_by)->value('name');

        //     return $item;
        // });

        return response()->json([
            'status' => true,
            'uoms' => $uoms,
        ], 200);
    }
}