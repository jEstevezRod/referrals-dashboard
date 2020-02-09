<template>
    <v-container fluid>
        <h1>Adding a new product</h1>
        <v-row>
            <v-col cols="9">
                <v-row>
                    <v-col cols="6">
                        <h2 v-if="domainSelected">Domain selected: {{domainSelected.name}}</h2>
                        <v-select
                            :items="domains"
                            label="Domain"
                            v-model="domainSelected"
                            clearable
                            filled
                            item-text="name"
                            return-object
                            :persistent-hint="!!domainSelected"
                            :hint="domainSelected.url"
                            @change="onChangeDomain"
                        />
                    </v-col>
                    <v-col cols="6" v-if="domainSelected">
                        <h2 v-if="categorySelected">Category: {{categorySelected.name}}</h2>
                        <v-select
                            :items="categories"
                            label="Category"
                            v-model="categorySelected"
                            clearable
                            filled
                            item-text="name"
                            return-object

                        />
                    </v-col>

                </v-row>
                <v-row v-if="domainSelected && categorySelected">
                    <v-col cols="12">
                        <v-text-field
                            filled
                            v-model="product.name"
                            label="Product name"
                            required
                        />
                        <v-text-field
                            filled
                            v-model="product.price"
                            label="Product price"
                            required
                            filled
                        />
                        <v-text-field
                            v-model="product.img"
                            label="Image path"
                            required
                            filled
                        />
                        <v-text-field
                            v-model="product.amazon_url"
                            label="Amazon affiliate URL"
                            required
                            filled
                        />
                        <v-textarea
                            filled
                            name="input-7-4"
                            label="Product description"
                            v-model="product.description"
                        />
                    </v-col>
                </v-row>
                <v-row v-if="domainSelected && categorySelected">
                    <v-col>
                        <v-btn @click="createProduct" color="success">Create</v-btn>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="3" v-if="domainSelected">
                <v-treeview :items="tree"/>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "Product",
        mounted() {
            this.$store.dispatch('listDomains')
        },
        computed: {
            domains() {
                return this.$store.getters.domains
            },
            categories() {
                return this.domainSelected.categories
            },
            tree() {
                return this.$store.getters.tree;
            }
        },
        methods: {
            onChangeDomain() {
                this.$store.dispatch('loadTree', this.domainSelected.id);
            },
            createProduct() {
                this.product['category_name'] = this.categorySelected.name;
                this.product['cat_id'] = this.categorySelected.id;
                this.product['slug'] = this.encodeSlug(this.product.name);

                this.$store.dispatch('createProduct', this.product).then(res => {
                    this.product = {name: '', price: '', img: '', amazon_url: '', description: ''}
                    this.$store.dispatch('loadTree', this.domainSelected.id);
                })

            },
            encodeSlug(str) {
                str = str.replace(/^\s+|\s+$/g, '');
                str = str.toLowerCase();
                let from = "àáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
                let to = "aaaaaeeeeiiiioooouuuunc------";
                for (var i = 0, l = from.length; i < l; i++) {
                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                }
                str = str.replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                return str;
            }
        },
        data: () => ({
            product: {name: '', price: '', img: '', amazon_url: '', description: ''},
            domainSelected: '',
            categorySelected: '',
            items: [
                {
                    id: 1,
                    name: 'Applications :',
                    children: [
                        {id: 2, name: 'Calendar : app'},
                        {id: 3, name: 'Chrome : app'},
                        {id: 4, name: 'Webstorm : app'},
                    ],
                },
                {
                    id: 5,
                    name: 'Documents :',
                    children: [
                        {
                            id: 6,
                            name: 'vuetify :',
                            children: [
                                {
                                    id: 7,
                                    name: 'src :',
                                    children: [
                                        {id: 8, name: 'index : ts'},
                                        {id: 9, name: 'bootstrap : ts'},
                                    ],
                                },
                            ],
                        },
                        {
                            id: 10,
                            name: 'material2 :',
                            children: [
                                {
                                    id: 11,
                                    name: 'src :',
                                    children: [
                                        {id: 12, name: 'v-btn : ts'},
                                        {id: 13, name: 'v-card : ts'},
                                        {id: 14, name: 'v-window : ts'},
                                    ],
                                },
                            ],
                        },
                    ],
                },
                {
                    id: 15,
                    name: 'Downloads :',
                    children: [
                        {id: 16, name: 'October : pdf'},
                        {id: 17, name: 'November : pdf'},
                        {id: 18, name: 'Tutorial : html'},
                    ],
                },
                {
                    id: 19,
                    name: 'Videos :',
                    children: [
                        {
                            id: 20,
                            name: 'Tutorials :',
                            children: [
                                {id: 21, name: 'Basic layouts : mp4'},
                                {id: 22, name: 'Advanced techniques : mp4'},
                                {id: 23, name: 'All about app : dir'},
                            ],
                        },
                        {id: 24, name: 'Intro : mov'},
                        {id: 25, name: 'Conference introduction : avi'},
                    ],
                },
            ],
        })
    }
</script>

<style scoped>

</style>
