<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Category;
use App\Models\Good;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodController extends Controller
{

    public function index(Request $request)
    {

        if(!isset($request->search))
        {

            $goods = Good::orderBy('name', 'asc')->get();

            return view('goods.index', [
                'goods' => $goods,
            ]);

        } else {

            $goods = Good::where('name', 'like', '%'.$request->name.'%')
                ->orderBy('name', 'asc')
                ->get();

            return view('goods.search', [
                'goods' => $goods,
            ]);

        }



    }


    /**
     * добавление товаров
     */
    public function create()
    {

        return view('goods.create', [
            'categories_good' => Category::where('type', 'good')->orderBy('name', 'asc')->get(),
            'categories_stock' => Category::where('type', 'stock')->orderBy('name', 'asc')->get(),
            'categories_manufacturing' => Category::where('type', 'manufacturing')->orderBy('name', 'asc')->get(),
        ]);

    }
    
    
    /**
     * сохранение товара
     */
    public function store(Request $request)
    {

        $good = new Good;
        $good->category_good = $request->category_good;
        $good->category_stock = $request->category_stock;
        $good->category_manufacturing = $request->category_manufacturing;
        $good->name = $request->name;
        $good->measure= $request->measure;
        $good->save();

        return redirect(route('goods.index'));

    }


    /**
     * редактирование товара
     */
    public function edit($id)
    {

        return view('goods.edit', [
            'categories_good' => Category::where('type', 'good')->orderBy('name', 'asc')->get(),
            'categories_stock' => Category::where('type', 'stock')->orderBy('name', 'asc')->get(),
            'categories_manufacturing' => Category::where('type', 'manufacturing')->orderBy('name', 'asc')->get(),
            'good' => Good::Find($id),
        ]);

    }


    /**
     * обновление информации по товару
     */
    public function update(Request $request, $id)
    {

        Good::where('id', $id)->update([
            'category_good' => $request->category_good,
            'category_stock' => $request->category_stock,
            'category_manufacturing' => $request->category_manufacturing,
            'name' => $request->name,
            'measure' => $request->measure,
            'hidden' => (boolean) $request->hidden,
        ]);

        return redirect(route('goods.index'));

    }



    /**
     * удаление товара
     */
    public function destroy($id)
    {

        Good::destroy($id);

        return redirect(route('goods.index'));

    }


    /**
     * список товаров (для оформления заказа)
     */
    public function goods_list(Request $request, $category_id = 0)
    {

        if(!empty($request->category_id))
        {
            $category_id = (int) $request->category_id;
        }

        if(isset($category_id) && $category_id !== 0)
        {

            $goods = Good::where('category_good', $category_id)
                ->orderBy('name', 'asc')
                ->where('hidden', '0')
                ->get();
            $category = Category::find($category_id);
            $title = $category->name;

        } else {

            $goods = Good::orderBy('name', 'asc')
            ->where('hidden', 0)
            ->get();
            $title = 'Все товары';

        }


        return view('goods.list', [
            'goods' => $goods,
            'categories' => Category::where('type', 'good')->orderBy('name', 'asc')->get(),
            'title' => $title,
            'category_id' => $category_id,
            'basket_list' => $this->basket_list(),
        ]);

    }


    /**
     * добавление товара в корзину
     */
    public function basket_create(Request $request):void
    {

        /**
         * проверяем, добавлял ли пользователю уже этот товар в корзину.
         * Если да - увеличиваем количество, если нет - создаём запись
         */
        $basket_good = Basket::where('user_id', Auth::id())
            ->where('good_id', $request->good_id)
            ->first();

        if(empty($basket_good)) {

            $basket = new Basket;
            $basket->user_id = Auth::id();
            $basket->category_id = $request->category_id;
            $basket->category_manufacturing = $request->category_manufacturing;
            $basket->category_stock = $request->category_stock;
            $basket->good_id = $request->good_id;
            $basket->count = $request->count;
            $basket->save();

        } else {

            $count = $basket_good->count + $request->count;

            Basket::where('id', $basket_good->id)->update([
                'count' => $count,
            ]);

        }

    }


    /**
     * вещи в корзине (по категориям: good)
     */
    public function basket_list()
    {

//        $goods = '<table border="1" class="table-goods-order"><thead><tr><th>Товар</th><th>Категория</th><th>Количество</th></tr></thead><tbody>';
        $goods = '<table border="0" style="width: 100%;" class="table-goods-order" style="width: 100%;"><tbody>';

        $categories = Category::where('type', 'good')
            ->orderBy('name', 'asc')
            ->get();


        foreach($categories as $category_item)
        {

            $basket = Basket::where('category_id', $category_item->id)->get();

            if(!empty($basket) && $basket->count() > 0)
            {

                $goods .= '<tr><th colspan="3" class="header-good-order">'.$category_item->name.'</th></tr>';
                foreach($basket as $basket_items)
                {

                    $good = Good::find($basket_items->good_id);

                    $goods .= '<tr><td style="width: 80%;">'.$good->name.'</td><td style="width: 20%"><input type="hidden" name="basket_id" value="'.$basket_items->id.'"><input type="number" name="count_items_in_basket" class="form-control" value="'.$basket_items->count.'"></td></tr>';

                }

            }

        }

        $goods .= '</tbody></table>';

        return $goods;

    }


    /**
     * вещи в корзине (по категориям: manufacturing)
     */
    public function basket_list_manufacturing()
    {

//        $goods = '<table border="1" class="table-goods-order"><thead><tr><th>Товар</th><th>Категория</th><th>Количество</th></tr></thead><tbody>';
        $goods = '<table border="1" style="width: 100%;" class="table-goods-order"><tbody>';
        $categories = Category::where('type', 'manufacturing')
            ->orderBy('name', 'asc')
            ->get();


        foreach($categories as $category_item)
        {

            $basket = Basket::where('category_manufacturing', $category_item->id)->get();

            if(!empty($basket) && $basket->count() > 0)
            {

                $goods .= '<tr><th colspan="3" class="header-good-order">'.$category_item->name.'</th></tr>';
                foreach($basket as $basket_items)
                {

                    $good = Good::find($basket_items->good_id);

                    $goods .= '<tr><td style="width: 90%;">'.$good->name.'</td><td style="width: 10%; text-align: center;">'.$basket_items->count.'</td></tr>';

                }


            }

        }

        $goods .= '</tbody></table>';

        return $goods;

    }


    /**
     * вещи в корзине (по категориям: stock)
     */
    public function basket_list_stock()
    {

//        $goods = '<table border="1" class="table-goods-order"><thead><tr><th>Товар</th><th>Категория</th><th>Количество</th></tr></thead><tbody>';
        $goods = '<table border="1" style="width: 100%;" class="table-goods-order"><tbody>';

        $categories = Category::where('type', 'stock')
            ->orderBy('name', 'asc')
            ->get();


        foreach($categories as $category_item)
        {

            $basket = Basket::where('category_stock', $category_item->id)->get();

            if(!empty($basket) && $basket->count() > 0)
            {

                $goods .= '<tr><th colspan="3" class="header-good-order">'.$category_item->name.'</th></tr>';
                foreach($basket as $basket_items)
                {

                    $good = Good::find($basket_items->good_id);

                    $goods .= '<tr><td style="width: 90%;">'.$good->name.'</td><td style="width: 10%; text-align: center;">'.$basket_items->count.'</td></tr>';

                }

            }

        }

        $goods .= '</tbody></table>';

        return $goods;

    }

}
