<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transactions;
use Helper;
use DataTables;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $pageConfigs = [
            'pageHeader'        => false,
            'title'             => 'Transactions',
            'theme'             => 'semi-dark',
        ];

        $breadcrumbs = [
            ['link'=>"/",'name'=>"Dashboard"],
            ['name'=>"Transactions"]
        ];

        return view('content/transaction/index', [
            'title'       => 'Transactions',
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function toselect(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = new Transactions;
            
            if ($search = $request->search) 
            {
                $data = $data->search(['name'], $search);
            }

            return $this->resSuccess($data->paginate($request->per_page ? $request->per_page : 10),'');
        }        
    }

    public function toJson(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = new Transactions;
            
            if ($search = $request->search) 
            {
                $data = $data->search(['customer_id','description'], $search);
            }

            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('TransactionDate', function($row) {
                    return \Carbon\Carbon::parse($row->TransactionDate)->format('Y-m-d');
                })
                ->addColumn('nominal', function($row) {
                    return number_format($row->Amount,0,',','.');
                })
                ->rawColumns(['TransactionDate','nominal'])
                ->make(true);
        }        
    }

    public function show($id)
    {
        if($sql = Transactions::with('customer')->find($id))
        {
            return $this->resSuccess($sql,'');
        }

        return $this->resError('Data not found!',422);
    }

    public function store(Request $request)
    {
        $rules = [
            'customer_id'       => 'required',
            'TransactionDate'   => 'required',
            'amount'            => 'required|numeric',
            'description'       => 'required',
        ];

        $attribute = [
            'customer_id'       => 'Account',
            'TransactionDate'   => 'Data',
            'amount'            => 'Nominal',
            'DebitCreditStatus' => 'Tipe',
        ];

        $request->validate($rules, [] ,$attribute);

        \DB::beginTransaction();
        try {
            $sql                    = new Transactions;
            $sql->customer_id       = $request->customer_id;
            $sql->TransactionDate   = $request->TransactionDate;
            $sql->Amount            = $request->amount;
            $sql->description       = $request->description;
            $sql->DebitCreditStatus = $request->description == 'Setor Tunai' ? 'C' : 'D';

            if($sql->save())
            {
                \DB::commit();
                return $this->resSuccess($sql,'Data added successfully.');
            }

        } catch (\Exception $e) {
            \Log::error($e);
            return $this->resError('Data added failed!',422);
        }
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'customer_id'       => 'required',
            'TransactionDate'   => 'required',
            'amount'            => 'required|numeric',
            'description'       => 'required',
        ];

        $attribute = [
            'customer_id'       => 'Account',
            'TransactionDate'   => 'Data',
            'amount'            => 'Nominal',
            'DebitCreditStatus' => 'Tipe',
        ];

        $request->validate($rules, [] ,$attribute);

        \DB::beginTransaction();
        try {
            $sql                    = Transactions::find($id);
            $sql->customer_id       = $request->customer_id;
            $sql->TransactionDate   = $request->TransactionDate;
            $sql->Amount            = $request->amount;
            $sql->description       = $request->description;
            $sql->DebitCreditStatus = $request->description == 'Setor Tunai' ? 'C' : 'D';

            if($sql->save())
            {
                \DB::commit();
                return $this->resSuccess($sql,'Data added successfully.');
            }

        } catch (\Exception $e) {
            \Log::error($e);
            return $this->resError('Data added failed!',422);
        }
    }
}
