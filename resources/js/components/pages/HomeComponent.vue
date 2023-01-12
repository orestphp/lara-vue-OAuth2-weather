<template>
    <div>
        Hello World !
    </div>
</template>

<script>
export default {
    async mounted() {
       const result = await this.$plugins.getWeather();
       console.log(result)
    },
    data() {
        return {
            result: {},
        };
    },
}
</script>


