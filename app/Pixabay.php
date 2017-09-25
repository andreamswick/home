<?php

namespace App;

use Carbon\Carbon;
use Httpful\Request;

class Pixabay
{

    protected $base = 'https://pixabay.com/api/?orientation=horizontal&category=backgrounds&order=popular';

    public function get()
    {
        $url = "{$this->base}&key=" . env('PIXABAY');

        $pictures = Request::get($url)->send();

        return $this->transform(json_decode($pictures, true));
    }

    private function transform($pictures)
    {
        return collect($pictures['hits'])->transform(function ($pic) {
            return [
                'image' => $pic['webformatURL'],
                'user' => $pic['user'],
                'user_image' => array_get($pic, 'userImageUrl', ''),
                'tags' => $pic['tags']
            ];
        });
    }
}
