<template>
    <div class="my-3">
        <list-item
                :product="products"
                v-on:itemchanged="$emit('reloadList')"
                />
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