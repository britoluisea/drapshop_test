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
use App\Http\Controllers\SalesController;

class ApiController extends Controller
{
    public function getAllSales(Request $request)
    {
        $cSales= new SalesController();
        $toEur =$cSales->precioMoneda('EUR', 'COP', 1);
        $toUsd =$cSales->precioMoneda('USD', 'COP', 1);
        $list = Sales::all();
        if(count($list)>0){
            foreach ($list as $key => $v) {
                $c = Customer::where('id', $v->customer_id)->first();
                $list[$key]->customer = (!empty($c)) ? $c->name : null;
                $list[$key]->fecha = strftime("%b %d, %Y", strtotime($v->date));
                $list[$key]->totalUSD = number_format(($list[$key]->total*$toUsd), 2, '.', ',');
                $list[$key]->totalEUR = number_format(($list[$key]->total*$toEur), 2, '.', ',');
            }
        }
        return response()->json([
            'list'=>$list,
            'toEur'=>$toEur,
            'toUsd'=>$toUsd,
        ]);
    }
}
