<template>
    <div class="panel panel-default">
        <div class="panel-body text-center">
            <h2>{{ date }}</h2>
            <h2 v-for="time in times">{{ time }}</h2>
        </div>
    </div>
</template>

<script>
    import moment from 'moment-timezone';

    export default {
        data () {
            return {
                date: '',
                times: {
                    central: '',
                    eastern: '',
                    pacific: '',
                }
            }
        },
        props: {
            dateformat: {
                type: String,
                default: 'ddd, MMM D',
            },
            timeformat: {
                type: String,
                default: 'h:mm a z',
            }
        },
        created () {
            this.refresh();
            setInterval(this.refresh, 1000)
        },
        methods: {
            refresh () {
                this.date = moment().tz("America/Chicago").format(this.dateformat);
                this.times.central = moment().tz("America/Chicago").format(this.timeformat);
                this.times.eastern = moment().tz("America/New_York").format(this.timeformat);
                this.times.pacific = moment().tz("America/Los_Angeles").format(this.timeformat);
            }
        }
    }
</script>