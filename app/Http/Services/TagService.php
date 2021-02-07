<?php


namespace App\Http\Services;


class TagService
{
    /**
     * @param array $tags
     * @return array
     * @author Admin <admin@gmail.com>
     */
    public static function getIds(array $tags)
    {
        return array_column($tags, "id");
    }
}