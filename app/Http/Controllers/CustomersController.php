<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customers;
use Helper;
use DataTables;

class CustomersController extends Controller
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

        return view('content/customer/index', [
            'title'       => 'Customer',
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function toselect(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = new Customers;
            
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

    public function show($id)
    {
        if($sql = Customers::find($id))
        {
            return $this->resSuccess($sql,'');
        }

        return $this->resError('Data not found!',422);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'        => 'required|unique:customers,name',
        ];

        $attribute = [
            'name'        => 'Nama',
        ];

        $request->validate($rules, [] ,$attribute);

        \DB::beginTransaction();
        try {
            $sql                = new Customers;
            $sql->name          = $request->name;

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
            'name'        => 'required|unique:customers,name,'.$id,
        ];

        $attribute = [
            'name'        => 'Nama',
        ];

        $request->validate($rules, [] ,$attribute);

        \DB::beginTransaction();
        try {
            $sql                = Customers::find($id);
            $sql->name          = $request->name;

            if($sql->save())
            {
                \DB::commit();
                return $this->resSuccess($sql,'Data updated successfully.');
            }

        } catch (\Exception $e) {
            \Log::error($e);
            return $this->resError('Internal Error!',500);
        }
    }
}
