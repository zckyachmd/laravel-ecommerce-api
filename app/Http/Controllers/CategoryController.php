<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Category $category): JsonResponse
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
            $limit = $request->limit ?? 10; // Default limit 10
            $page = $request->page ?? 1;    // Default page 1

            // Create query builder
            $categories = $category->newQuery();

            // Check if has query sort
            if ($request->has('sort')) {
                // Validate query sort and order
                $request->validate([
                    'sort'  => 'in:name,description',
                    'order' => 'in:asc,desc'
                ]);

                // Order by query sort
                $categories = $category->orderBy($request->sort, $request->order ?? 'asc');
            }

            // Check if has query search
            if ($request->has('search')) {
                // Validate query search
                $request->validate($category->rules(false));

                // Search by name and description
                $categories = $categories->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            }

            // Paginate query builder
            $categories = $categories->paginate($limit, ['*'], 'page', $page);

            // Check if data is empty
            if ($categories->isEmpty()) {
                return response()->json([
                    'error' => 'Categories not found'
                ], 404);
            }

            // Return data if success
            return response()->json($categories, 200);
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        try {
            // Validate request
            $request->validate($category->rules());

            // Create new category
            $createCategory = $category->create($request->all());

            // Return response created not success
            if (!$createCategory) {
                throw new \Exception('Category not created');
            }

            // Return response created if success
            return response()->json([
                'message' => 'Category created',
                'data'    => $createCategory
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
     * @param  \App\Models\Category  $category
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, $id)
    {
        try {
            // Convert id to integer
            $id = (int) $id ?? 0;

            // Find category by id
            $getCategory = $category->find($id);

            // Check if category is empty
            if (empty($getCategory)) {
                return response()->json([
                    'error' => 'Category not found'
                ], 404);
            }

            // Return data if success
            return response()->json([
                'message'   => 'Category found',
                'data'      => $getCategory
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
     * @param  \App\Models\Category  $category
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category, $id): JsonResponse
    {
        try {
            // Convert id to integer
            $id = (int) $id ?? 0;

            // Validate request
            $request->validate($category->rules(false, $id));

            // Find category by id
            $getCategory = $category->find($id);

            // Check if category is empty
            if (empty($getCategory)) {
                return response()->json([
                    'error' => 'Category not found'
                ], 404);
            }

            // Update category by id
            $updateCategory = $getCategory->update($request->all());

            // Return response created not success
            if (!$updateCategory) {
                throw new \Exception('Category not updated');
            }

            // Return response created if success
            return response()->json([
                'message'   => 'Category updated',
                'data'      => $getCategory
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
     * @param  \App\Models\Category  $category
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, $id)
    {
        try {
            // Convert id to integer
            $id = (int) $id ?? 0;


            // Find category by id
            $getCategory = $category->find($id);

            // Check if category is empty
            if (empty($getCategory)) {
                return response()->json([
                    'error' => 'Category not found'
                ], 404);
            }

            // Delete category by id
            $updateCategory = $getCategory->delete();

            // Return response created not success
            if (!$updateCategory) {
                throw new \Exception('Category not deleted');
            }

            // Return response created if success
            return response()->json([
                'message'   => 'Category deleted',
                'data'      => $getCategory
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
