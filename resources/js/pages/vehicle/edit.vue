<template>
    <div class="card">
        <!-- <div class="card-header">
                            <h4 class="card-title">Basic Inputs</h4>
                        </div> -->

        <div class="card-body">
            <div class="row">

                <div class="col-md-12">
                    <form @submit.prevent="UpdateForm()" action="/vehicle" method="PUT">
                        <div class="form-group">
                            <label for="basicInput">Marca</label>
                            <input type="text" class="form-control " id="basicInput" placeholder="Marca"
                                v-model="form.brand" v-bind:class="{ 'is-invalid': erorr.brand }">
                            <div v-if="erorr.brand" class="invalid-feedback">
                                {{ erorr.brand[0]  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Modelo</label>
                            <input type="text" class="form-control" id="helpInputTop" placeholder="Modelo"
                                v-model="form.model" v-bind:class="{ 'is-invalid': erorr.model }">
                            <div v-if="erorr.model" class="invalid-feedback">
                                {{ erorr.model[0]  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Patente</label>
                            <input type="text" class="form-control" id="helpInputTop" placeholder="Patente"
                                v-model="form.license_plate" v-bind:class="{ 'is-invalid': erorr.license_plate }">
                            <div v-if="erorr.license_plate" class="invalid-feedback">
                                {{ erorr.license_plate[0]  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Año</label>
                            <input type="text" class="form-control" id="helpInputTop" placeholder="Año"
                                v-model="form.year" v-bind:class="{ 'is-invalid': erorr.year }">
                            <div v-if="erorr.year" class="invalid-feedback">
                                {{ erorr.year[0]  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Dueño</label>
                            <input type="text" class="form-control" id="helpInputTop" placeholder="Dueño"
                                v-model="form.id_user" v-bind:class="{ 'is-invalid': erorr.id_user }">
                            <div v-if="erorr.id_user" class="invalid-feedback">
                                {{ erorr.id_user[0]  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Precio</label>
                            <input type="text" class="form-control" id="helpInputTop" placeholder="Precio"
                                v-model="form.price" v-bind:class="{ 'is-invalid': erorr.price }">
                            <div v-if="erorr.price" class="invalid-feedback">
                                {{ erorr.price[0]  }}
                            </div>
                        </div>

                        <router-link to="/vehicle" class="btn btn-danger">Regresar</router-link>
                        <button type="submit" class="btn btn-success">Actualizar</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props : ['id'],
        data() {
            return {
                form: {
                },
                option: [],
                erorr: [],
                data: {}
            }
        },
        methods: {
            getData() {
            axios.get('/api/vehicles/' + this.id + '/edit')
                .then(response => {
                    this.form = response.data;
                })
                .catch(error => {
                    console.error('Error fetching vehicle data:', error);
                });
        },
            UpdateForm() {
                this.form.created_at = new Date(this.form.created_at).toISOString().slice(0, 19).replace('T', ' ');
                this.form.updated_at = new Date(this.form.updated_at).toISOString().slice(0, 19).replace('T', ' ');
                axios.put('/api/vehicles/' + this.id, this.form).then((response) => {
                    if (response.data.status) {
                        // console.log(response.data.messege);
                        this.$noty.success(response.data.messege);
                        this.$router.push({
                            name: 'vehicle',
                        });
                    }
                }).catch((erorr) => {
                    // console.log(erorr.response.data.errors);
                    this.erorr = erorr.response.data.errors
                })
            }
        },
        mounted() {
            this.getData();
        },
    }

</script>
