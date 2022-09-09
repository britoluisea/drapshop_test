<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\CustomerModel as Customer;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * obtener lista de customer segun user_id
     */
    public function getListCustomer(Request $request)
    {
        $list = Customer::where('user_id', $request['user_id'])->get();
        return response()->json(['list'=>$list]);
    }
    /**
     * crear o actualizar customer
     */
    public function setCustomer(Request $request)
    {
        $request->validate([
            'user_id' => ['required'],
            'name' => ['required'],
        ]);
        $d = [
            "name"=>$request['name'],
            "email"=>$request['email'],
            "address"=>$request['address'],
        ];
        $get = Customer::where('user_id', $request['user_id'])->first();
        if(!empty($get))
        {
            $r = Customer::where('id', $request['id'])
            ->where('user_id', $request['user_id'])
            ->update($d);
        }
        else{
            $d['user_id']=$request['user_id'];
            $r = Customer::create($d);
        }
        return response()->json(['status'=>($r)]);
    }
}
