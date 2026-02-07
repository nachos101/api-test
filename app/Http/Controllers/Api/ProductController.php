<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // obtener todos los productos
    public function index(Request $request){
        $query = Product::query();

        // busqueda por nombre
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // filtro por categoría
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // filtro por marca
        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }

        // filtro por rango de precio
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // ordenamiento
        $sortBy = $request->get('sort_by', 'id'); 
        $sortOrder = $request->get('sort_order', 'asc');
        
        $query->orderBy($sortBy, $sortOrder);

        // paginación 
        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage);

        return response()->json($products, 200);
    }


    // cargar un nuevo producto
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);
        $product = Product::create($validate);
        return response()->json($product,201);
    }

    // mostrar un solo producto
    public function show(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json("No se encontro el producto",404);
        }
        else return response()->json($product,201);
    }

    // actualizar un producto
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);
        $product = Product::find($id);
        if (!$product) {
            return response()->json("No se encontro el producto",404);
        }
        $product->update($validate);
        return response()->json($product,201);    
    }

    // eliminar un producto
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (!empty($product)){
            Product::destroy($id);
            return response()->json("Producto eliminado",200);
        } else {
            return response()->json("No se encontro el producto",404);
        }

    }
}
