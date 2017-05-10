<template>
    <div class="panel panel-default">
        <div class="panel-body text-center">
            <h1>{{ time }}</h1>
            <h2>{{ date }}</h2>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        data () {
            return {
                date: '',
                time: ''
            }
        },
        props: {
            dateformat: {
                type: String,
                default: 'ddd, MMM D',
            },
            timeformat: {
                type: String,
                default: 'h:mm a',
            }
        },
        created () {
            this.refresh();
            setInterval(this.refresh, 1000)
        },
        methods: {
            refresh () {
                this.date = moment().format(this.dateformat);
                this.time = moment().format(this.timeformat);
            }
        }
    }
</script>