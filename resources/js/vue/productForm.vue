<template>
    <div class="product-form col-md-12 py-4 px-3">
        <h5 class="ml-2">New product</h5>
        <div id="sOne" class="step--one px-5 pb-5 d-block">
            <div class="row">
                <div class="col-md-6 my-2">
                    <label>Product Name:</label>
                    <input type="text" class="form-control" v-model="product.name" placeholder="Enter product name" />
                </div>
                <div class="col-md-6 my-2">
                    <label>Product Category:</label>
                    <select id="slct_category" class="custom-select" v-model="product.category">
                        <option disabled selected>Select category</option>
                        <option value="All">All</option>
                        <option v-for="(category, index) in categories" :key="index" :value="category.category">
                        {{ category.category }}
                        </option>
                    </select>
                </div>
                <div class="col-md-6 my-2">
                    <label>Product Description:</label>
                    <textarea v-model="product.description" class="form-control" placeholder="Enter product description"></textarea>
                </div>
            </div>
            <button class="my-3 float-right next-btn bg-primary" prev="sOne" curr="sOne" next="sTwo">Next >></button>
        </div>
        <div id="sTwo" class="step--two d-none px-5 pb-5">
            <div class="col-md-6 my-2">
                <label>Date and Time</label>
                <input type="datetime-local" class="form-control" v-model="product.date_time" />
            </div>
            <button class="my-3 float-left prev-btn bg-secondary" prev="sOne" curr="sTwo"><< Prev</button>
            <button class="my-3 float-right next-btn bg-primary" curr="sTwo" next="sThree">Next >></button>
        </div>
        <div id="sThree" class="step--three d-none px-5 pb-5">
            <input @change="imageChange()" type="file" name="image" ref="files" multiple />
            <button class="my-3 float-left prev-btn bg-secondary" prev="sTwo" curr="sThree"><< Prev</button>
            <button @click="addItem()" class="next-btn bg-success" curr="sThree" next="sThree">Add</button>
        </div>
        <input type="hidden" v-model="product.created_by" />
    </div>
</template>
<script>
$(document).ready(function(){
    $('.next-btn').click(function(){
        var nxt = $(this).attr('next');
        var curr = $(this).attr('curr');
        $('#' + nxt).removeClass('d-none').addClass('d-block');
        $('#' + curr).removeClass('d-block').addClass('d-none');
    });
    $('.prev-btn').click(function(){
        var prev = $(this).attr('prev');
        var curr = $(this).attr('curr');
        $('#' + prev).removeClass('d-none').addClass('d-block');
        $('#' + curr).removeClass('d-block').addClass('d-none');
    });
});
export default {
    data: function () {
        return {
            product: {
                name: "",
                category: "",
                description: "",
                date_time: "",
                created_by: ""
            },
            images: [],
            categories: []
        }
    },
    methods: {
        addItem() {
            if (this.product.name == '') {
                return;
            }

            var self = this;
            let formData = new FormData();

            for (let i = 0; i < this.images.length; i++) {

                let file = self.images[i];
                formData.append('files[' + i + ']', file);
            }
            console.log(formData);
            const config = {
                headers: {
                    "content-type" : "multipart/form-data"
                }
            }

            axios.post('api/product/store', {
                product: this.product
            })
            .then( response => {
                axios.post('api/images/', formData, config)
                .then(response => {
                    if (response.status == 200) {
                        self.$refs.files.value = '';
                        self.images = [];
                        window.location.href = 'http://localhost:8000/products';
                    }
                })
                .catch(error => {
                    console.log(error);
                })
            })
            .catch(error => {
                console.log(error);
            });
        },
        imageChange () {
            var arr = this.$refs.files.files.length
            for (let i = 0; i < arr; i++) {
                this.images.push(this.$refs.files.files[i]);
                console.log(this.images);
            }
        },
        getCategories() {
            axios.get('api/categories')
            .then(response => {
                this.categories = response.data
            })
            .catch(error => {
                console.log(error);
            });
        }
    },
    created() {
        this.getCategories();
    }
}
</script>
<style scoped>
.product-form{
    background-color: #ffffff;
}
label {
    font-size: 14px;
}
input, select, textarea {
    width: 75%;
    display: block;
}
.next-btn, .prev-btn {
    border: 0;
    outline: none;
    padding: 5px 15px;
    border-radius: .25rem;
}
</style>