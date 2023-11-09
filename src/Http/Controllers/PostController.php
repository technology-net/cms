<?php

namespace IBoot\CMS\Http\Controllers;

use App\Http\Controllers\Controller;
use IBoot\CMS\Http\Requests\FormPostRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use IBoot\CMS\Models\Post;
use IBoot\CMS\Services\PostService;
use IBoot\Core\App\Exceptions\ServerErrorException;
use Exception;

class PostController extends Controller
{
    private PostService $post;

    public function __construct(PostService $post) {
        $this->post = $post;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->post->getLists();

        return view('plugin/cms::posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = getCategories(listCategories());

        return view('plugin/cms::posts.form', compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = getCategories(listCategories());
        $post = $this->post->getById($id);

        return view('plugin/cms::posts.form', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormPostRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->post->createOrUpdateWithPolymorphic($id, $request->all());
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
     * @param string $id
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function destroy($id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->post->deleteById($id);
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
            $this->post->createOrUpdateWithPolymorphic($id, $request->all());
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
            $this->post->deleteAllById($ids);
            DB::commit();

            return responseSuccess(null, trans('plugin/cms::messages.delete_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('plugin/cms::messages.action_error'));
        }
    }
}
