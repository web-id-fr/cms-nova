<?php

use Illuminate\Support\Str;

if (! function_exists('package_base_path')) {
    /**
     * Retourne le chemin en partant de la racine du package.
     */
    function package_base_path(string $path = ''): string
    {
        $path = ltrim($path, '/');

        return __DIR__ . "/../../{$path}";
    }
}

if (! function_exists('package_module_path')) {
    /**
     * Retourne le chemin en partant du dossier Modules du package.
     */
    function package_module_path(string $path = ''): string
    {
        $path = ltrim($path, '/');

        return package_base_path("src/Modules/{$path}");
    }
}

if (! function_exists('current_url_is')) {
    /**
     * Compare la chaine passée en paramètre avec l'url actuelle,
     * pour déterminer si la chaine correspond à la page actuelle.
     */
    function current_url_is(string $urlToCompare): bool
    {
        // On récupère uniquement le path de l'url à comparer
        /** @var string $urlPath */
        $urlPath = parse_url($urlToCompare, PHP_URL_PATH) ?? '';
        $urlPath = trim($urlPath, '/');

        return request()->is("{$urlPath}*");
    }
}

if (! function_exists('str_unslug')) {
    /**
     * Transforme un slug en une chaine de caractères "classique" avec espaces et majuscules.
     */
    function str_unslug(string $string): string
    {
        // Supprime les séparateurs
        /** @var string $string */
        $string = preg_replace('/[-_.]/', ' ', $string);

        // Met les majuscules
        return ucfirst($string);
    }
}

if (! function_exists('has_zone_menu')) {
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function has_zone_menu(string $zone): bool
    {
        $menus = app()->make(\Webid\CmsNova\App\Repositories\Menu\MenuRepository::class);

        return $menus->menuZoneExist($zone);
    }
}

if (! function_exists('is_video')) {
    /**
     * Détermine si le fichier dont le nom est passé en paramètre est une vidéo.
     *
     * @return bool
     */
    function is_video(string $filename)
    {
        return (bool) preg_match('/^.*\.(mp4|mov)$/i', $filename);
    }
}

if (! function_exists('is_image')) {
    /**
     * Détermine si le fichier dont le nom est passé en paramètre est une image.
     *
     * @return bool
     */
    function is_image(string $filename)
    {
        return (bool) preg_match('/^.*\.(jpg|png|gif|jpeg|tiff|svg|webp)$/i', $filename);
    }
}

if (! function_exists('media_full_url')) {
    /**
     * Retourne l'URL complète d'un fichier qui est stocké dans le filemanager ou dans le s3.
     */
    function media_full_url(?string $file_path): string
    {
        if (is_null($file_path)) {
            return '';
        }

        $file_path = ltrim($file_path, '/');

        return config('cms.image_path') . rawurlencode($file_path);
    }
}

if (! function_exists('arrayKeysAreLocales')) {
    function arrayKeysAreLocales(array $parameter): bool
    {
        return ! empty(array_intersect_key(config('translatable.locales'), $parameter));
    }
}

if (! function_exists('str_slug')) {
    function str_slug(string $url): string
    {
        return Str::slug($url);
    }
}

if (! function_exists('form_field_id')) {
    function form_field_id(array $field, string $idForm): string
    {
        if (! isset($field['field_name'])) {
            throw new \InvalidArgumentException('The field_name is missing.');
        }

        return Str::slug($idForm . '-' . $field['field_name']);
    }
}

if (! function_exists('get_full_url_for_page')) {
    function get_full_url_for_page(string $path): string
    {
        return Str::slug(request()->lang . '/' . $path);
    }
}
