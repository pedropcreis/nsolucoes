<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index() {
        $search = request('search');
        $categories = Category::all();
        $selected_category = request('selected_category') ? request('selected_category') : $categories[0]->id;

        if($search) {
            $products = Product::where('name', 'like', '%' . $search . '%')->get();
        } else {
            $products = Product::where('category_id', $selected_category)->get();
        }
        return view('home.index', ['products' => $products, 'categories' => $categories, 'selected_category'=> $selected_category]);
    }
}
