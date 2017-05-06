<?php

namespace App;


use Carbon\Carbon;
use Httpful\Request;

class Weather
{

    protected $base = 'api.openweathermap.org/data/2.5/weather?units=imperial';
    protected $cityID = '4887398';

    public function get($lat = null, $long = null)
    {
        $url = "{$this->base}&lat={$lat}&lon={$long}&APPID=" . env('WEATHER_ID');

        if(is_null($lat) && is_null($long)) {
            $url = "{$this->base}&id={$this->cityID}&APPID=" . env('WEATHER_ID');
        }

        $weather = Request::get($url)->send();

        return $this->transform(json_decode($weather, true));
    }

    private function transform($weather)
    {
        return [
            'city'      => array_get($weather, 'name'),
            'temp'      => array_get($weather, 'main.temp'),
            'low'       => array_get($weather, 'main.temp_min'),
            'high'      => array_get($weather, 'main.temp_max'),
            'sunrise'   => $this->getTime(array_get($weather, 'sys.sunrise')),
            'sunset'    => $this->getTime(array_get($weather, 'sys.sunset')),
            'condition' => title_case(array_get($weather, 'weather.0.description')),
            'condition_icon' => array_get($weather, 'weather.0.icon'),
        ];
    }

    private function getTime($time) {
        return Carbon::createFromTimestamp($time)->timezone('America/Chicago')->format('g:i a');
    }
}
