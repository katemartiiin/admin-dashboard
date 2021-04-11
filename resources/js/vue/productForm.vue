<template>
    <div class="product-form col-md-12 py-4 px-3">
        <h5 class="ml-2">New product</h5>
        <div id="sOne" class="step--one px-5 pb-5 d-block mt-4">
            <div class="row">
                <div class="col-md-6 my-2">
                    <label id="lbl-product_name">Product Name:</label>
                    <input type="text" id="product_name" class="form-control" v-model="product.name" placeholder="Enter product name" />
                </div>
                <div class="col-md-6 my-2">
                    <label id="lbl-slct_category">Product Category:</label>
                    <select id="slct_category" class="custom-select" v-model="product.category">
                        <option disabled selected>Select category</option>
                        <option value="All">All</option>
                        <option v-for="(category, index) in categories" :key="index" :value="category.category">
                        {{ category.category }}
                        </option>
                    </select>
                </div>
                <div class="col-md-6 my-2">
                    <label id="lbl-product_description">Product Description:</label>
                    <textarea v-model="product.description" id="product_description" class="form-control" placeholder="Enter product description"></textarea>
                </div>
            </div>
            <button id="next-1" class="my-3 float-right next-btn bg-primary" prev="sOne" curr="sOne" next="sTwo">Next >></button>
        </div>
        <div id="sTwo" class="step--two d-none px-5 pb-5 mt-4">
            <label id="lbl-product_image">Upload image/s:</label>
            <input id="product_image" @change="imageChange()" type="file" name="image" ref="files" class="my-5" multiple />
            <button class="my-3 float-left prev-btn bg-secondary" prev="sOne" curr="sTwo"><< Prev</button>
            <button id="next-2" class="my-3 float-right next-btn bg-primary" curr="sTwo" next="sThree">Next >></button>
        </div>
        <div id="sThree" class="step--three d-none px-5 pb-5 mt-4">
            <div class="col-md-6 my-5">
                <label id="lbl-date_time">Date and Time</label>
                <input id="date_time" type="datetime-local" class="form-control" v-model="product.date_time" />
            </div>
            <button class="my-3 float-left prev-btn bg-secondary" prev="sTwo" curr="sThree"><< Prev</button>
            <button @click="addItem()" class="next-btn bg-success float-right" id="next-3">Add</button>
        </div>
    </div>
</template>
<script>
$(document).ready(function(){
    $('#product_name, #slct_category, #product_description, #date_time').change(function(){
        var getId = $(this).attr('id');
        $('#lbl-'+ getId).removeClass('text-danger');
    });
    $('#next-1').click(function() {
        var arr = ['product_name', 'slct_category', 'product_description'];
        if (jQuery.inArray('true', validateForm(arr)) == -1){
            nextClick($(this).attr('next'), $(this).attr('curr'));
        }
    });
    $('#next-2').click(function() {
        if ($('#product_image').val()){
            nextClick($(this).attr('next'), $(this).attr('curr'));
        } else {
            $('#lbl-product_image').addClass('text-danger');
        }
    });
    function nextClick(next, curr){
        $('#' + next).removeClass('d-none').addClass('d-block');
        $('#' + curr).removeClass('d-block').addClass('d-none');
    }
    $('.prev-btn').click(function(){
        var prev = $(this).attr('prev');
        var curr = $(this).attr('curr');
        $('#' + prev).removeClass('d-none').addClass('d-block');
        $('#' + curr).removeClass('d-block').addClass('d-none');
    });

    function validateForm(arr){
        var empty_fields = [];
        $.each(arr, function(i, val){
            if ($('#' + val).val() == '' || $('#' + val).val() == undefined){
                empty_fields.push('true');
                console.log($('#' + val).val());
                $('#lbl-' + val).addClass('text-danger');
                // return false;
            } else {
                empty_fields.push('false');
                console.log($('#' + val).val());
                $('#lbl-' + val).removeClass('text-danger');
            }
        });
        return empty_fields;
    }
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

            let created_by = document.getElementById('created_by').value;
            if (document.getElementById('date_time').value != ""){
                axios.post('api/product/store', {
                    product: {
                        name: this.product.name,
                        category: this.product.category,
                        description: this.product.description,
                        date_time: this.product.date_time,
                        created_by: created_by
                    }
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
            } else {
                document.getElementById('lbl-date_time').classList.add('text-danger');
            }
        },
        imageChange () {
            var arr = this.$refs.files.files.length
            for (let i = 0; i < arr; i++) {
                this.images.push(this.$refs.files.files[i]);
                console.log(this.images);
            }
            document.getElementById('lbl-product_image').classList.remove('text-danger');
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