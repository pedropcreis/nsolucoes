<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class ProductController extends Controller
{
    public function index() {
        return view('products.index');
    }

    public function list() {

        $products = DB::table('products')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.*', 'categories.name AS category')->orderBy('name', 'ASC');
        return DataTables::of($products)->make(true);
    }

    public function create() {
        $categories = Category::all();
        return view('products.create', ['categories' => $categories]);
    }

    public function store(Request $request) {
        try {

            DB::beginTransaction();

            $product = new Product();

            $product->name = request('name');
            $product->category_id = request('category_id');
            $product->price = (float) request('price');
            $product->length = (float) request('length');
            $product->width = (float) request('width');
            $product->height = (float) request('height');
            $product->weight = (float) request('weight');

            if($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->image; // pega a imagem
                $extension = $image->extension(); // pega a extensão da imagem
                $image_name = md5($image->getClientOriginalName() . strtotime('now')) . '.' . $extension; // gera um nome único em MD5 utilizando a data/hora de agora
                $image->move(public_path('img/uploads'), $image_name); // salva a imagem na pasta public/img/uploads

                $product->image = $image_name; // salva o nome da imagem na coluna imagem da tabela products
            }

            $product->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Produto cadastrado.'
            ]);

        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Houve um erro inesperado. Tente novamente.',
                'verbose' => $e,
            ]);
        }
    }

    public function detail($id) {
        if($id) {
            $product = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')->where('products.id', $id)
            ->select('products.*', 'categories.name AS category')->first();
            return view('detail.index', ['product' => $product]);
        } else {
            return redirect('/');
        }
        return view('detail.index');
    }
}
