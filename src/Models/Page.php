<?php

namespace IBoot\CMS\Models;

use IBoot\Core\App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Page extends BaseModel
{
    protected $guarded = ['id'];

    /**
     * @return MorphToMany
     */
    public function medias(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'media_able');
    }
}
