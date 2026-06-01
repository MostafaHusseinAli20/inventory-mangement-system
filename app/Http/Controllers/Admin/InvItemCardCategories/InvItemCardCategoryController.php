<?php

namespace App\Http\Controllers\Admin\InvItemCardCategories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InvItemCardCategory\InvItemCardCategoryRequest;
use App\Models\Admin;
use App\Models\InvItemCard;
use App\Models\InvItemCardCategory;
use App\Traits\HasColumnsModel;
use DateTime;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class InvItemCardCategoryController extends Controller
{
    use HasColumnsModel;

    public function index()
    {
        return view('admin.item-card-categories.index');
    }

    public function getItemCardCategoryData()
    {
        $itemCards = $this->getColsWhere(InvItemCardCategory::class, ['*'], ['com_code' => auth()->guard('admin')->user()->com_code])
            ->paginate(PAGINATE_COUNT);

        if (!empty($itemCards)) { {
                foreach ($itemCards as $treasury) {
                    $treasury->added_by_admin = $this->getFieldValue(Admin::class, 'name', ['id' => $treasury->added_by]);
                    if ($treasury->updated_by != null || $treasury->updated_by > 0) {
                        $treasury->updated_by_admin = $this->getFieldValue(Admin::class, 'name', ['id' => $treasury->updated_by]);
                    }
                }
            }
        }

        $dt = new DateTime($itemCards['updated_at']);
        $date = $dt->format('Y-m-d');
        $time = $dt->format('h:i');
        $newDateTime = date('A', strtotime($time));
        $newDateTimeType = $newDateTime == 'AM' ? 'صباحا ' : 'مساء';

        return response()->json([
            'itemCards' => $itemCards,
            'date' => $date,
            'time' => $time,
            'newDateTimeType' => $newDateTimeType
        ]);
    }

    public function create()
    {
        return view('admin.item-card-categories.create');
    }

    public function store(InvItemCardCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            if(
                !$request->all() ||
                empty($request->all()) ||
                $request->name == '' || 
                $request->active == ''
            ){
                DB::rollBack();
                return response()->json([
                    'satus' => false,
                    'message' => 'من فضلك ادخل جميع الحقول',
                ]);
            }

            InvItemCardCategory::create([
                'name' => $request->name,
                'added_by' => auth()->guard('admin')->user()->id,
                'com_code' => auth()->guard('admin')->user()->com_code,
                'active' => $request->active
            ]);
            DB::commit();
            return response()->json([
                'satus' => true,
                'message' => 'تم الاضافة بنجاح',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    public function show($id)
    {
        return view('admin.item-card-categories.show', compact('id'));
    }

    public function showJson($id)
    {
        $itemCard = InvItemCardCategory::findOrFail($id);
        return response()->json([
            'data' => $itemCard
        ]);
    }

    public function edit($id)
    {
        return view('admin.item-card-categories.edit');
    }

    public function update(InvItemCardCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $invItemCardCategory = InvItemCardCategory::findOrFail($request->id);
            $invItemCardCategory->update([
                'name' => $request->name,
                'active' => $request->active,
                'updated_by' => auth()->guard('admin')->user()->id
            ]);
            DB::commit();
            return response()->json([
                'satus' => true,
                'message' => 'تم التعديل بنجاح',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    public function destroy(InvItemCardCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            InvItemCardCategory::where('id', $request->id)->delete();
            DB::commit();
            return response()->json([
                'satus' => true,
                'message' => 'تم الحذف بنجاح',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    public function exportExcel()
    {
        $data = InvItemCardCategory::where('com_code', auth()->guard('admin')->user()->com_code)
            ->select(
                'id',
                'name',
                'created_at',
                'updated_at',
                'active'
            )
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
                return [
                    'ID',
                    'Name',
                    'Created At',
                    'Updated At',
                    'Active?'
                ];
            }

        }, 'item-card-categories.xlsx');
    }

    public function exportPdf()
    {
        $invItemsCard = $this->getColsWhere(
            InvItemCardCategory::class,
            ['id', 'name', 'created_at', 'updated_at', 'active'],
            ['com_code' => auth()->guard('admin')->user()->com_code]
        )->get();

        $html = '
            <h2 style="text-align:center">Item Card Categories Report</h2>
            <table width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#f0f0f0">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Active?</th>
                </tr>
            </thead>
            <tbody>
        ';

        foreach ($invItemsCard as $value) {
            $html .= '
                <tr>
                    <td>' . $value->id . '</td>
                    <td>' . $value->name . '</td>
                    <td>' . $value->created_at . '</td>
                    <td>' . $value->updated_at . '</td>
                    <td>' . ($value->active ? "Active" : "Inactive") . '</td>
                </tr>
            ';
        }

        $html .= '</tbody></table>';

        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('item-card-categories.pdf');
    }
}
