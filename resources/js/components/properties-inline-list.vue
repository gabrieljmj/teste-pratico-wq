<template>
<div v-if="properties.length" class="row">
    <div v-for="property in properties" v-bind:key="property.id" :class="column || 'col-sm-3'">
        <div class="card">
            <img class="card-img-top" :src="'/storage/'+property.picture" :alt="property.title">
            <div class="card-body">
                <h5 class="card-title"><a class="card-link" :href="routes.properties.read.replace('PROPERTY_ID', property.id)">{{ property.title }}</a></h5>
                <p class="card-text">{{ property.description }}</p>
                <p class="card-text"><big class="text-muted">{{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(property.rent) }}</big></p>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
        routes: Object,
        properties: Array,
        column: String,
    }
}
</script>
