<template>
    <div>
        <div v-if="loggedUser && token" class="card">
            <div class="card-content">
                <div class="notification">
                    Welcome back, <strong>{{ loggedUser.name }}</strong>
                </div>
            </div>
        </div>
        <div v-else class="notification">
            You're not logged in!
        </div>
        <div>
            <vue-json-pretty class="notification" :data="{ key: 'value' }" />
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
            token: localStorage.getItem('token')
        }
    },
    computed: {
        ...mapGetters(['loggedUser']),
    },
    mounted() {
        let self = this;
        // in case token expired, give time to check
        setTimeout(function() {
            if(_.isEmpty(self.loggedUser)) {
                self.$router.push({ path: '/' });
            }
        }, 500);
    },
}
</script>


