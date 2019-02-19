<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->type == 'cashier')
        {

            return redirect(route('goods.list', ['id' => 'all']));

        } elseif(Auth::user()->type == 'administrator') {

            return redirect(route('goods.index'));

        } elseif(!Auth::check()) {

            return redirect(route('login'));

        }
    }
}
