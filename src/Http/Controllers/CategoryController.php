<?php

namespace IBoot\CMS\Http\Controllers;

use App\Http\Controllers\Controller;
use IBoot\CMS\Http\Requests\FormCategoryRequest;
use IBoot\CMS\Models\Category;
use IBoot\CMS\Services\CategoryService;
use IBoot\Core\App\Exceptions\ServerErrorException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class CategoryController extends Controller
{
    private CategoryService $category;

    /**
     * @param CategoryService $category
     */
    public function __construct(CategoryService $category) {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = listCategories();

        return view('plugin/cms::categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = getCategories(listCategories());

        return view('plugin/cms::categories.form', compact('categories'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = getCategories(listCategories());
        $category = $this->category->getById($id);

        return view('plugin/cms::categories.form', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormCategoryRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->category->createOrUpdateCategories($id, $request->all());
            DB::commit();

            return responseSuccess(null, trans('plugin/cms::messages.save_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('plugin/cms::messages.action_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $post)
    {
        //
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function editable(Request $request, $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->category->createOrUpdateCategories($id, $request->all());
            DB::commit();

            return responseSuccess(null, trans('plugin/cms::messages.save_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('plugin/cms::messages.action_error'));
        }
    }
}
