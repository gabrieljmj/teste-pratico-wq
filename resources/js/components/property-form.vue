<template>
    <div class="row">
        <div class="col-sm-12">
            <form @submit="submitForm">
                <div class="form-row">
                    <div class="col-sm-12">
                        <label for="title">Título</label>
                        <input type="text" id="title" name="property[title]" v-bind:class="{ 'form-control': true, 'is-invalid': formErrors['property.title'] }" v-model="property.title" >
                        <div class="invalid-feedback" v-if="formErrors['property.title']">
                            {{ formErrors['property.title'][0] }}
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-sm-8">
                        <label for="picture">Foto</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="picture" name="property[picture]">
                            <label class="custom-file-label" for="picture">Choose file</label>
                            <div class="invalid-feedback" v-if="formErrors['property.picture']">
                                {{ formErrors['property.picture'][0] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="rent">Aluguel</label>
                        <money type="text" v-bind="money" id="rent" name="property[rent]" v-bind:class="{ 'form-control': true, 'is-invalid': formErrors['property.rent'] }" v-model="property.rent" />
                        <div class="invalid-feedback" v-if="formErrors['property.rent']">
                            {{ formErrors['property.rent'][0] }}
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-sm-12">
                        <label for="description">Descrição</label>
                        <textarea id="description" name="property[description]" v-bind:class="{ 'form-control': true, 'is-invalid': formErrors['property.description'] }" v-model="property.description" ></textarea>
                        <div class="invalid-feedback" v-if="formErrors['property.description']">
                            {{ formErrors['property.description'][0] }}
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-sm-4">
                        <label for="zip_code">CEP</label>
                        <input type="text" v-mask="'#####-###'" id="zip_code" name="address[zip_code]" v-bind:class="{ 'form-control': true, 'is-invalid': formErrors['address.zip_code'] }" @change="onAddressChange(); onZipCodeChange()" v-model="property.address.zip_code" :disabled="isSearchingZipCodeInformation">
                        <div class="invalid-feedback" v-if="formErrors['address.zip_code']">
                            {{ formErrors['address.zip_code'][0] }}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="address">Rua</label>
                        <input type="text" id="address" name="address[address]" v-bind:class="{ 'form-control': true, 'is-invalid': formErrors['address.address'] }" @change="onAddressChange" v-model="property.address.address"  :disabled="isSearchingZipCodeInformation">
                        <div class="invalid-feedback" v-if="formErrors['address.address']">
                            {{ formErrors['address.address'][0] }}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="number">Número</label>
                        <input type="text" id="number" name="address[number]" v-bind:class="{ 'form-control': true, 'is-invalid': formErrors['address.number'] }" @change="onAddressChange" v-model="property.address.number"  :disabled="isSearchingZipCodeInformation">
                        <div class="invalid-feedback" v-if="formErrors['address.number']">
                            {{ formErrors['address.number'][0] }}
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-sm-4">
                        <label for="district">Bairro</label>
                        <input type="text" id="district" name="address[district]" v-bind:class="{ 'form-control': true, 'is-invalid': formErrors['address.district'] }" @change="onAddressChange" v-model="property.address.district"  :disabled="isSearchingZipCodeInformation">
                        <div class="invalid-feedback" v-if="formErrors['address.district']">
                            {{ formErrors['address.district'][0] }}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="city">Cidade</label>
                        <input type="text" id="city" name="address[city]" v-bind:class="{ 'form-control': true, 'is-invalid': formErrors['address.city'] }" @change="onAddressChange" v-model="property.address.city"  :disabled="isSearchingZipCodeInformation">
                        <div class="invalid-feedback" v-if="formErrors['address.city']">
                            {{ formErrors['address.city'][0] }}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="state">Estado</label>
                        <input type="text" id="state" name="address[state]" v-bind:class="{ 'form-control': true, 'is-invalid': formErrors['address.state'] }" @change="onAddressChange" v-model="property.address.state"  :disabled="isSearchingZipCodeInformation">
                        <div class="invalid-feedback" v-if="formErrors['address.state']">
                            {{ formErrors['address.state'][0] }}
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-sm-12 text-center">
                        <small><i class="fa fa-map-marker-alt"></i> <i>Preencha todos os campos do endereço para carregar a localização no mapa.</i></small>
                        <GmapMap
                            :center="{ lat: -23.5489, lng: -46.6388 }"
                            :zoom="16"
                            map-type-id="terrain"
                            style="width: 50%; height: 500px; margin: 0 auto;"
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
                </div>

                <input type="hidden" id="latitude" name="property[latitude]" v-model="property.latitude">
                <input type="hidden" id="longitude" name="property[longitude]" v-model="property.longitude">

                <div class="form-row mt-2">
                    <div class="col-sm-12 text-right">
                        <button class="btn btn-success" type="submit" :disabled="isSendingForm">
                            <i class="fa fa-circle-notch fa-spin" v-if="isSendingForm"></i> Cadastrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Money } from 'v-money'
import { gmapApi } from 'vue2-google-maps';

import { getDataFromInput, allPropertiesNotNull, getCsrfToken, getFirstPositionFromGoogleMapsResults } from '../utils';
import searchZipCodeInformation from '../services/search-zip-code-information';

import axios from 'axios';

export default {
    components: {
        Money
    },
    props: {
        routes: Object,
        action: String,
        propertydata: String,
    },
    data() {
        return {
            isSearchingZipCodeInformation: false,
            isSendingForm: false,
            formErrors: {},
            currMarker: null,
            csrfToken: getCsrfToken(),
            property: JSON.parse(this.propertydata),
            money: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                precision: 2,
                masked: false /* doesn't work with directive */
            }
        }
    },
    methods: {
        async onAddressChange() {
            const propertyAddress = this.property.address;

            if (allPropertiesNotNull(propertyAddress, ['address', 'number', 'district', 'city', 'state'])) {
                const geocoder = new this.google.maps.Geocoder();
                const address = `${propertyAddress.address}, ${propertyAddress.number}, ${propertyAddress.district}, ${propertyAddress.city} - ${propertyAddress.state}`;

                geocoder.geocode({ address }, (results, status) => {
                    if (status == this.google.maps.GeocoderStatus.OK && results.length) {
                        const position = getFirstPositionFromGoogleMapsResults(results);

                        this.setFormPosition(position)

                        this.$refs.mapRef.$mapPromise.then((map) => {
                            map.panTo(position);

                            // Removes the current marker
                            if (this.currMarker) this.currMarker.setMap(null);

                            // Adds a marker to the position
                            this.setMarker(position, map, 'Localização', { draggable: true });
                        });
                    }
                });
            }
        },
        async onZipCodeChange() {
            const { zip_code } = this.property.address;

            this.isSearchingZipCodeInformation = true;
            const data = await searchZipCodeInformation(zip_code.replace('-', ''));
            this.isSearchingZipCodeInformation = false;

            if (data) {
                const { logradouro, bairro, localidade, uf } = data.data;

                this.property.address.address = logradouro;
                this.property.address.district = bairro;
                this.property.address.city = localidade;
                this.property.address.state = uf;
            }
        },
        async submitForm(e) {
            this.isSendingForm = true;
            this.formErrors = {};

            e.preventDefault();

            if (!this.validateForm()) {
                this.isSendingForm = false;
                window.scrollTo(0, 0);
                return false;
            }

            const url = this.action === 'create'
                ? this.routes.properties.create
                : this.routes.properties.update.replace('PROPERTY_ID', this.property.id);
            const formData = new FormData(e.target);
            formData.append('property[rent]', this.property.rent);

            if (this.action === 'update') {
                formData.append('_method', 'PUT');
            }

            try {
                const res = await axios.post(url, formData)

                if (!res.data.errors) {
                    window.location.href = this.routes.properties.read.replace('PROPERTY_ID', res.data.property_id);
                }
            } catch (err) {
                if (err.response.status === 422) {
                    this.formErrors = err.response.data.errors;
                    window.scrollTo(0, 0);
                }

                console.log(this.formErrors)
            }

            this.isSendingForm = false;
        },
        async setMarker(position, map, title, options) {
            const marker = new this.google.maps.Marker({
                position,
                map,
                title,
                ...options
            });

            this.currMarker = marker;

            this.google.maps.event.addListener(marker, 'dragend', ({ latLng }) =>
                this.setFormPosition({ lat: latLng.lat(), lng: latLng.lng() })
            );
        },
        setFormPosition({ lat, lng }) {
            this.property.latitude = lat;
            this.property.longitude = lng;
        },
        validateForm() {
            this.formErrors = {};

            const rules = {
                required(value) {
                    return null !== value && value !== '';
                },
                min(value, ref) {
                    return value >= ref;
                },
            };

            if (!rules.required(this.property.title)) {
                this.formErrors['property.title'] = ['É necessário informar o título do imóvel.'];
            }

            if (!rules.required(this.property.description)) {
                this.formErrors['property.description'] = ['É necessário informar a descrição do imóvel.'];
            }

            if (!rules.required(this.property.rent)) {
                this.formErrors['property.rent'] = ['É necessário informar o valor do aluguel do imóvel.'];
            }

            if (!rules.min(this.property.rent, 0.01)) {
                this.formErrors['property.rent'] = ['O valor do aluguel deve ser maior que R$ 0,01.'];
            }

            if (!rules.required(this.property.address.zip_code)) {
                this.formErrors['address.zip_code'] = ['É necessário informar o CEP do imóvel.'];
            }

            if (!rules.required(this.property.address.address)) {
                this.formErrors['address.address'] = ['É necessário informar a rua do imóvel.'];
            }

            if (!rules.required(this.property.address.number)) {
                this.formErrors['address.number'] = ['É necessário informar o número do imóvel.'];
            }

            if (!rules.required(this.property.address.district)) {
                this.formErrors['address.district'] = ['É necessário informar o bairro do imóvel.'];
            }

            if (!rules.required(this.property.address.city)) {
                this.formErrors['address.city'] = ['É necessário informar a cidade do imóvel.'];
            }

            if (!rules.required(this.property.address.state)) {
                this.formErrors['address.state'] = ['É necessário informar o estado do imóvel.'];
            }

            if (Object.keys(this.formErrors).length !== 0) {
                return false;
            }

            return true;
        }
    },
    async mounted() {
        if (this.action === 'update') {
            this.$refs.mapRef.$mapPromise.then((map) => {
                const position = {
                    lat: parseFloat(this.property.latitude),
                    lng: parseFloat(this.property.longitude)
                };

                map.panTo(position);

                this.setMarker(position, map, 'Localização', { draggable: true });
            });
        }
    },
    computed: {
        google: gmapApi,
    },
}
</script>
