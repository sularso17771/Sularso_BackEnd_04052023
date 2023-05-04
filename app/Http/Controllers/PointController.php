<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customers;
use Helper;
use DataTables;

class PointController extends Controller
{
    public function index(Request $request)
    {
        $pageConfigs = [
            'pageHeader'        => false,
            'title'             => 'Customer',
            'theme'             => 'semi-dark',
        ];

        $breadcrumbs = [
            ['link'=>"/",'name'=>"Dashboard"],
            ['name'=>"Customer"]
        ];

        return view('content/point/index', [
            'title'       => 'Customer',
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function toJson(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = new Customers;
            
            if ($search = $request->search) 
            {
                $data = $data->search(['name'], $search);
            }

            return DataTables::of($data->get())
                ->addIndexColumn()
                ->make(true);
        }        
    }
}
