<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Products\ProductRequest;
use App\Http\Services\TagService;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends BaseController
{

    protected $product = '';

    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param Product $product
     * @param ProductRepository $repository
     */
    public function __construct(Product $product, ProductRepository $repository)
    {
        $this->middleware('auth:api');
        $this->product    = $product;
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $products = $this->repository->latest()->with('category', 'tags')->paginate();
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
        $product = $this->repository->create($request->only(['name', 'description', 'price', 'category_id']));
        $this->repository->addTags($product, TagService::getIds($request->get("tags")));
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
        $product = $this->repository->update($id, $request->only(['name', 'description', 'price', 'category_id']));
        $this->repository->addTags($product, TagService::getIds($request->get("tags")));
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
        $this->repository->delete($id);
        return $this->sendResponse([], 'Product has been Deleted');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @author Admin <admin@gmail.com>
     */
    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}
