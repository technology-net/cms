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
