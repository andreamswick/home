<template>
    <section :style="{ 'background-image': 'url(' + image + ')' }">
        <div class="container">
            <div class="row row-eq-height">
                <weather></weather>
                <clock></clock>
            </div>
        </div>
    </section>
</template>

<script>
    import Clock from './Clock.vue';
    import Weather from './Weather.vue';

    export default {
        data() {
            return {
                images: {},
                image: '',
                user: '',
                user_image: '',
                tags: ''
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
        }
    }
</script>

<style>
    section {
        width: 100%;
        height: 100vh;
        background: #333333 url(/img/chromecast/1200_YosemiteFalls.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }

    .container {
        padding-top: 2em;
    }

    .row-eq-height {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display:         flex;
    }

    .panel {
        height: 100%;
        background-color: rgba(51, 51, 51, 0.53);
        border-color: transparent;
        color: #ffffff;
    }
</style>
