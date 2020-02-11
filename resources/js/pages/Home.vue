<template>
    <v-container>
        <v-row justify="center">
            <v-col class="d-flex justify-center">
                <v-img contain src="/storage/bg.png" max-width="80%" alt="" >
                    <div class="fill-height bottom-gradient"></div>
                    <template v-slot:placeholder>
                        <v-row
                            class="fill-height ma-0"
                            align="center"
                            justify="center"
                        >
                            <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                        </v-row>
                    </template>
                </v-img>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "Home"
    }
</script>

<style scoped>
    .bottom-gradient {
        background-image: linear-gradient(to top, rgba(0, 0, 0, 0.4) 0%, transparent 72px);
    }
</style>
