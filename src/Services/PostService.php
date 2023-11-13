<?php

namespace IBoot\CMS\Services;

use IBoot\CMS\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class PostService
{
    /**
     * @return Collection|array
     */
    public function getLists(): Collection|array
    {
        return Post::query()
            ->orderBy('sequence')
            ->with(['category', 'medias'])
            ->get();
    }
    /**
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    public function getById(int $id): Model|Collection|Builder|array|null
    {
        return $this->findById($id)->load(['category', 'medias']);
    }

    /**
     * @param $id
     * @param array $inputs
     * @return Model|Builder
     */
    public function createOrUpdateWithPolymorphic($id, array $inputs = array()): Model|Builder
    {
        $mediaIds = Arr::get($inputs, 'media_id', []);
        $sequence = 0;
        $posts = Post::query()->get();

        if ($posts->isNotEmpty()) {
            $sequence = $posts->max('sequence');
        }

        if (!empty($id)) {
            $inputs['updated_by'] = userIdLogin();
        } else {
            $inputs['created_by'] = userIdLogin();
            $inputs['sequence'] = !empty($inputs['sequence']) ? $inputs['sequence'] : $sequence + 1;
        }
        unset($inputs['id'], $inputs['media_id']);

        $post =  Post::query()->updateOrCreate(
            ['id' => $id],
            $inputs
        );

        // Xóa các media cũ không nằm trong danh sách mới
        if (empty($inputs['sequence'])) {
            $post->medias()->detach();
        }

        if (!empty($mediaIds)) {
            // Thêm mới các media được chọn
            $post->medias()->attach($mediaIds);
        }

        return $post;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id): mixed
    {
        return Post::query()->where('id', $id)->delete();
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function deleteAllById($ids): mixed
    {
        return Post::deleteByIds($ids);
    }

    private function findById($id): Model|Collection|Builder|array|null
    {
        return Post::query()->findOrFail($id);
    }
}
