<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Accounts\ShowAccountResource;
use App\Models\Account;
use App\Models\AccountType;
use App\Traits\HasColumnsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class AccountController extends Controller
{
    use HasColumnsModel;
    public function index()
    {
        return view('admin.accounts.index');
    }

    public function getData()
    {
        $com_code = auth()->guard('admin')->user()->com_code;
        $accounts = $this->getColsWhere(
            Account::class,
            ['*'],
            ['com_code' => $com_code]
        )->with([
                    'account_type',
                    'parent_account',
                    'added_by',
                    'updated_by'
                ])->paginate(PAGINATE_COUNT);

        return response()->json([
            'accounts' => $accounts
        ]);
    }

    public function create()
    {
        return view('admin.accounts.create');
    }

    public function getAccountTypesAndParentAccounts()
    {
        $com_code = auth()->guard('admin')->user()->com_code;
        $account_types = $this->getColsWhere(
            AccountType::class,
            ['id', 'name'],
            ['com_code' => $com_code, 'active' => 1, 'relatediternalaccounts' => 0]
        )->get();

        $parent_accounts = $this->getColsWhere(
            Account::class,
            ['account_number', 'name'],
            ['com_code' => $com_code, 'is_parent' => 1]
        )->get();
        return response()->json([
            'account_types' => $account_types,
            'parent_accounts' => $parent_accounts
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $com_code = auth()->guard('admin')->user()->com_code;

            $account = new Account();

            $account->name = $request->name;
            $account->account_type_id = $request->account_type_id;
            $account->is_parent = $request->is_parent;

            # account number
            if (!$request->account_number) {

                do {

                    $account_number = random_int(100000000, 999999999);

                } while (
                    Account::where('account_number', $account_number)
                        ->where('com_code', $com_code)
                        ->exists()
                );

                $account->account_number = $account_number;

            } else {

                $account->account_number = $request->account_number;
            }

            # parent account
            if ($request->is_parent == 0) {

                $account->parent_account_number = $request->parent_account_number;

            } else {

                $account->parent_account_number = null;
            }

            # start balance
            $account->start_balance_status = $request->start_balance_status;

            if ($request->start_balance_status == 1) {

                # دائن
                $account->start_balance = $request->start_balance * -1;

            } elseif ($request->start_balance_status == 2) {

                # مدين
                $account->start_balance = $request->start_balance;

            } else {

                # متزن
                $account->start_balance = 0;
            }

            $account->current_balance = $account->start_balance;

            # other fields
            $account->notes = $request->notes;
            $account->active = $request->active;
            $account->com_code = $com_code;
            $account->added_by = auth()->guard('admin')->id();

            $account->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'تم إضافة الحساب بنجاح'
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

    public function getItem($id)
    {
        $account = Account::with([
            'account_type',
            'parent_account',
            'added_by',
            'updated_by'
        ])->find($id);

        return ShowAccountResource::make($account);
    }

    public function edit($id)
    {
        return view('admin.accounts.edit', [
            'id' => $id
        ]);
    }

    public function exportExcel()
    {
        $data = Account::where('com_code', auth()->guard('admin')->user()->com_code)
            ->select(
                'id',
                'name',
                'account_type_id',
                'is_parent',
                'parent_account_number',
                'account_number',
                'start_balance_status',
                'start_balance',
                'current_balance',
                'date',
                'active',
            )
            ->orderBy('id', 'desc')
            ->get();

        return Excel::download(
            new class ($data) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {

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
                'Account Type ID',
                'Is Parent',
                'Parent Account Number',
                'Account Number',
                'Start Balance Status',
                'Start Balance',
                'Current Balance',
                'Date',
                'Active?'
                ];
            }
            },
            'accounts.xlsx'
        );
    }

    public function exportPdf()
    {
        $accounts = $this->getColsWhere(
            Account::class,
            ['*'],
            ['com_code' => auth()->guard('admin')->user()->com_code]
        )->get();

        $html = '
            <h2 style="text-align:center">Accounts Report</h2>
            <table width="100%" border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse;">
            <thead>
                <tr style="background:#f0f0f0">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Account Type</th>
                    <th>Is Parent</th>
                    <th>Parent Account Number</th>
                    <th>Account Number</th>
                    <th>Start Balance Status</th>
                    <th>Start Balance</th>
                    <th>Current Balance</th>
                    <th>Date</th>
                    <th>Active?</th>
                </tr>
            </thead>
            <tbody>
        ';

        foreach ($accounts as $value) {
            $html .= '
                <tr>
                    <td>' . $value->id . '</td>
                    <td>' . $value->name . '</td>
                    <td>' . $value->accountType->name . '</td>
                    <td>' . ($value->is_parent ? "Yes" : "No") . '</td>
                    <td>' . $value->parent_account_number . '</td>
                    <td>' . $value->account_number . '</td>
                    <td>' . $value->start_balance_status . '</td>
                    <td>' . $value->start_balance . '</td>
                    <td>' . $value->current_balance . '</td>
                    <td>' . $value->date . '</td>
                    <td>' . ($value->active ? "Active" : "Inactive") . '</td>
                </tr>
            ';
        }

        $html .= '</tbody></table>';

        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->download('accounts.pdf');
    }

    public function searchFilterAccounts(Request $request)
    {
        $accounts = Account::with([
            'account_type',
            'parent_account',
            'added_by',
            'updated_by'
        ]);

        // search name or number
        if ($request->search) {
            $accounts->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('account_number', 'like', '%' . $request->search . '%');
            });
        }

        // account type
        if ($request->account_type != 'all') {
            $accounts->where('account_type_id', $request->account_type);
        }

        // is parent
        if ($request->is_parent != 'all') {
            $accounts->where('is_parent', $request->is_parent);
        }

        // active
        if ($request->active != 'all') {
            $accounts->where('active', $request->active);
        }

        $accounts = $accounts->latest()->paginate(10);

        return response()->json([
            'accounts' => $accounts,
            'account_types' => AccountType::where('com_code', auth()->guard('admin')->user()->com_code)->get()
        ]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $com_code = auth()->guard('admin')->user()->com_code;

            $account = Account::where('id', $id)
                ->where('com_code', $com_code)
                ->first();

            if (!$account) {
                return response()->json([
                    'status' => false,
                    'message' => 'الحساب غير موجود'
                ], 404);
            }

            $account->name = $request->name;
            $account->account_type_id = $request->account_type_id;
            $account->is_parent = $request->is_parent;

            # account number
            if (!$request->account_number) {

                // سيب القديم زي ما هو
            } else {

                // تأكد إنه مش مكرر
                $exists = Account::where('account_number', $request->account_number)
                    ->where('com_code', $com_code)
                    ->where('id', '!=', $id)
                    ->exists();

                if ($exists) {
                    return response()->json([
                        'status' => false,
                        'message' => 'رقم الحساب مستخدم بالفعل'
                    ], 400);
                }

                $account->account_number = $request->account_number;
            }

            # parent account
            if ($request->is_parent == 0) {

                $account->parent_account_number = $request->parent_account_number;

            } else {

                $account->parent_account_number = null;
            }

            # start balance
            $account->start_balance_status = $request->start_balance_status;

            if ($request->start_balance_status == 1) {

                # دائن
                $account->start_balance = $request->start_balance * -1;

            } elseif ($request->start_balance_status == 2) {

                # مدين
                $account->start_balance = $request->start_balance;

            } else {

                # متزن
                $account->start_balance = 0;
            }

            $account->current_balance = $account->start_balance;

            # other fields
            $account->notes = $request->notes;
            $account->active = $request->active;
            $account->updated_by = auth()->guard('admin')->id();

            $account->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'تم تحديث الحساب بنجاح'
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

    public function getParentAccountData($id)
    {
        $parent_account = Account::where('id', $id)
            ->where('com_code', auth()->guard('admin')->user()->com_code)
            ->first();

        if (!$parent_account) {
            return response()->json([
                'status' => false,
                'message' => 'الحساب الأب غير موجود'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'parent_account' => [
                'account_number' => $parent_account->account_number,
                'name' => $parent_account->name,
                'current_balance' => $parent_account->current_balance,
            ]
        ]);
    }

    public function destroy($id)
    {
        // delete account
    }
}
