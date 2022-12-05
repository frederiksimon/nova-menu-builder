<?php

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Outl1ne\MenuBuilder\MenuBuilder;

if (!function_exists('nova_get_menus')) {
    function nova_get_menus($locale = null)
    {
        if ($locale !== null) {
            return MenuBuilder::getMenuClass()::all()->map(function ($menu) use ($locale) {
                return $menu->formatForAPI($locale);
            });
        }

        $locales = array_keys(MenuBuilder::getLocales());

        return MenuBuilder::getMenuClass()::all()->map(function ($menu) use ($locales) {
            return array_map(function ($locale) use ($menu) {
                return $menu->formatForAPI($locale);
            }, $locales);
        })->flatten(1)->toArray();
    }
}

if (!function_exists('nova_get_menu_by_slug')) {
    function nova_get_menu_by_slug($slug, $locale = null)
    {
        if (empty($slug)) return null;
        if (empty($locale)) $locale = array_keys(MenuBuilder::getLocales())[0] ?? null;
        $menu = MenuBuilder::getMenuClass()::where('slug', $slug)->first();
        return !empty($menu) ? $menu->formatForAPI($locale) : null;
    }
}

// ------------------------------
// nova_menu_builder_sanitize_panel_name
// ------------------------------

if (!function_exists('nova_menu_builder_sanitize_panel_name')) {
    function nova_menu_builder_sanitize_panel_name($name)
    {
        $removedSpecialChars = preg_replace("/[^A-Za-z0-9 ]/", '', $name);
        $snakeCase = preg_replace("/\s+/", '_', $removedSpecialChars);
        return strtolower($snakeCase);
    }
}



if (!function_exists('nova_menu_builder_create_file_object')) {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    function nova_menu_builder_create_file_object_from_base64($base64File, $name)
    {
        // Get file data base64 string
        $fileData = base64_decode(Arr::last(explode(',', $base64File)));

        // Create temp file and get its absolute path
        $tempFile = tmpfile();
        $tempFilePath = stream_get_meta_data($tempFile)['uri'];

        // Save file data in file
        file_put_contents($tempFilePath, $fileData);

        $tempFileObject = new File($tempFilePath);
        $file = new UploadedFile(
            $tempFileObject->getPathname(),
            $name,
            $tempFileObject->getMimeType(),
            0,
            true // Mark it as test, since the file isn't from real HTTP POST.
        );

        // Close this file after response is sent.
        // Closing the file will cause to remove it from temp director!
        app()->terminating(function () use ($tempFile) {
            fclose($tempFile);
        });

        // return UploadedFile object
        return $file;
    }
}
