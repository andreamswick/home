<template>
    <div class="col-xs-6">
        <div class="panel panel-default" v-if="weather">
            <div class="panel-body text-center">
                <h4>Currently in {{ weather.city }}:</h4>
                <h1>{{ weather.temp }}&deg</h1>
                <p>Low: {{ weather.low }}&deg | High: {{ weather.high }}&deg</p>

                <p><img :src="'http://openweathermap.org/img/w/' + weather.condition_icon + '.png'" alt="">
                    {{ weather.condition }}</p>
                <p>Sunrise: {{ weather.sunrise }} | Sunset: {{ weather.sunset }}</p>
                <forecast :lat="lat" :long="long"></forecast>
            </div>
        </div>
    </div>
</template>

<script>
    import Forecast from './Forecast.vue';

    export default {
        data() {
            return {
                weather: null,
                lat: '41.95418449999999',
                long: '-87.64582589999998'
            }
        },
        mounted() {
            this.getLocation();
            setInterval(this.getWeather, 300000);
        },
        methods: {
            getWeather() {
                self = this;
                axios.get('/api/weather',
                    {
                        params: {
                            lat: this.lat,
                            long: this.long
                        }
                    })
                    .then(function (response) {
                        self.weather = response.data
                    })
            },
            getLocation() {
                self = this;
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        console.log(position);
                        self.lat = position.coords.latitude;
                        self.long = position.coords.longitude;

                        self.getWeather();
                    },
                    function(error) {
                        self.getWeather();
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                alert("User denied the request for Geolocation.");
                                break;
                            case error.POSITION_UNAVAILABLE:
                                alert("Location information is unavailable.");
                                break;
                            case error.TIMEOUT:
                                alert("The request to get user location timed out.");
                                break;
                            case error.UNKNOWN_ERROR:
                                alert("An unknown error occurred.");
                                break;
                        }
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            }
        },
        components: {
            Forecast
        }
    }
</script>