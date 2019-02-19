<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{

    public function clear():void
    {

        Basket::where('user_id', Auth::id())->delete();

    }


    /**
     * изменение кол-ва товаров в корзине
     */
    public function change_count_items(Request $request):void
    {

        Basket::where('id', $request->basket_id)->update([
            'count' => $request->count,
        ]);

    }

}
