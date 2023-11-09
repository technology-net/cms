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
            ->with('parent')
            ->get();
    }
    /**
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    public function getById(int $id): Model|Collection|Builder|array|null
    {
        return $this->findById($id);
    }

    /**
     * @param $id
     * @param array $inputs
     * @return Model|Builder
     */
    public function createOrUpdateWithPolymorphic($id, array $inputs = array()): Model|Builder
    {
        $mediaIds = Arr::get($inputs, 'media_id', []);
        unset($inputs['id'], $inputs['media_id']);
        $post =  Post::query()->updateOrCreate(
            ['id' => $id],
            $inputs
        );

        $post->medias()->attach($mediaIds);

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
