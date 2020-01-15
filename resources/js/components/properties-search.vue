<template>
    <div>
        <div class="row">
            <div class="col-sm-10">
                <label for="search">Endereço</label>
                <input type="search" id="search" v-model="search" class="form-control" placeholder="Pesquise por um endereço e pressione enter..." @change="onSearchChange" :disabled="isSearching">
                <small><i>Você pode arrastar o marcador vermelho.</i></small>
            </div>
            <div class="col-sm-2">
                <label for="distance">Raio de busca</label>
                <div class="input-group mb-4">
                    <input type="number" id="distance" v-model="distance" class="form-control" aria-label="Distancia" @change="onSearchChange" :disabled="isSearching">
                    <div class="input-group-append">
                        <span class="input-group-text">km</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-6">
                <GmapMap
                    :center="{ lat: -23.5489, lng: -46.6388 }"
                    :zoom="16"
                    map-type-id="terrain"
                    style="width: 100%; height: 500px;"
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
                <properties-inline-list v-bind:routes="routes" v-bind:properties="result" column="col-sm-4"></properties-inline-list>
                <div class="text-center" v-if="madeFirstSearch && result.length === 0">Nenhum resultado na região escolhida.</div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { gmapApi } from 'vue2-google-maps';
import { getCsrfToken, getFirstPositionFromGoogleMapsResults } from '../utils';

export default {
    props: {
        routes: Object,
    },
    data() {
        return {
            search: null,
            distance: 80,
            madeFirstSearch: false,
            isSearching: false,
            searchResultMarkers: [],
            currMarker: null,
            result: [],
        }
    },
    methods: {
        async onSearchChange() {
            const geocoder = new this.google.maps.Geocoder();
            const address = this.search;

            geocoder.geocode({ address }, async (results, status) => {
                if (status == this.google.maps.GeocoderStatus.OK && results.length) {
                    const position = getFirstPositionFromGoogleMapsResults(results);

                    this.$refs.mapRef.$mapPromise.then(async (map) => {
                        map.panTo(position);

                        // Removes the current marker
                        if (this.currMarker) this.currMarker.setMap(null);

                        // Adds a marker to the position
                        const marker = new this.google.maps.Marker({
                            position,
                            map: map,
                            title: 'Localização',
                            draggable: true,
                        });

                        this.currMarker = marker;

                        const result = await this.searchByLatLng(position);
                        await this.clearMapMarkers(map);

                        if (result.length) {
                            await this.showResultOnMap(marker, map, result);
                        }

                        if (!this.madeFirstSearch) this.madeFirstSearch = true;

                        this.google.maps.event.addListener(marker, 'dragend', async ({ latLng }) => {
                            await this.clearMapMarkers(map);

                            const dragResult = await this.searchByLatLng({ lat: latLng.lat(), lng: latLng.lng() });

                            if (dragResult.length) {
                                await this.showResultOnMap(marker, map, dragResult);
                            }
                        });
                    });
                }
            });
        },
        async clearMapMarkers(map) {
            this.searchResultMarkers.forEach(_marker => _marker.setMap(null));
            this.searchResultMarkers = [];
        },
        async searchByLatLng({ lat, lng }) {
            this.isSearching = true;

            const url = this.routes.properties.search;
            const headers = {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            };
            const data = { latitude: lat, longitude: lng, distance: this.distance };

            try {
                const res = await axios.post(url, data, { headers });
                this.result = res.data.result;

                return this.result;
            } catch (err) {
                console.log(err);

                return false;
            } finally {
                this.isSearching = false;
            }
        },
        async showResultOnMap(mainMarker, map, result) {
            const bounds = new this.google.maps.LatLngBounds();
            bounds.extend(mainMarker.getPosition());

            result.forEach((property) => {
                let _marker = new this.google.maps.Marker({
                    position: {
                        lat: parseFloat(property.latitude),
                        lng: parseFloat(property.longitude)
                    },
                    icon: {
                        url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
                    },
                    map: map,
                    title: property.title,
                });

                _marker.addListener('click', () => {
                    window.open(this.routes.properties.read.replace('PROPERTY_ID', property.id), '_blank');
                });

                bounds.extend(_marker.getPosition());

                this.searchResultMarkers.push(_marker);
            });

            map.fitBounds(bounds);
        }
    },
    mounted() {
        this.$refs.mapRef.$mapPromise.then(async (map) => {
            const success = (pos) => {
                const { latitude, longitude } = pos.coords;
                const position = { lat: latitude, lng: longitude };

                map.setCenter(position);
            };
            const options = {
                enableHighAccuracy: true,
                maximumAge: 0
            }

            navigator.geolocation.getCurrentPosition(success, () => {}, options);
        });
    },
    computed: {
        google: gmapApi
    }
}
</script>
