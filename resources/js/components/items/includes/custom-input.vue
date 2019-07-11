<template>
        <input class="form-control"
            v-bind:value="value"
            v-on:input="$emit('input', $event.target.value)"
        >
</template>

<script>
    export default {
        name: "custom-input",
        props: ['value'],
        methods:{
        }
    }
</script>

<style scoped>

</style>
