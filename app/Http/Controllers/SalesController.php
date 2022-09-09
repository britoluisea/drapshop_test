<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\NotesSalesModel as Sales;
use App\Models\NotesSalesItemsModel as SalesItems;
use App\Models\ItemsSalesModel as Productos;
use App\Models\CustomerModel as Customer;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * obtener lista de productos user_id
     */
    public function getListProd(Request $request)
    {
        $list = Productos::where('user_id', $request['user_id'])->get();
        return response()->json(['list'=>$list]);
    }
    public function createProd(Request $request)
    {
        $insert = [
            'user_id'=>$request['user_id'], 
            'name'=>$request['name'], 
            'sku'=>$request['sku'], 
            'price'=>$request['price'], 
        ];
        $prod = Productos::create($insert);
        return response()->json(['prod'=>$prod]);
    }
    /**
     * obtener lista de notas de ventas segun user_id
     */
    public function getListSales(Request $request)
    {
        $list = Sales::where('user_id', $request['user_id'])->get();
        if(count($list)>0){
            foreach ($list as $key => $v) {
                $c = Customer::where('id', $v->customer_id)->first();
                $list[$key]->customer = (!empty($c)) ? $c->name : null;
                $list[$key]->fecha = strftime("%b %d, %Y", strtotime($v->date));
            }
        }
        return response()->json(['list'=>$list]);
    }
    public function createSales(Request $request)
    {
        $status = false;
        $insert1 = [
            'user_id'=>$request['user_id'], 
            'customer_id'=>$request['customer_id'], 
            'date'=>$request['date'], 
            'total'=>$request['total'], 
        ];
        $sales = Sales::create($insert1);
        if($sales){
            $status=true;
            $sales_id = $sales->id;
            foreach ($request['listItems'] as $item) {
                $insert2 = [
                    'user_id'=>$request['user_id'], 
                    'note_id'=>$sales_id, 
                    'item_id'=>$item['id'], 
                    'quantity'=>$item['q'], 
                    'total'=>number_format(($item['p']*$item['q']), 2, '.', ','), 
                ];
                $salesItems = SalesItems::create($insert2);
                if(!$salesItems){$status=false;}
            }
        }
        return response()->json(['status'=>$status]);
    }
    public function getSalesById(Request $request)
    {
        $r = Sales::where('id', $request['id'])->first();
        if(!empty($r)){
            $r->items = SalesItems::where('note_id', $request['id'])->get();
            if(count($r->items)){
                foreach ($r->items as $key => $value) {
                    
                    $r->items[$key]->q = $value->quantity;
                    $r->items[$key]->t = $value->total;
                    $item = Productos::where('id', $value->item_id)->first();
                    $r->items[$key]->p = (!empty($item)) ? $item->price : 0;
                }
            }
        }
        return response()->json(['r'=>$r]);
    }
    public function updateSales(Request $request)
    {
        $status = false;
        $insert1 = [
            'customer_id'=>$request['customer_id'], 
            'date'=>$request['date'], 
            'total'=>$request['total'], 
        ];
        $sales = Sales::where('id', $request['id'])->update($insert1);
        if($sales){
            $status=true;
            $delete = SalesItems::where('note_id', $request['id'])->delete();
            foreach ($request['listItems'] as $item) {
                $insert2 = [
                    'user_id'=>$request['user_id'], 
                    'note_id'=>$request['id'], 
                    'item_id'=>$item['id'], 
                    'quantity'=>$item['q'], 
                    'total'=>number_format(($item['p']*$item['q']), 2, '.', ','), 
                ];
                $salesItems = SalesItems::create($insert2);
                if(!$salesItems){$status=false;}
            }
        }
        return response()->json(['status'=>$status]);
    }
}
