<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Transactions;
use App\Models\Customers;
use Helper;
use DataTables;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $pageConfigs = [
            'pageHeader'        => false,
            'title'             => 'Report',
            'theme'             => 'semi-dark',
        ];

        $breadcrumbs = [
            ['link'=>"/",'name'=>"Dashboard"],
            ['name'=>"Report"]
        ];

        $customers = Customers::get();

        return view('content/report/index', [
            'title'       => 'Report',
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'customers'   => $customers
        ]);
    }

    public function toJson(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = Transactions::with('customer');
            
            if ($customer = $request->customer) 
            {
                $data = $data->search(['customer.id'], $customer);
            }

            if ($date = $request->date) 
            {
                $from = Str::replace(' ','',Str::of($date)->before('to'));
                $to   = Str::replace(' ','',Str::after($date, 'to'));
                $data  = $data->whereBetween('TransactionDate', [$from, $to]);
            }        

            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('TransactionDate', function($row) {
                    return \Carbon\Carbon::parse($row->TransactionDate)->format('Y-m-d');
                })
                ->addColumn('credit', function($row) {
                    return $row->DebitCreditStatus == 'C' ? $row->Amount : '-';
                })
                ->addColumn('debit', function($row) {
                    return $row->DebitCreditStatus == 'D' ? $row->Amount : '-';
                })
                ->addColumn('nominal', function($row) {
                    return number_format($row->Amount,0,',','.');
                })
                ->rawColumns(['TransactionDate','nominal'])
                ->make(true);
        }        
    }

    public function print(Request $request)
    {
        $data     = Transactions::with('customer');
        $cust     = 'All';
        $dates    = '';

        if ($customer = $request->customer) 
        {
            $data = $data->search(['customer_id'], $customer);
            $cust = Customers::find($customer);
        }        

        if ($date = $request->date) 
        {
            $from = Str::replace(' ','',Str::of($date)->before('to'));
            $to   = Str::replace(' ','',Str::after($date, 'to'));
            $data  = $data->whereBetween('TransactionDate', [$from, $to]);
            $dates = $date;
        }        

        // dd($data->get());
        return view('content/report/print', [
            'datas'     => $data->get(),
            'customer'  => $cust && isset($cust->name) ? $cust->name : 'All',
            'dates'     => $dates
        ]);
    }
}
