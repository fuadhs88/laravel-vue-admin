<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends BaseController
{
    protected $tag = '';

    /**
     * Create a new controller instance.
     *
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->middleware('auth:api');
        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $tags = $this->tag->latest()->paginate(10);

        return $this->sendResponse($tags, 'Tags list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function list()
    {
        $tags = $this->tag->get(['name', 'id']);

        return $this->sendResponse($tags, 'Tags list');
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
        $tag = $this->tag->create([
            'name' => $request->get('name')
        ]);

        return $this->sendResponse($tag, 'Tag Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $tag = $this->tag->findOrFail($id);

        $tag->update($request->all());

        return $this->sendResponse($tag, 'Tag Information has been updated');
    }
}
