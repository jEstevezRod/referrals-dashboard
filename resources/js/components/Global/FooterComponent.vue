<template>
    <v-footer
        absolute
        class="font-weight-medium"
    >
        <v-col
            class="text-center"
            cols="12"
        >
            {{ new Date().getFullYear() }} — Developed by <strong>Jesus Estevez</strong>
        </v-col>
    </v-footer>
</template>

<script>
    export default {
        name: "FooterComponent"
    }
</script>

<style scoped>

</style>
