<template>
    <div>
        <div class="row">
            <div class="col-sm-6">
                <img :src="'/storage/'+property.picture" :alt="property.title" width="100%">
            </div>
            <div class="col-sm-6">
                <div class="property-title">
                    <h3>{{ property.title }}</h3>
                </div>
                <div class="property-title">
                    <h4>{{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(property.rent) }}</h4>
                </div>
                <div class="property-description">
                    <p>{{ property.description }}</p>
                </div>
            </div>
        </div>

            <hr>

        <h5 class="title mt-2"><i class="fa fa-map-marker-alt"></i> Endereço</h5>

        <div class="row mt-4">
            <div class="col-sm-6">
                <GmapMap
                    :center="{lat:10, lng:10}"
                    :zoom="20"
                    map-type-id="terrain"
                    style="width: 100%; height: 500px; margin: 0 auto;"
                    ref="mapRef"
                    :options="{
                        zoomControl: true,
                        mapTypeControl: false,
                        scaleControl: false,
                        streetViewControl: false,
                        rotateControl: false,
                        fullscreenControl: false,
                        disableDefaultUi: false
                    }"
                >
                </GmapMap>
            </div>
            <div class="col-sm-6">
                <address>
                    {{ property.address.address }}, {{ property.address.number }} - {{ property.address.district }}<br>
                    {{ property.address.city }}/{{ property.address.state.toUpperCase() }}<br>
                    {{ property.address.zip_code }}
                </address>
            </div>
        </div>
    </div>
</template>

<script>
import { gmapApi } from 'vue2-google-maps';

export default {
    props: {
        property: Object,
    },
    async mounted() {
        this.$refs.mapRef.$mapPromise.then((map) => {
            const position = {
                lat: parseFloat(this.property.latitude),
                lng: parseFloat(this.property.longitude)
            };

            map.panTo(position);

            const marker = new this.google.maps.Marker({
                position,
                map,
                title: this.property.title
            });
        });
    },
    computed: {
        google: gmapApi
    },
}
</script>
