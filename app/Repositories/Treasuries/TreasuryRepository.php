<?php

namespace App\Repositories\Treasuries;

use App\Interfaces\Treasuries\TreasuryInterface;
use App\Models\Admin;
use App\Models\Treasury;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Admin\Treasuries\TreasuryRequest;

class TreasuryRepository implements TreasuryInterface
{
    public function index()
    {
        return view('admin.treasuries.index');
    }

    public function get_treasury_data()
    {
        $treasuries = Treasury::where('com_code', auth()->guard('admin')->user()->com_code)
            ->paginate(PAGINATE_COUNT);

        if (!empty($treasuries)) { {
                foreach ($treasuries as $treasury) {
                    $treasury->added_by_admin = Admin::where('id', $treasury->added_by)->value('name');
                    if ($treasury->updated_by != null || $treasury->updated_by > 0) {
                        $treasury->updated_by_admin = Admin::where('id', $treasury->updated_by)->value('name');
                    }
                }
            }
        }

        $dt = new DateTime($treasuries['updated_at']);
        $date = $dt->format('Y-m-d');
        $time = $dt->format('h:i');
        $newDateTime = date('A', strtotime($time));
        $newDateTimeType = $newDateTime == 'AM' ? 'صباحا ' : 'مساء';


        return response()->json([
            'treasuries' => $treasuries,
            'date' => $date,
            'time' => $time,
            'newDateTimeType' => $newDateTimeType
        ]);
    }

    public function create()
    {
        return view('admin.treasuries.create');
    }

    public function store(TreasuryRequest $request)
    {
        DB::beginTransaction();
        try {
            $com_code = auth()->guard('admin')->user()->com_code;
            $checkExists = Treasury::where('name', $request->name)
                ->where('com_code', $com_code)
                ->first();

            if (!$checkExists || $checkExists == null) {
                if ($request->is_master == 1) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'مسموح بصندوق رئيسي واحد فقط',
                    ]);
                } else {
                    Treasury::create([
                        'name' => $request->name,
                        'is_master' => $request->is_master,
                        'last_recipt_exchange' => $request->last_recipt_exchange,
                        'last_recipt_collect' => $request->last_recipt_collect,
                        'added_by' => auth()->guard('admin')->user()->id,
                        'com_code' => $com_code,
                        'active' => $request->active,
                        'date' => $request->date,
                    ]);

                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'message' => 'تم اضافة الصندوق بنجاح'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'اسم الصندوق موجود بالفعل',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function exportExcel()
    {
        $data = Treasury::where('com_code', auth()->guard('admin')->user()->com_code)
            ->select('id', 'name', 'is_master', 'last_recipt_exchange', 'last_recipt_collect', 'active', 'date')
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
                return ['ID', 'Name', 'Main?', 'Last Exchange', 'Last Collect', 'Active', 'Date'];
            }

        }, 'treasuries.xlsx');
    }

    public function exportPdf()
    {
        $treasuries = Treasury::where('com_code', auth()->guard('admin')->user()->com_code)
            ->orderBy('id', 'desc')
            ->get();

        $html = '
            <h2 style="text-align:center">Treasuries Report</h2>
            <table width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#f0f0f0">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Main?</th>
                    <th>Last Exchange</th>
                    <th>Last Collect</th>
                    <th>Active?</th>
                    <th>Date</th>
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
                    <td>' . $treasury->last_recipt_exchange . '</td>
                    <td>' . $treasury->last_recipt_collect . '</td>
                    <td>' . ($treasury->active ? "Active" : "Inactive") . '</td>
                    <td>' . ($treasury->date ?? "-") . '</td>
                </tr>
            ';
        }

        $html .= '</tbody></table>';

        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('treasuries.pdf');
    }

    public function show($id)
    {
        $treasury = Treasury::findOrFail($id);
        $dt = new DateTime($treasury['updated_at']);
        $date = $dt->format('Y-m-d');
        $time = $dt->format('h:i');
        $newDateTime = date('A', strtotime($time));
        $newDateTimeType = $newDateTime == 'AM' ? 'صباحا ' : 'مساء';
        return response()->json([
            'treasury' => $treasury,
            'date' => $date,
            'time' => $time,
            'newDateTimeType' => $newDateTimeType
        ]);
    }

    public function edit($id)
    {
        $treasury = Treasury::findOrFail($id);
        return view('admin.treasuries.edit', [
            'treasury' => $treasury
        ]);
    }

    public function update(TreasuryRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $com_code = auth()->guard('admin')->user()->com_code;
            $treasury = Treasury::where('com_code', $com_code)->findOrFail($id);

            // ============================
            // 1) ممنوع تغيير اسم الصندوق الرئيسي
            // ============================
            if ($treasury->is_master == 1 && $treasury->name != $request->name) {
                return response()->json([
                    'status' => false,
                    'message' => 'لا يمكن تغيير اسم الصندوق الرئيسي',
                ], 422);
            }

            // ============================
            // 2) ممنوع تكرار اسم أي صندوق آخر داخل الشركة
            // ============================
            $exists = Treasury::where('com_code', $com_code)
                ->where('name', $request->name)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'message' => 'اسم الصندوق موجود بالفعل',
                ], 422);
            }

            // ============================
            // 3) ممنوع للفرعي استخدام اسم الرئيسي
            // ============================
            $mainTreasury = Treasury::where('com_code', $com_code)
                ->where('is_master', 1)
                ->first();
            if (
                $mainTreasury &&
                $mainTreasury->id != $id &&
                $request->name == $mainTreasury->name
            ) {
                return response()->json([
                    'status' => false,
                    'message' => 'لا يمكن لصندوق فرعي استخدام اسم الصندوق الرئيسي',
                ], 422);
            }

            // ============================
            // 4) ممنوع يكون فيه صندوق رئيسي آخر
            // ============================
            if ($request->is_master == 1) {
                $anotherMain = Treasury::where('com_code', $com_code)
                    ->where('is_master', 1)
                    ->where('id', '!=', $id)
                    ->exists();

                if ($anotherMain) {
                    return response()->json([
                        'status' => false,
                        'message' => 'يوجد صندوق رئيسي بالفعل ولا يمكن إنشاء آخر',
                    ], 422);
                }
            }

            // ============================
            // تحديث البيانات
            // ============================
            $treasury->update([
                'name' => $request->name,
                'is_master' => $request->is_master,
                'last_recipt_exchange' => $request->last_recipt_exchange,
                'last_recipt_collect' => $request->last_recipt_collect,
                'active' => $request->active,
                'date' => $request->date,
                'updated_by' => auth()->guard('admin')->user()->id,
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'تم التعديل بنجاح'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function searchByName(Request $request)
    {
        $treasuries = Treasury::where('com_code', auth()->guard('admin')->user()->com_code)
            ->where('name', 'like', '%' . $request->name . '%')
            ->get();

        $treasuries = $treasuries->map(function ($item) {
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
            'treasuries' => $treasuries
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $treasury = Treasury::findOrFail($id);
        $treasury->delete();
        return response()->json([
            'status' => true,
            'message' => 'تم حذف الصندوق بنجاح'
        ]);
    }
}