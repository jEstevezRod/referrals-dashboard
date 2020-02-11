<template>
    <v-container fluid>
        <p class="display-1 grey--text text--darken-3 mt-5">Adding a new product</p>
        <v-divider/>
        <v-row>
            <v-col cols="9">
                <v-row>
                    <fade-transition>
                        <v-col cols="6">
                            <p v-if="domainSelected"><span
                                class="headline grey--text text--darken-3"> Domain selected:</span> <span
                                class="headline blue--text text--darken-3">{{domainSelected.name}}</span></p>
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
                    </fade-transition>
                    <fade-transition>

                        <v-col cols="6" v-if="domainSelected">
                            <p v-if="categorySelected"><span
                                class="headline grey--text text--darken-3"> Category: </span>
                                <span class="headline blue--text text--darken-3"> {{categorySelected.name}} </span></p>
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
                        </fade-transition>

                </v-row>
                <v-form v-model="valid" ref="form2" @submit.prevent="createProduct">
                    <fade-transition>

                        <v-row v-if="domainSelected && categorySelected">
                            <v-col cols="12">
                                <v-text-field
                                    filled
                                    v-model="product.name"
                                    label="Product name"
                                    required
                                    ref="nextProduct"
                                    :rules="[rules.required]"
                                />
                                <v-text-field
                                    filled
                                    v-model="product.price"
                                    label="Product price"
                                    required
                                    type="number"
                                    :rules="[rules.required]"

                                />
                                <v-text-field
                                    v-model="product.img"
                                    label="Image path"
                                    required
                                    filled
                                    :rules="[rules.required]"

                                />
                                <v-text-field
                                    v-model="product.amazon_url"
                                    label="Amazon affiliate URL"
                                    required
                                    filled
                                    :rules="[rules.required, rules.urlMatch]"

                                />
                                <v-textarea
                                    filled
                                    name="input-7-4"
                                    label="Product description"
                                    v-model="product.description"
                                />
                            </v-col>
                        </v-row>
                        </fade-transition>

                            <v-row v-if="domainSelected && categorySelected">
                                <v-col>
                                    <v-btn type="submit" color="success">Create</v-btn>
                                </v-col>
                            </v-row>
                </v-form>
            </v-col>
            <v-col cols="3" v-if="domainSelected">
                <v-treeview :items="tree"/>
            </v-col>
        </v-row>
        <slide-x-right-transition group>
            <v-row v-if="lastAdded" justify="start" :key="lastAdded.id">
                <v-col cols="9">
                    <p class="headline">Last product added</p>
                    <v-sheet color="grey lighten-3">
                        <v-container>
                            <v-row justify="center">
                                <v-col cols="2">
                                    <v-list-item>
                                        <v-list-item-avatar
                                            tile
                                            size="80"
                                            color="red lighten-2"
                                        />
                                    </v-list-item>
                                </v-col>
                                <v-col cols="9">
                                    <v-list-item three-line>
                                        <v-list-item-content>
                                            <div class="overline mb-1">Category: {{lastAdded.category_name}}</div>
                                            <v-list-item-title class="headline mb-1"> {{lastAdded.name}}
                                            </v-list-item-title>
                                            <div class="overline mb-1">PRICE: {{lastAdded.price}} €</div>
                                            <v-list-item-subtitle>
                                                {{lastAdded.description}}
                                            </v-list-item-subtitle>
                                        </v-list-item-content>

                                    </v-list-item>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-sheet>
                </v-col>
            </v-row>
        </slide-x-right-transition>

        <v-snackbar
            v-model="snackbar"
            :timeout="3000"
            bottom
            right
            color="success"
        >
            Product created correctly
            <v-btn
                text
                @click="snackbar = false"
            >
                Close
            </v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
    export default {
        name: "Product",
        mounted() {
            this.$store.dispatch('listDomains')
            let lsLastAdded = JSON.parse(this.$ls.get('lastAdded', null));
            if (lsLastAdded) {
                this.lastAdded = lsLastAdded;
            }
        },
        data: () => ({
            product: {
                name: 'Neutrogena formula mejorada vegetal 100%',
                price: 24.953,
                img: '/image/to/somewhere',
                amazon_url: 'http://amazon.com/something',
                description: 'Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Cras ultricies ligula sed magna dictum porta. Nulla quis lorem ut libero malesuada feugiat. Sed porttitor lectus nibh. Nulla quis lorem ut libero malesuada feugiat. Vivamus suscipit tortor eget felis porttitor volutpat'
            },
            domainSelected: '',
            categorySelected: '',
            valid: false,
            snackbar: false,
            rules: {
                required: value => !!value || 'Required.',
                urlMatch: (value) => {
                    const pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                    return pattern.test(value) || 'Invalid url.'
                },
            },
            lastAdded: false
        }),
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
                if (this.$refs.form2.validate()) {
                    this.product['category_name'] = this.categorySelected.name;
                    this.product['cat_id'] = this.categorySelected.id;
                    this.product['slug'] = this.encodeSlug(this.product.name);

                    this.$store.dispatch('createProduct', this.formatProductsAttributes(this.product)).then(res => {
                        this.$store.dispatch('loadTree', this.domainSelected.id);
                        this.snackbar = true;
                        this.$refs.form2.reset();
                        this.$refs.nextProduct.focus();

                        this.lastAdded = null;
                        setTimeout(() => {
                            this.lastAdded = res;

                        }, 350)

                        this.$ls.set('lastAdded', JSON.stringify(res))
                    })
                }
            },
            formatProductsAttributes(product) {
                let formattedProduct = product;
                formattedProduct.name = product['name'].replace(/(^\w{1})|(\s{1}\w{1})/g, match => match.toUpperCase());
                formattedProduct.price = Number(Math.round(product["price"] + 'e2') + 'e-2');
                logW(JSON.stringify(formattedProduct));
                return formattedProduct;

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
        }
    }
</script>

<style scoped>

    #lastAddedBox {
        min-height: 200px;
        width: 100%;
        padding: 20px;
        border-radius: 5px;
        background-color: lightcoral;
    }
</style>
