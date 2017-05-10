<template>
    <section :style="{ 'background-image': 'url(' + image + ')' }">
        <div class="container">
            <div class="row row-eq-height">
                <div class="col-xs-7">
                    <weather></weather>
                </div>
                <div class="col-xs-5">
                    <clock></clock>
                    <timer v-on:timerEnded="showTimerModal = true"></timer>
                </div>
            </div>
        </div>
        <timer-modal v-if="showTimerModal" @close="showTimerModal = false"></timer-modal>
    </section>
</template>

<script>
    import Clock from './Clock.vue';
    import Weather from './Weather.vue';
    import Timer from './Timer.vue';
    import TimerModal from './TimerModal.vue';

    export default {
        data() {
            return {
                images: {},
                image: '',
                showTimerModal: false,
            }
        },
        created() {
            this.getImages();
            setInterval(this.setBackground, 1800000);
        },
        methods: {
            getImages() {
                let self = this;
                axios.get('/api/images')
                    .then(function(response) {
                        self.images = response.data;
                        self.setBackground();
                    });
            },
            setBackground() {
                if (this.images.length !== 0) {
                    this.image = this.images[0].image;
                    this.user = this.images[0].user;
                    this.user_image = this.images[0].user_image;
                    this.tags = this.images[0].tags;

                    this.images.shift();
                }
                else {
                    this.getImages();
                }
            }
        },
        components: {
            Clock, Weather, Timer, TimerModal
        }
    }
</script>