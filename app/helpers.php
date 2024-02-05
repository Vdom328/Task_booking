<?php


if (!function_exists('getData')) {
    /**
     * get data by dishes json
     */
    function getData()
    {
        $jsonFilePath = base_path('data/dishes.json');

        $jsonContent = file_get_contents($jsonFilePath);

        return json_decode($jsonContent, true);
    }
}


