<template>
    <div>
        <div class="row">
            <form name="form1" class="box" onsubmit="">
                <h4><span>SPA</span> Weather<span>Forecast</span></h4>
                <img width="400" src="images/googleDark.jpg" alt="google">
                <input type="button" value="Sign in via Web" class="btn1" onclick="document.location.href='/login'">
            </form>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="javascript:void(0)" @click.prevent="authProvider('google')" class="dnthave">
                    Don’t have an account?
                </a>
            </div>
            <div class="col-md-6">
                <a href="" class="dnthave2" id="dnthave2">
                    Sign up
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    computed: {
        ...mapGetters(['loggedUser']),
    },
    methods: {
        authProvider(provider) {
            let self = this;
            this.$auth.authenticate(provider).then(response => {
                self.socialLogin(provider, response)
            }).catch(error => {
                console.log(error)
            })
        },
        socialLogin(provider,response) {
            this.$http.get(`${process.env.MIX_API_URL}/${provider}/login/`, response).then(response => {
                document.getElementById('dnthave2').href = response.data.url;
                document.getElementById('dnthave2').click();
            }).catch(error => {
                console.log(error)
            })
        },
    }
}
</script>


