<template>
    <div>
        <div v-if="loggedUser && token" class="card">
            <div class="card-content">
                <div class="notification">
                    Welcome back <strong>{{ loggedUser.name }}</strong> !
                </div>
            </div>
        </div>
        <div v-else class="notification">
            You're not logged in!
        </div>

        <div v-if="status" class="notification">
            <p>{{ status }}</p>
        </div>
        <div v-else>
            <vue-json-pretty class="notification" :data="weatherJson" />
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import VueJsonPretty from 'vue-json-pretty';
import 'vue-json-pretty/lib/styles.css';

export default {
    name: 'Home',
    components: {
        VueJsonPretty
    },
    data() {
        return {
            token: localStorage.getItem('token'),
            status: 'Locating …',
            weatherJson: {},
        }
    },
    computed: {
        ...mapGetters(['loggedUser']),
    },
    mounted() {
        if(!this.token) {
            this.$router.push({ path: '/' });
        } else {
            this.geoFindMe();
        }
    },
    methods: {
        geoFindMe() {
            if (!navigator.geolocation) {
                this.status = 'Geolocation is not supported by your browser';
            } else {
                this.status = 'Locating …';
                navigator.geolocation.getCurrentPosition(this.weatherSuccess, function error() {
                    console.log('Sorry, no position available.');
                });
            }
        },
        async weatherSuccess(position) {
            this.weatherJson = await this.$plugins.getWeather(
                position.coords.latitude,
                position.coords.longitude,
                this.token
            );
            this.status = '';
        },
    }
}
</script>

