<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Product $product): JsonResponse
    {
        try {
            // Check if has query limit and page
            if ($request->has('limit') || $request->has('page')) {
                // Validate query limit and page
                $request->validate([
                    'limit' => 'integer|min:1',
                    'page'  => 'integer|min:1'
                ]);
            }

            // Get query limit and page
            $limit  = $request->limit ?? 10;    // Default limit 10
            $page   = $request->page ?? 1;      // Default page 1

            // Create query builder
            $products = $product->select('products.*', 'categories.name as category_name')
                ->join('categories', 'categories.id', '=', 'products.category_id');

            // Check if has query sort
            if ($request->has('sort')) {
                // Validate query sort and order
                $request->validate([
                    'sort'  => 'in:name,description',
                    'order' => 'in:asc,desc'
                ]);

                // Order by query sort
                $products = $product->orderBy($request->sort, $request->order ?? 'asc');
            }

            // Check if has query search
            if ($request->has('search')) {
                // Search by name and description
                $products = $products->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('price', 'like', '%' . $request->search . '%')
                    ->orWhere('quality', 'like', '%' . $request->search . '%');
            }

            // Paginate query builder
            $products = $products->paginate($limit, ['*'], 'page', $page);

            // Check if data is empty
            if ($products->isEmpty()) {
                return response()->json([
                    'error' => 'Categories not found'
                ], 404);
            }

            // Return data if success
            return response()->json($products, 200);
        } catch (\Exception $e) {
            // If debug is disabled, only return the error message and code
            $error = [
                'error' => $e->getMessage()
            ];

            // If debug is enabled, add more information to the error
            if (env('APP_DEBUG') == ('true' || true)) {
                $error['file'] = $e->getFile();
                $error['line'] = $e->getLine();
            }

            // Return the error
            return response()->json($error, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Product $product): JsonResponse
    {
        try {
            // Validate request
            $request->validate($product->rules());

            // Create new product
            $createProduct = $product->create($request->all());

            // Return response created not success
            if (!$createProduct) {
                throw new \Exception('Product not created');
            }

            // Return response created if success
            return response()->json([
                'message' => 'Product created',
                'data'    => $createProduct
            ], 201);
        } catch (\Exception $e) {
            // If debug is disabled, only return the error message and code
            $error = [
                'error' => $e->getMessage()
            ];

            // If debug is enabled, add more information to the error
            if (env('APP_DEBUG') == ('true' || true)) {
                $error['file'] = $e->getFile();
                $error['line'] = $e->getLine();
            }

            // Return the error
            return response()->json($error, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product, $id): JsonResponse
    {
        try {
            // Convert id to integer
            $id = (int) $id ?? 0;

            // Find product by id
            $getProduct = $product->find($id);

            // Check if product is empty
            if (empty($getProduct)) {
                return response()->json([
                    'error' => 'Product not found'
                ], 404);
            }

            // Return data if success
            return response()->json([
                'message'   => 'Product found',
                'data'      => $getProduct
            ], 200);
        } catch (\Exception $e) {
            // If debug is disabled, only return the error message and code
            $error = [
                'error' => $e->getMessage()
            ];

            // If debug is enabled, add more information to the error
            if (env('APP_DEBUG') == ('true' || true)) {
                $error['file'] = $e->getFile();
                $error['line'] = $e->getLine();
            }

            // Return the error
            return response()->json($error, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product, $id): JsonResponse
    {
        try {
            // Convert id to integer
            $id = (int) $id ?? 0;

            // Validate request
            $request->validate($product->rules(false, $id));

            // Find product by id
            $getProduct = $product->find($id);

            // Check if product is empty
            if (empty($getProduct)) {
                return response()->json([
                    'error' => 'Product not found'
                ], 404);
            }

            // Update product by id
            $updateProduct = $getProduct->update($request->all());

            // Return response created not success
            if (!$updateProduct) {
                throw new \Exception('Product not updated');
            }

            // Return response created if success
            return response()->json([
                'message'   => 'Product updated',
                'data'      => $getProduct
            ], 201);
        } catch (\Exception $e) {
            // If debug is disabled, only return the error message and code
            $error = [
                'error' => $e->getMessage()
            ];

            // If debug is enabled, add more information to the error
            if (env('APP_DEBUG') == ('true' || true)) {
                $error['file'] = $e->getFile();
                $error['line'] = $e->getLine();
            }

            // Return the error
            return response()->json($error, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product, $id): JsonResponse
    {
        try {
            // Convert id to integer
            $id = (int) $id ?? 0;

            // Find product by id
            $getProduct = $product->find($id);

            // Check if product is empty
            if (empty($getProduct)) {
                return response()->json([
                    'error' => 'Product not found'
                ], 404);
            }

            // Delete product by id
            $updateProduct = $getProduct->delete();

            // Return response created not success
            if (!$updateProduct) {
                throw new \Exception('Product not deleted');
            }

            // Return response created if success
            return response()->json([
                'message'   => 'Product deleted',
                'data'      => $getProduct
            ], 201);
        } catch (\Exception $e) {
            // If debug is disabled, only return the error message and code
            $error = [
                'error' => $e->getMessage()
            ];

            // If debug is enabled, add more information to the error
            if (env('APP_DEBUG') == ('true' || true)) {
                $error['file'] = $e->getFile();
                $error['line'] = $e->getLine();
            }

            // Return the error
            return response()->json($error, 500);
        }
    }
}
