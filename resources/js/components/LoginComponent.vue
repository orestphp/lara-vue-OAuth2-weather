<template>
    <div>
        <span class="error animated tada" id="msg"></span>
        <form name="form1" class="box" onsubmit="">
            <h4><span>SPA</span> Weather<span>Forecast</span></h4>
            <img width="400" src="images/googleDark.jpg" alt="">
            <input type="button" value="Sign in via Web" class="btn1" onclick="document.location.href='/login'">
        </form>
        <a href="/google/login" class="dnthave">Don’t have an account? Sign up</a>
    </div>
</template>

<script>
export default {
    mounted() {

    },
    methods: {
        send(event) {
            event.preventDefault();
            let formData = new FormData();
            formData.append('full_name', this.full_name);
            formData.append('email', this.email);
            formData.append('subject', this.subject);
            formData.append('message', this.message);
            axios
                .post('/contact', formData, {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}})
                .then((res) => {
                    alert('success');
                    location.reload();
                })
                .catch((error) => {
                    $.each(error.response.data.errors, function (key, value) {
                        $('.error_mes_' + key).text(value);
                        $('.error_mes_' + key)
                            .parent()
                            .find('textarea')
                            .css({border: '1px solid red'});
                        $('.error_mes_' + key)
                            .parent()
                            .find('input')
                            .css({border: '1px solid red'});
                    });
                });
        },
    }
}
</script>
