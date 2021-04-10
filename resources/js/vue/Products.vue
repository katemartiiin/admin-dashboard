<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <select id="slct_category" class="custom-select" @change="productCategory()">
                    <option value="All">All</option>
                    <option v-for="(category, index) in categories" :key="index" :value="category.category">
                    {{ category.category }}
                    </option>
                </select>
                <input type="text" id="keyword" class="form-control mt-3" placeholder="Name or description" />
                <button @click="searchKeyword()">Search</button>
                
                <paginate
                    name="products"
                    :list="products"
                    :per="3"
                    >
                    <li v-for="product in paginated('products')">
                        <list-view 
                        :products="product" 
                        v-on:reloadList="getProducts()"
                        />
                    </li>
                </paginate>
                <paginate-links for="products" :show-step-links="true" class="d-flex"></paginate-links>
            </div>
        </div>
    </div>
</template>
<script>
import listView from './listView'
export default {
    components: {
        listView
    },
    data: function () {
        return {
            products: [],
            categories: [],
            paginate: ['products']
        }
    },
    methods: {
        getProducts() {
            axios.get('api/products')
            .then(response => {
                this.products = response.data
            })
            .catch(error => {
                console.log(error);
            })
        },
        getCategories() {
            axios.get('api/categories')
            .then(response => {
                this.categories = response.data
            })
            .catch(error => {
                console.log(error);
            });
        },
        productCategory() {
            var category = document.getElementById('slct_category').value;
            axios.get('api/category/' + category)
            .then(response => {
                this.products = response.data
            })
            .catch(error => {
                console.log(error);
            })
        },
        searchKeyword() {
            var keyword = document.getElementById('keyword').value;
            if (keyword != ''){
                axios.get('api/search/' + keyword)
                .then(response => {
                    this.products = response.data
                })
                .catch(error => {
                    console.log(error);
                })
            } else {
                axios.get('api/search/all')
                .then(response => {
                    this.products = response.data
                })
                .catch(error => {
                    console.log(error);
                })
            }
        }
    },
    created() {
        this.getProducts();
        this.getCategories();
    }
}
</script>
<style scoped>
ul, li {
    list-style: none !important;
    padding-inline-start: 0 !important;
}
</style>
<style>
ul.paginate-links > li.disabled > a {
    color: red;
}
ul.paginate-links > li.number > a {
    color: blue;
}
ul.paginate-links > li.number {
    margin-left: 5px;
    margin-right: 5px;
}
ul.paginate-links > li.number:hover, .left-arrow:hover, .right-arrow:hover{
    cursor: pointer;
}
ul.paginate-links > li.number.active > a {
    color: black !important;
}
</style>