<?php

namespace IBoot\CMS\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * @param array $ids
     * @return mixed
     */
    public static function deleteByIds(array $ids): mixed
    {
        return static::query()->whereIn('id', $ids)->delete();
    }
}
