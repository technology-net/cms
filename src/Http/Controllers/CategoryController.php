<?php

namespace IBoot\CMS\Http\Controllers;

use App\Http\Controllers\Controller;
use IBoot\CMS\Http\Requests\FormCategoryRequest;
use IBoot\CMS\Services\CategoryService;
use IBoot\Core\App\Exceptions\ServerErrorException;
use IBoot\Core\App\Http\Middleware\CheckPermission;
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
        $this->middleware(CheckPermission::using('view categories'))->only('index');
        $this->middleware(CheckPermission::using('create categories'))->only('create');
        $this->middleware(CheckPermission::using('edit categories'))->only('edit');
        $this->middleware(CheckPermission::using('delete categories'))->only('destroy');
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
     * @param string $id
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function destroy(string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->category->deleteById($id);
            DB::commit();

            return responseSuccess(null, trans('plugin/cms::messages.delete_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('plugin/cms::messages.action_error'));
        }
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

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function deleteAll(Request $request): JsonResponse
    {
        $ids = $request->ids;
        DB::beginTransaction();
        try {
            $this->category->deleteAllById($ids);
            DB::commit();

            return responseSuccess(null, trans('plugin/cms::messages.delete_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('plugin/cms::messages.action_error'));
        }
    }
}
