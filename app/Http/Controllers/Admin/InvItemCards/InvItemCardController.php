<?php

namespace App\Http\Controllers\Admin\InvItemCards;

use App\Http\Controllers\Controller;
use App\Models\InvItemCard;
use App\Traits\HasColumnsModel;
use App\Http\Requests\Admin\InvItemCards\InvItemCardRequest;
use App\Http\Resources\Admin\InvItemCard\InvItemCardResource;
use App\Models\Admin;
use App\Models\InvItemCardCategory;
use App\Models\InvUom;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvItemCardController extends Controller
{
    use HasColumnsModel;

    public function index()
    {
        return view('admin.item-cards.index');
    }

    public function getCategoriesNames()
    {
        $com_code = auth()->guard('admin')->user()->com_code;
        $categories = $this->getColsWhere(
            InvItemCardCategory::class,
            ['id', 'name'],
            ['com_code' => $com_code, 'active' => 1]
        )->get();

        return response()->json([
            'categories' => $categories
        ]);
    }

    public function getItemCardData()
    {
        $data = $this->getColsWhere(InvItemCard::class, ['*'], ['com_code' => auth()->guard('admin')->user()->com_code], 'id', 'desc')
            ->paginate(PAGINATE_COUNT);

        if (!empty($data)) {
            foreach ($data as $value) {
                $value->added_by_admin = $this->getFieldValue(Admin::class, 'name', ['id' => $value->added_by]);
                $value->item_card_category_name = $this->getFieldValue(InvItemCardCategory::class, 'name', ['id' => $value->inv_item_card_category_id]);
                $value->parent_item_card_id = $this->getFieldValue(InvItemCard::class, 'name', ['id' => $value->parent_inv_item_card_id]);
                $value->uom_name = $this->getFieldValue(InvUom::class, 'name', ['id' => $value->inv_uom_id]);
                $value->retail_uom_name = $this->getFieldValue(InvItemCardCategory::class, 'name', ['id' => $value->retail_uom_id]);

                if ($value->updated_by != null || $value->updated_by > 0) {
                    $value->updated_by_admin = $this->getFieldValue(Admin::class, 'name', ['id' => $value->updated_by]);
                }
            }
        }
        $itemcard_categories = $this->getColsWhere(InvItemCardCategory::class, ['*'], ['com_code' => auth()->guard('admin')->user()->com_code]);
        return response()->json([
            'item_cards' => $data,
            'itemcard_categories' => $itemcard_categories
        ]);
    }

    // public function getChildUom(Request $request, $parentId)
    // {
    //     $com_code = auth()->guard('admin')->user()->com_code;
    //     return $this->getColsWhere(
    //         InvUom::class,
    //         ['id', 'name'],
    //         ['com_code' => $com_code, 'is_master' => 0, 'active' => 1]
    //     )->get();
    // }

    public function create()
    {
        return view('admin.item-cards.create');
    }

    public function getDataForCreate()
    {
        $com_code = auth()->guard('admin')->user()->com_code;
        $categories = $this->getColsWhere(
            InvItemCardCategory::class,
            ['id', 'name'],
            ['com_code' => $com_code, 'active' => 1]
        )->get();

        $inv_uoms_parent = $this->getColsWhere(
            InvUom::class,
            ['id', 'name', 'is_master'],
            ['com_code' => $com_code, 'active' => 1, 'is_master' => 1]
        )->get();

        $inv_uoms_child = $this->getColsWhere(
            InvUom::class,
            ['id', 'name', 'is_master'],
            ['com_code' => $com_code, 'active' => 1, 'is_master' => 0]
        )->get();

        $inv_parent_data = $this->getColsWhere(
            InvItemCard::class,
            ['id', 'name'],
            ['com_code' => $com_code, 'active' => 1]
        )->get();

        return response()->json([
            'categories' => $categories,
            'inv_uoms_parent' => $inv_uoms_parent,
            'inv_uoms_child' => $inv_uoms_child,
            'inv_parent_data' => $inv_parent_data
        ]);
    }

    public function store(InvItemCardRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->guard('admin')->user();
            $item_code = (string) now()->format('YmdHis') . random_int(1000, 9999);
            $barcode = "item" . $item_code;

            $inv_item_card = InvItemCard::create([
                'barcode' => $request->barcode ?? $barcode,
                'item_code' => $item_code,
                'name' => $request->name,
                'item_type' => $request->item_type,
                'inv_item_card_category_id' => $request->inv_item_card_category_id,
                'parent_inv_item_card_id' => $request->parent_inv_item_card_id ?? null,
                'inv_uom_id' => $request->inv_uom_id,
                'inv_retail_uom_id' => $request->inv_retail_uom_id,
                'com_code' => $user->com_code ?? null,
                'added_by' => $user->id,
                'does_has_retailunit' => $request->does_has_retailunit ?? null,
                'retail_uom_quntToParent' => $request->retail_uom_quntToParent,
                'price_uom' => $request->price_uom,
                'half_gomla_price_uom' => $request->half_gomla_price_uom,
                'gomla_price_uom' => $request->gomla_price_uom,
                'price_retail' => $request->price_retail,
                'half_gomla_price_retail' => $request->half_gomla_price_retail,
                'gomla_price_retail' => $request->gomla_price_retail,
                'cost_price' => $request->cost_price,
                'cost_price_retail' => $request->cost_price_retail,
                'has_fixed_price' => $request->has_fixed_price,
                'active' => $request->active,
                'date' => date('Y-m-d'),
            ]);

            if ($request->hasFile('image')) {
                $inv_item_card->update([
                    'image' => $request->file('image')
                        ->store(
                            "inv_item_cards/images/{$inv_item_card->name}",
                            'uploads'
                        )
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'تم الحفظ بنجاح',
            ]);
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

    public function showPage($id)
    {
        return view('admin.item-cards.show', compact('id'));
    }

    public function show($id)
    {
        $com_code = auth()->guard('admin')->user()->com_code;
        $item = InvItemCard::where('com_code', $com_code)->findOrFail($id);
        return new InvItemCardResource($item);
    }

    public function edit($id)
    {
        return view('admin.item-cards.edit', compact('id'));
    }

    public function update(InvItemCardRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->guard('admin')->user();
            $inv_item_card = InvItemCard::findOrFail($request->id);

            $inv_item_card->update([
                'name' => $request->name,
                'item_type' => $request->item_type,
                'inv_item_card_category_id' => $request->inv_item_card_category_id,
                'parent_inv_item_card_id' => $request->parent_inv_item_card_id ?? null,
                'inv_uom_id' => $request->inv_uom_id,
                'inv_retail_uom_id' => $request->inv_retail_uom_id,
                'updated_by' => $user->id,
                'does_has_retailunit' => $request->does_has_retailunit ?? null,
                'retail_uom_quntToParent' => $request->retail_uom_quntToParent,
                'price_uom' => $request->price_uom,
                'half_gomla_price_uom' => $request->half_gomla_price_uom,
                'gomla_price_uom' => $request->gomla_price_uom,
                'price_retail' => $request->price_retail,
                'half_gomla_price_retail' => $request->half_gomla_price_retail,
                'gomla_price_retail' => $request->gomla_price_retail,
                'cost_price' => $request->cost_price,
                'cost_price_retail' => $request->cost_price_retail,
                'has_fixed_price' => $request->has_fixed_price,
                'active' => $request->active,
                'date' => date('Y-m-d'),
            ]);

            if ($request->hasFile('image')) {
                $inv_item_card->update([
                    'image' => $request->file('image')
                        ->store(
                            "inv_item_cards/images/{$inv_item_card->name}",
                            'uploads'
                        )
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'تم التعديل بنجاح',
            ]);
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
        $data = InvItemCard::where('com_code', auth()->guard('admin')->user()->com_code)
            ->select(
                'id',
                'name',
                'barcode',
                'item_type',
                'inv_item_card_category_id',
                'parent_inv_item_card_id',
                'inv_uom_id',
                'inv_retail_uom_id',
                'does_has_retailunit',
                'retail_uom_quntToParent',
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
                    'Barcode',
                    'Item Type',
                    'Item Card Category',
                    'Parent Item Card',
                    'UOM',
                    'Retail UOM',
                    'Has Retail Unit',
                    'Retail UOM Qunt To Parent',
                    'Active?'
                ];
            }

        }, 'item-cards.xlsx');
    }

    public function exportPdf()
    {
        $invItemsCard = $this->getColsWhere(
            InvItemCard::class,
            ['*'],
            ['com_code' => auth()->guard('admin')->user()->com_code]
        )->get();

        $html = '
            <h2 style="text-align:center">Item Cards Report</h2>
            <table width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#f0f0f0">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Barcode</th>
                    <th>Item Type</th>
                    <th>Item Card Category</th>
                    <th>Parent Item Card</th>
                    <th>UOM</th>
                    <th>Retail UOM</th>
                    <th>Has Retail Unit</th>
                    <th>Retail UOM Qunt To Parent</th>
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
                    <td>' . $value->barcode . '</td>
                    <td>' . $value->item_type . '</td>
                    <td>' . $value->category->name . '</td>
                    <td>' . $value->parent_inv_item_card_id . '</td>
                    <td>' . $value->uom->name . '</td>
                    <td>' . $value->inv_retail_uom_id . '</td>
                    <td>' . $value->does_has_retailunit . '</td>
                    <td>' . $value->retail_uom_quntToParent . '</td>
                    <td>' . ($value->active ? "Active" : "Inactive") . '</td>
                </tr>
            ';
        }

        $html .= '</tbody></table>';

        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('item-cards.pdf');
    }

    public function filter(Request $request)
    {
        $query = InvItemCard::where(
            'com_code',
            auth()->guard('admin')->user()->com_code
        );

        if ($request->filter_by_type !== 'all') {
            $query->where('item_type', $request->filter_by_type);
        }

        if ($request->filter_by_category !== 'all') {
            $query->where('inv_item_card_category_id', $request->filter_by_category);
        }

        $data = $query->orderBy('id', 'desc')
            ->paginate(PAGINATE_COUNT);

        // 👇 نفس المعالجة اللي بتعملها في getItemCardData
        foreach ($data as $value) {
            $value->added_by_admin = $this->getFieldValue(Admin::class, 'name', ['id' => $value->added_by]);
            $value->item_card_category_name = $this->getFieldValue(
                InvItemCardCategory::class,
                'name',
                ['id' => $value->inv_item_card_category_id]
            );
            $value->parent_item_card_id = $this->getFieldValue(
                InvItemCard::class,
                'name',
                ['id' => $value->parent_inv_item_card_id]
            );
            $value->uom_name = $this->getFieldValue(
                InvUom::class,
                'name',
                ['id' => $value->inv_uom_id]
            );
            $value->retail_uom_name = $this->getFieldValue(
                InvUom::class,
                'name',
                ['id' => $value->retail_uom_id]
            );

            if (!empty($value->updated_by)) {
                $value->updated_by_admin = $this->getFieldValue(Admin::class, 'name', ['id' => $value->updated_by]);
            }
        }

        return response()->json([
            'item_cards' => $data
        ]);
    }

    public function textSearch(Request $request)
    {
        $search = $request->search;

        $itemCard = InvItemCard::where('com_code',auth()->guard('admin')->user()->com_code)
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('barcode', 'like', "%{$search}%")
                ->orWhere('item_code', 'like', "%{$search}%");
            })
            ->paginate(PAGINATE_COUNT);

        $itemCard->getCollection()->transform(function ($item) {
            $item->item_card_category_name = $item->category?->name;
            $item->uom_name = $item->uom?->name;
            // $item->retail_uom_name = $item->retail_uom?->name;
            // $item->parent_item_name = $item->parentItem?->name;

            return $item;
        });

        return response()->json([
            'status' => true,
            'itemCard' => $itemCard,
        ]);
    }

    public function destroy(InvItemCardRequest $request)
    {
        DB::beginTransaction();
        try {
            InvItemCard::where('id', $request->id)->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'تم الحذف بنجاح',
            ]);
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
}
