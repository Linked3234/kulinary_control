<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index($type)
    {

        return view('categories.index', [
            'title' => $this->check_title($type),
            'categories' => Category::where('type', $type)->orderBy('id', 'desc')->get(),
            'type' => $type
        ]);

    }


    /**
     * добавление новой категории
     */
    public function create($type)
    {

        return view('categories.create', [
            'title' => $this->check_title($type),
            'type' => $type,
        ]);

    }


    /**
     * сохранение категории
     */
    public function store(Request $request, $type)
    {

        $this->check_title($type);

        $category = new Category;
        $category->type = $type;
        $category->name = $request->name;
        $category->save();

        return redirect(route('categories.index', ['type' => $type]));

    }


    /**
     * редактирование категории
     */
    public function edit($type, $id)
    {

        return view('categories.edit', [
            'title' => $this->check_title($type),
            'type' => $type,
            'category' => Category::find($id),
        ]);

    }


    /**
     * сохранение изменение
     */
    public function update(Request $request, $type, $id)
    {

        Category::where('id', $id)->update([
            'name' => $request->name,
        ]);

        return redirect(route('categories.index', $type));

    }



    /**
     * удаление категории
     */
    public function destroy($type, $id)
    {

        $this->check_title($type);

        Category::destroy($id);

        return redirect(route('categories.index', $type));

    }



    /**
     * определение заголовка
     */
    public function check_title($type)
    {

        // заголовок
        switch($type)
        {

            case 'good':
                $title = 'Товарные категории';
                break;

            case 'stock':
                $title = 'Складские категории';
                break;

            case 'manufacturing':
                $title = 'Производственные категории';
                break;

            default:
                return redirect('/home');

        }

        return $title;

    }




}
