<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Good;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function store(Request $request)
    {

        $goods = new GoodController();
        $basket_items = $goods->basket_list();
//        $basket_items .= '<h3>Складские категории</h3>'.$goods->basket_list_stock();
//        $basket_items .= '<h3>Категории производителя</h3>'.$goods->basket_list_manufacturing();


        // формируем идентификатор заказа
        $last_order = Order::orderBy('order_id', 'desc')->limit(1)->first();
        if(!empty($last_order))
        {

            $order_id = $last_order->order_id + 1;

        } else {

            $order_id = 100000;

        }

        // список товаров для отправки по email
        $basket_items_mail = '<h4>Заказ №'.$order_id.'<br>'.Auth::user()->name.'</h4><p>'.date('d.m.Y H:i').'</p>';
        $basket_items_mail .= '<h4></h4>'.$goods->basket_list_manufacturing();
        $basket_items_mail .= '<br><hr><h4>Наряд-заказ №'.$order_id.'<br>'.Auth::user()->name.'</h4><p>'.date('d.m.Y H:i').'</p>';
        $basket_items_mail .= '<h4></h4>'.$goods->basket_list_stock();


        $order = new Order;
        $order->user_id = Auth::id();
        $order->order_id = $order_id;
        $order->goods = $basket_items;
        $order->goods_mail = $basket_items_mail;
        $order->comment = $request->comment;
        $order->date = time();
        $order->save();

        // очищаем корзину пользователя
        Basket::where('user_id', Auth::id())->delete();




        // отправляем письмо
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Дополнительные заголовки
//        $headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
//        $headers .= 'From: Birthday Reminder <birthday@example.com>';
//        $headers .= 'Cc: birthdayarchive@example.com';
//        $headers .= 'Bcc: birthdaycheck@example.com';

        // данные письма

        $subject = 'Заказ № '.$order_id;
        $to = '';
        $message = $basket_items_mail;

        // Отправляем
//        mail($to, $subject, $message, $headers);


        return redirect(route('order.all'));

    }


    /**
     * возвращает список всех совершённых заказов
     */
    public function order_all()
    {

        $orders = Order::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->get();

        return view('orders.index', [
            'orders' => $orders,
        ]);

    }


    /**
     * просмотр товаров в заказе
     */
    public function watch($id)
    {

        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        return view('orders.watch', [
            'order' => $order,
        ]);

    }


    /**
     * возвращает заказы всех пользователей
     */
    public function order_users_all()
    {

        $orders = Order::orderBy('date', 'desc')
            ->limit(100)
            ->get();

        return view('orders.users_orders', [
            'orders' => $orders,
        ]);

    }

}
