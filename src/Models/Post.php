<?php

namespace IBoot\CMS\Models;

use IBoot\Core\App\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Post extends BaseModel
{
    const PENDING = 1;
    const PUBLISHED = 2;

    protected $guarded = ['id'];
    /**
     * @return MorphToMany
     */
    public function medias(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'media_able');
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
