<?php

/**
 * @return int|string|null
 */
if (!function_exists('userIdLogin')) {
    function userIdLogin()
    {
        return auth()->id();
    }
}
/**
 * @param $userId
 * @return string
 */
if (!function_exists('getNameUser')) {
    function getNameUser($userId)
    {
        return !empty($userId) ? \IBoot\Core\App\Models\User::query()->find($userId)->name : '';
    }
}
if (!function_exists('listCategories')) {
    function listCategories()
    {
        return app(\IBoot\CMS\Services\CategoryService::class)->getLists();
    }
}
/**
 * @param $categories
 * @param $char
 * @param $parentId
 * @return array
 */
if (!function_exists('getCategories')) {
    function getCategories($categories, $char = '', $parentId = null): array
    {
        $result = [];
        foreach ($categories as $item) {
            if ($item->parent_id == $parentId) {
                $result[$item->id] = $char . $item->name;
                $result += getCategories($categories, $char . '└─ ', $item->id);
            }
        }
        return $result;
    }
}
/**
 * @return array{0: mixed, 1: mixed, 2: mixed}
 */
if (!function_exists('postStatus')) {
    function postStatus(): array
    {
        return [
            '0' => trans('plugin/cms::common.draft'),
            '1' => trans('plugin/cms::common.pending'),
            '2' => trans('plugin/cms::common.published'),
        ];
    }
}
/**
 * @param $statusId
 * @return string
 */
if (!function_exists('postStatusText')) {
    function postStatusText($statusId)
    {
        return \IBoot\CMS\Models\Post::postStatusText($statusId);
    }
}
