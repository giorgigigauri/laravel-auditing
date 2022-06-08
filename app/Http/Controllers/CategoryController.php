<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Event;
use OwenIt\Auditing\Events\AuditCustom;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        return $category->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $audit = $category->audits()->latest()->first();
        return [
            'audit' => [
                'latestModified' => $audit->getModified(),
                'metadata' => $audit->getMetadata(),
                'data' => $category->audits,
            ],
            'data' => $category,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        // service call
        $serviceParams = ['cat' => $request->name];

        $serviceResponseStatus = ['status' => 1];

        // custom service call logger [START]
        $category->auditEvent = 'ServiceResponse';
        $category->isCustomEvent = true;
        $category->auditCustomOld = [
            'customExample' => $serviceParams
        ];
        $category->auditCustomNew = [
            'customExample' => $serviceResponseStatus
        ];
        Event::dispatch(AuditCustom::class, [$category]);
        // custom service call logger [END]

        return response('success', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
