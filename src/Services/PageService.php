<?php

namespace IBoot\CMS\Services;

use IBoot\CMS\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class PageService
{
    /**
     * @return Collection|array
     */
    public function getLists(): Collection|array
    {
        return Page::query()
            ->orderBy('sequence')
            ->with(['medias'])
            ->get();
    }
    /**
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    public function getById(int $id): Model|Collection|Builder|array|null
    {
        return $this->findById($id)->load(['medias']);
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
        $pages = Page::query()->get();

        if ($pages->isNotEmpty()) {
            $sequence = $pages->max('sequence');
        }

        if (!empty($id)) {
            $inputs['updated_by'] = userIdLogin();
        } else {
            $inputs['created_by'] = userIdLogin();
            $inputs['sequence'] = !empty($inputs['sequence']) ? $inputs['sequence'] : $sequence + 1;
        }
        unset($inputs['id'], $inputs['media_id']);

        $page =  Page::query()->updateOrCreate(
            ['id' => $id],
            $inputs
        );

        // Xóa các media cũ không nằm trong danh sách mới
        if (empty($inputs['sequence'])) {
            $page->medias()->detach();
        }

        if (!empty($mediaIds)) {
            // Thêm mới các media được chọn
            $page->medias()->attach($mediaIds);
        }

        return $page;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id): mixed
    {
        return Page::query()->where('id', $id)->delete();
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function deleteAllById($ids): mixed
    {
        return Page::deleteByIds($ids);
    }

    private function findById($id): Model|Collection|Builder|array|null
    {
        return Page::query()->findOrFail($id);
    }
}
