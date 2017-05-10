<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <h1 class="text-center" v-if="end">{{ minutes }}:{{ seconds }}</h1>
            <h1 class="text-center" v-if="hasEnded">Time's up!</h1>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-primary btn-block" v-on:click="start(25)">25 minutes</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary btn-block" v-on:click="start(5)">5 minutes</button>
                    <button class="btn btn-primary btn-block" v-on:click="start(.25)">.25 minutes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        data() {
            return {
                end: '',
                now: '',
                interval: '',
                hasEnded: false,
            }
        },
        methods: {
            start(minutes) {
                this.end = Math.trunc(moment().add(minutes, 'm').toDate() / 1000);

                this.interval = setInterval(() => {
                    this.now = Math.trunc((new Date()).getTime() / 1000);
                },1000);

                if((this.end - this.now) < 0) {
                    clearInterval(this.interval);
                }
            }
        },
        computed: {
            seconds() {
                console.log(this.end - this.now);
                return (this.end - this.now) % 60;
            },
            minutes() {
                return Math.trunc((this.end - this.now) / 60) % 60;
            },
        },
        watch: {
            now: function() {
                if((this.end - this.now) <= 0) {
                    clearInterval(this.interval);
                    this.end = '';
                    this.now = '';
                    this.hasEnded = true;
                }
            }
        }
    }
</script>