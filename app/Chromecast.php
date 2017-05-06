<?php

namespace App;

use Illuminate\Filesystem\Filesystem;

class Chromecast
{

    protected $files;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function get()
    {
        return $this->transform($this->files->files(public_path('img/chromecast')));
    }

    private function transform($pictures)
    {
        return collect($pictures)->transform(function($pic) {
            return [
                'image' => env('APP_URL') . str_replace(base_path() . "/public", "", $pic),
            ];
        })->shuffle();
    }
}
