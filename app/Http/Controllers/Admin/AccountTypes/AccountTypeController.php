<?php

namespace App\Http\Controllers\Admin\AccountTypes;

use App\Http\Controllers\Controller;
use App\Models\AccountType;
use App\Traits\HasColumnsModel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class AccountTypeController extends Controller
{
    use HasColumnsModel;
    
    public function index()
    {
        return view('admin.account_types.index');
    }

    public function getData()
    {
        $com_code = auth()->guard('admin')->user()->com_code;
        $account_types = $this->getColsWhere(
            AccountType::class,
            ['*'],
            ['com_code' => $com_code],
        )->paginate(PAGINATE_COUNT);

        return response()->json([
            'account_types' => $account_types
        ]);
    }

    public function exportExcel()
    {
        $data = AccountType::where('com_code', auth()->guard('admin')->user()->com_code)
            ->select(
                'id',
                'name',
                'date',
                'last_update',
                'relatediternalaccounts',
                'active',
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
                    'Date',
                    'Last Update',
                    'Related Iternal Accounts',
                    'Active?'
                ];
            }

        }, 'account_types.xlsx');
    }

    public function exportPdf()
    {
        $invItemsCard = $this->getColsWhere(
            AccountType::class,
            ['*'],
            ['com_code' => auth()->guard('admin')->user()->com_code]
        )->get();

        $html = '
            <h2 style="text-align:center">Account Types Report</h2>
            <table width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#f0f0f0">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Last Update</th>
                    <th>Related Iternal Accounts</th>
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
                    <td>' . $value->date . '</td>
                    <td>' . $value->last_update . '</td>
                    <td>' . $value->relatediternalaccounts  . '</td>
                    <td>' . ($value->active ? "Active" : "Inactive") . '</td>
                </tr>
            ';
        }

        $html .= '</tbody></table>';

        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('account_types.pdf');
    }
}
