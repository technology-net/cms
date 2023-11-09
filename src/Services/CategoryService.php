<?php

namespace IBoot\CMS\Services;

use IBoot\CMS\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class CategoryService
{
    /**
     * @return Collection|array
     */
    public function getLists(): Collection|array
    {
        return Category::query()
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
    public function createOrUpdateCategories($id, array $inputs = array()): Model|Builder
    {
        $parent = Arr::get($inputs, 'parent_id', null);
        $sequence = 0;
        $categories = Category::query()->get();

        if ($categories->isNotEmpty()) {
            $sequence = $categories->max('sequence');
        }

        if (empty($inputs['sequence'])) {
            $inputs['parent_id'] = $parent;
        }

        if (!empty($id)) {
            $inputs['updated_by'] = userIdLogin();
        } else {
            $inputs['created_by'] = userIdLogin();
            $inputs['sequence'] = !empty($inputs['sequence']) ? $inputs['sequence'] : $sequence + 1;
        }
        unset($inputs['id']);

        return Category::query()->updateOrCreate(
            ['id' => $id],
            $inputs
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteById($id): mixed
    {
        return Category::query()->where('id', $id)->delete();
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function deleteAllById($ids): mixed
    {
        return Category::deleteByIds($ids);
    }

    private function findById($id): Model|Collection|Builder|array|null
    {
        return Category::query()->findOrFail($id);
    }
}
