<template>
    <div>
        <table class="table" v-if="properties.length">
            <thead>
                <th>Título</th>
                <th>Aluguel</th>
                <th>Ações</th>
            </thead>
            <tbody>
                <tr v-for="property in properties" v-bind:key="property.id">
                    <td><a :href="routes.properties.read.replace('PROPERTY_ID', property.id)">{{ property.title }}</a></td>
                    <td>{{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(property.rent) }}</td>
                    <td>
                        <a :href="routes.properties.edit.replace('PROPERTY_ID', property.id)" class="btn btn-primary" title="Editar"><i class="fa fa-pencil-alt"></i></a>
                        <button class="btn btn-danger" title="Deletar" @click="openDeleteModal(property)"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div v-if="showModal">
            <transition name="modal">
                <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Deletar imóvel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" @click="showModal = false;">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <p>Deseja mesmo deletar o imóvel <strong>{{ propertyToDelete.title }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="showModal = false">Não</button>
                        <button type="button" class="btn btn-primary" @click="onDeleteClick(); showModal = false;">Sim</button>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
import { getDataFromInput, getCsrfToken } from '../utils';
import axios from 'axios';

export default {
    props: {
        routes: Object,
        propertiesdata: String,
    },
    data() {
        return {
            propertyToDelete: null,
            showModal: false,
            properties: JSON.parse(this.propertiesdata),
        }
    },
    methods: {
        async openDeleteModal(property) {
            this.propertyToDelete = property;
            this.showModal = true;
        },
        async onDeleteClick() {
            const url = this.routes.properties.delete.replace('PROPERTY_ID', this.propertyToDelete.id);
            const headers = {
                'X-CSRF-TOKEN': getCsrfToken(),
            };
            const data = { _method: 'DELETE' };

            try {
                const res = await axios.post(url, data, { headers });
                this.deletePropertyById(this.propertyToDelete.id);
            } catch (err) {
                console.log(err);
            }
        },
        async deletePropertyById(id) {
            this.properties.forEach((property, i) => {
                if (property.id === id) {
                    this.properties.splice(i, 1);
                }
            });
        }
    },
}
</script>
