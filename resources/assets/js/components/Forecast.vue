<template>
    <div class="forecast">
        <div class="day" v-for="day in forecast">
            <p><img :src="'http://openweathermap.org/img/w/' + day.condition_icon + '.png'" alt=""></p>

            <p>{{ day.low }}&deg <br> {{ day.high }}&deg</p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['lat', 'long'],
        data() {
            return {
                forecast: ''
            }
        },
        mounted() {
            this.getForecast();
        },
        methods: {
            getForecast() {
                self = this;
                axios.get('/api/forecast',
                    {
                        params: {
                            lat: this.lat,
                            long: this.long
                        }
                    })
                    .then(function (response) {
                        self.forecast = response.data
                    })
            }
        }
    }
</script>

<style>
    .forecast {
        border-top: 1px dashed #cbcbcb;
        padding-top: 5px;
        display: flex;
    }
    .day {
        flex: 1;
    }
</style>