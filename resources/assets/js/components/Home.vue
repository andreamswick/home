<template>
    <section :style="{ 'background-image': 'url(' + image + ')' }">
        <div class="container">
            <div class="row row-eq-height">
                <div class="col-xs-7">
                    <weather></weather>
                </div>
                <div class="col-xs-5">
                    <clock></clock>
                    <timer v-on:timerEnded="showTimerModal"></timer>
                </div>
            </div>
        </div>
        <timer-modal v-if="timerModal" @close="hideTimerModal"></timer-modal>
        <audio ref="sound" :src="'/sounds/' + sound"></audio>
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
                timerModal: false,
                sounds: [
                    'lone_ranger.mp3',
                    'sandstorm.mp3',
                    'sherlock.mp3',
                    'star_trek.mp3',
                    'star_wars.mp3',
                    'super_mario_bros.mp3',
                    'tequila.mp3',
                ],
                sound: ''
            }
        },
        created() {
            this.sound = this.sounds[Math.floor(Math.random() * this.sounds.length)];
            this.getImages();
            setInterval(this.setBackground, 1800000);
        },
        methods: {
            getImages() {
                let self = this;
                axios.get('/api/images')
                    .then(function (response) {
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
            },
            showTimerModal() {
                this.timerModal = true;
                this.$refs.sound.loop = true;
                this.$refs.sound.play()
            },
            hideTimerModal() {
                this.timerModal = false;
                this.$refs.sound.pause();
                this.$refs.sound.currentTime = 0;
                this.sound = this.sounds[Math.floor(Math.random() * this.sounds.length)];
            }
        },
        components: {
            Clock, Weather, Timer, TimerModal
        }
    }
</script>