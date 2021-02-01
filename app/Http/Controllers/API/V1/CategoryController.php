<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends BaseController
{
    protected $category = '';

    /**
     * Create a new controller instance.
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->middleware('auth:api');
        $this->category = $category;
    }


    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $categories = $this->category->latest()->paginate(10);

        return $this->sendResponse($categories, 'Category list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function list()
    {
        $categories = $this->category->get(['name', 'id']);

        return $this->sendResponse($categories, 'Category list');
    }


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $tag = $this->category->create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        return $this->sendResponse($tag, 'Category Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param Request $request
     * @param $id
     *
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $tag = $this->category->findOrFail($id);

        $tag->update($request->all());

        return $this->sendResponse($tag, 'Category Information has been updated');
    }
}
