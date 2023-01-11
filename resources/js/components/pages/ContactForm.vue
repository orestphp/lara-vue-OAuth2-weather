<template>
    <div>
        <div class="gl_contact_row">
            <div class="gl_contact_col">
                <label>Full Name <span style="color: red">*</span></label>
                <span class="gl_contact_error_text error_mes_full_name"></span>
                <input v-model="full_name" v-on:blur="validate_inline('full_name')" value=""/>
            </div>
        </div>
        <div class="gl_contact_row">
            <div class="gl_contact_col">
                <label>Email <span style="color: red">*</span></label>
                <span class="gl_contact_error_text error_mes_email"></span>
                <input v-model="email" v-on:blur="validate_inline('email')" value=""/>
            </div>
        </div>
        <div class="gl_contact_row">
            <div class="gl_contact_col gl_contact_col_half">
                <label>Subject</label>
                <input v-model="subject" value=""/>
            </div>
        </div>
        <div class="gl_contact_row">
            <div class="gl_contact_col gl_contact_col_full">
                <label>Message <span style="color: red">*</span></label>
                <span class="gl_contact_error_text error_mes_message"></span>
                <textarea v-model="message" v-on:blur="validate_inline('message')"></textarea>
            </div>
        </div>
        <div class="gl_contact_row">
            <a class="gl_btn gl_contact" href="#" v-on:click="send($event)">Send</a>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
    },
    props: [],
    data() {
        return {
            lang: 'en',
            full_name: '',
            message: '',
            email: '',
            subject: '',
        };
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
        validate_inline(name) {
            if ($.trim(this[name]) == '') {
                $('.error_mes_' + name).text('error');
                $('.error_mes_' + name)
                    .parent()
                    .find('textarea')
                    .css({border: '1px solid red'});
                $('.error_mes_' + name)
                    .parent()
                    .find('input')
                    .css({border: '1px solid red'});
            } else {
                $('.error_mes_' + name).empty();
                $('.error_mes_' + name)
                    .parent()
                    .find('input')
                    .css({border: '1px solid #000'});
                $('.error_mes_' + name)
                    .parent()
                    .find('textarea')
                    .css({border: '1px solid #000'});
            }
        },
    },
};
</script>
