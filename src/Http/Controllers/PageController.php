<?php

namespace IBoot\CMS\Http\Controllers;

use App\Http\Controllers\Controller;
use IBoot\CMS\Http\Requests\FormPageRequest;
use IBoot\CMS\Services\PageService;
use IBoot\Core\App\Exceptions\ServerErrorException;
use IBoot\Core\App\Http\Middleware\CheckPermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PageController extends Controller
{
    private PageService $page;

    /**
     * @param PageService $page
     */
    public function __construct(PageService $page) {
        $this->page = $page;
        $this->middleware(CheckPermission::using('view pages'))->only('index');
        $this->middleware(CheckPermission::using('create pages'))->only('create');
        $this->middleware(CheckPermission::using('edit pages'))->only('edit');
        $this->middleware(CheckPermission::using('delete pages'))->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = $this->page->getLists();

        return view('plugin/cms::pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('plugin/cms::pages.form');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $page = $this->page->getById($id);

        return view('plugin/cms::pages.form', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormPageRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->page->createOrUpdateWithPolymorphic($id, $request->all());
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
            $this->page->deleteById($id);
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
            $this->page->createOrUpdateWithPolymorphic($id, $request->all());
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
            $this->page->deleteAllById($ids);
            DB::commit();

            return responseSuccess(null, trans('plugin/cms::messages.delete_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('plugin/cms::messages.action_error'));
        }
    }
}
