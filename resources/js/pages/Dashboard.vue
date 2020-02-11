<template>
    <div class="container">
        <v-tabs centered grow class="tabs" color="red accent-2" background-color="grey lighten-2" v-model="activeTab">
            <v-tab v-for="tab in tabs" :key="tab.id" :to="tab.route" exact>
                {{ tab.name }}
            </v-tab>
        </v-tabs>
        <router-view> Select one tab to start working :) </router-view>
        <!--        <div>-->
        <!--            <user-list/>-->
        <!--        </div>-->
    </div>
</template>
<script>
    import userList from '../components/user-list'

    export default {
        name: "admin.dashboard",
        components: {userList},
        data() {
            return {
                activeTab: '/admin/product',
                tabs: [
                    {id: 1, name: "Product", route: `/admin`},
                    {id: 2, name: "Category", route: `/admin/category`},
                    {id: 3, name: "Domain", route: `/admin/domain`}
                ]
            }
        }
    }
</script>
