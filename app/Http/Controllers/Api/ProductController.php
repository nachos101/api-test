<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    // obtener todos los productos
    public function index(IndexProductRequest $request)
    {
        $validated = $request->validated();
        $query = Product::query();

        // busqueda por nombre
        if (isset($validated['search'])) {
            $query->where('name', 'like', '%'.$validated['search'].'%');
        }

        // filtro por categoría
        if (isset($validated['category'])) {
            $query->where('category', $validated['category']);
        }

        // filtro por rango de precio
        if (isset($validated['min_price'])) {
            $query->where('price', '>=', $validated['min_price']);
        }

        if (isset($validated['max_price'])) {
            $query->where('price', '<=', $validated['max_price']);
        }

        // ordenamiento
        $sortBy = $validated['sort_by'] ?? 'id';
        $sortOrder = $validated['sort_order'] ?? 'asc';

        $query->orderBy($sortBy, $sortOrder);

        // paginación
        $perPage = $validated['per_page'] ?? 15;
        $products = $query->paginate($perPage);

        return response()->json($products, 200);
    }

    // cargar un nuevo producto
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        return response()->json($product, 201);
    }

    // mostrar un solo producto
    public function show(Product $product)
    {
        return response()->json($product, 200);
    }

    // actualizar un producto
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return response()->json($product, 200);
    }

    // eliminar un producto
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json('Producto eliminado', 200);
    }
}
