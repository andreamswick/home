<?php

namespace App;

use Carbon\Carbon;
use Httpful\Request;

class Weather
{
    protected $cityID = '4887398';

    public function now($lat = null, $long = null)
    {
        $weather = Request::get($this->buildUrl('weather', $lat, $long))->send();

        return $this->transform(json_decode($weather, true));
    }

    public function forecast($lat = null, $long = null)
    {
        $forecast = Request::get($this->buildUrl('forecast/daily', $lat, $long))->send();

        return $this->transformForecast(json_decode($forecast, true)['list']);
    }

    private function transform($weather)
    {
        return [
            'city'           => array_get($weather, 'name'),
            'temp'           => array_get($weather, 'main.temp'),
            'low'            => array_get($weather, 'main.temp_min'),
            'high'           => array_get($weather, 'main.temp_max'),
            'sunrise'        => $this->getTime(array_get($weather, 'sys.sunrise')),
            'sunset'         => $this->getTime(array_get($weather, 'sys.sunset')),
            'condition'      => title_case(array_get($weather, 'weather.0.description')),
            'condition_icon' => array_get($weather, 'weather.0.icon'),
        ];
    }

    private function transformForecast($forecast)
    {
        return collect($forecast)->map(function($day) {
            return [
                'low'            => array_get($day, 'temp.min'),
                'high'           => array_get($day, 'temp.max'),
                'condition'      => title_case(array_get($day, 'weather.0.description')),
                'condition_icon' => array_get($day, 'weather.0.icon'),
            ];
        })->toArray();
    }

    private function getTime($time)
    {
        return Carbon::createFromTimestamp($time)->timezone('America/Chicago')->format('g:i a');
    }

    private function buildUrl($action, $lat, $long)
    {
        $base = 'api.openweathermap.org/data/2.5/';
        return "{$base}{$action}?units=imperial&lat={$lat}&lon={$long}&APPID=" . env('WEATHER_ID');
    }
}
