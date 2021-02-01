<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Products\ProductRequest;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends BaseController
{

    protected $product = '';

    /**
     * Create a new controller instance.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->middleware('auth:api');
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $products = $this->product->latest()->with('category', 'tags')->paginate(10);

        return $this->sendResponse($products, 'Product list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request)
    {
        $product = $this->product->create([
            'name'        => $request->get('name'),
            'description' => $request->get('description'),
            'price'       => $request->get('price'),
            'category_id' => $request->get('category_id'),
        ]);

        // update pivot table
        $tag_ids = [];
        foreach ($request->get('tags') as $tag) {
            $tag_ids[] = $tag['id'];
        }
        $product->tags()->sync($tag_ids);

        return $this->sendResponse($product, 'Product Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $product = $this->product->with(['category', 'tags'])->findOrFail($id);

        return $this->sendResponse($product, 'Product Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ProductRequest $request, int $id)
    {
        $product = $this->product->findOrFail($id);

        $product->update($request->all());

        // update pivot table
        $tag_ids = [];
        foreach ($request->get('tags') as $tag) {
            $tag_ids[] = $tag['id'];
        }
        $product->tags()->sync($tag_ids);

        return $this->sendResponse($product, 'Product Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id)
    {

        $this->authorize('isAdmin');

        $product = $this->product->findOrFail($id);

        $product->delete();

        return $this->sendResponse($product, 'Product has been Deleted');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}
