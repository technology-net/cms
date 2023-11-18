<?php

namespace IBoot\CMS\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    const PENDING = 1;
    const PUBLISHED = 2;

    /**
     * @param array $ids
     * @return mixed
     */
    public static function deleteByIds(array $ids): mixed
    {
        return static::query()->whereIn('id', $ids)->delete();
    }

    /**
     * @param $statusId
     * @return string
     */
    public static function postStatusText($statusId): string
    {
        switch ($statusId) {
            case self::PENDING:
                return '<span class="bg-warning btn-sm text-white">'.trans('plugin/cms::common.pending').'</span>';
                break;

            case self::PUBLISHED:
                return '<span class="bg-success btn-sm text-white">'.trans('plugin/cms::common.published').'</span>';
                break;

            default:
                return '<span class="bg-info btn-sm text-white">'.trans('plugin/cms::common.draft').'</span>';
                break;
        }
    }
}
