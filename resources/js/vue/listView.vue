<template>
    <div class="my-3">
        <div v-for="(product, index) in products" :key="index">
            <list-item
                :product="product"
                v-on:itemchanged="$emit('reloadList')"
                />
        </div>
    </div>
</template>
<script>
import listItem from './listItem'

export default {
    props: ['products'],
    components: {
        listItem
    }
}
</script>