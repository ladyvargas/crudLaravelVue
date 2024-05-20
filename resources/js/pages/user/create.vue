<template>
    <div class="card">
        <!-- <div class="card-header">
                            <h4 class="card-title">Basic Inputs</h4>
                        </div> -->

        <div class="card-body">
            <div class="row">

                <div class="col-md-12">
                    <form @submit.prevent="StoreForm()" action="/users" method="POST">
                        <div class="form-group">
                            <label for="basicInput">Nombre</label>
                            <input type="text" class="form-control " id="basicInput" placeholder="Nombre"
                                v-model="form.name" v-bind:class="{ 'is-invalid': erorr.name }">
                            <div v-if="erorr.name" class="invalid-feedback">
                                {{ erorr.name[0]  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Apellido</label>
                            <input type="text" class="form-control" id="helpInputTop" placeholder="Apellido"
                                v-model="form.last_name" v-bind:class="{ 'is-invalid': erorr.last_name }">
                            <div v-if="erorr.last_name" class="invalid-feedback">
                                {{ erorr.last_name[0]  }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Correo</label>
                            <input type="text" class="form-control" id="helpInputTop" placeholder="Correo"
                                v-model="form.email" v-bind:class="{ 'is-invalid': erorr.email }">
                            <div v-if="erorr.email" class="invalid-feedback">
                                {{ erorr.email[0]  }}
                            </div>
                        </div>

                        <router-link to="/user" class="btn btn-danger">Regresar</router-link>
                        <button type="submit" class="btn btn-success">Guardar</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
    export default {
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
            getValueOption() {
                axios.post('/api/option/value', this.data).then((response) => {
                    this.option = response.data;
                    console.log(this.option);
                });
            },
            StoreForm() {
                axios.post('/api/users', this.form).then((response) => {
                    if (response.data.status) {
                        // console.log(response.data.messege);
                        this.$noty.success(response.data.messege);
                        this.$router.push({
                            name: 'user',
                        });
                    }
                }).catch((erorr) => {
                    // console.log(erorr.response.data.errors);
                    this.erorr = erorr.response.data.errors
                })
            }
        },
        mounted() {
            this.getValueOption()
        },
    }

</script>
