<template>
    <div>
        <span class="error animated tada" id="msg"></span>
        <form name="form1" class="box" onsubmit="">
            <h4><span>SPA</span> Weather<span>Forecast</span></h4>
            <p>{{ loggedUser }}</p>
            <img width="400" src="images/googleDark.jpg" alt="google">
            <input type="button" value="Sign in via Web" class="btn1" onclick="document.location.href='/login'">
        </form>
        <a href="javascript:void(0)" onclick="loginWithGoogle()" class="dnthave">
            Don’t have an account? Sign up
        </a>
    </div>
</template>

<script>
export default {
    mounted() {

    },
    computed: {
        loggedUser() {
            return this.$store.state.loggedUser;
        }
    },
    methods: {
        loginWithGoogle() {
            axios.post('/api/google/login', {}, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then((res) => {
                    console.log(res);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    }
}
</script>


