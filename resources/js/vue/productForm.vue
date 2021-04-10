<template>
    <div class="addItem">
        <input type="text" v-model="product.name" />
        <input type="text" v-model="product.category" />
        <input type="text" v-model="product.description" />
        <input type="text" v-model="product.date_time" />
        <input type="text" v-model="product.created_by" />
        <input @change="imageChange()" type="file" name="image" ref="files" multiple />
        <button @click="addItem()">Add</button>
    </div>
</template>
<script>
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
            images: []
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
        }
    }
}
</script>