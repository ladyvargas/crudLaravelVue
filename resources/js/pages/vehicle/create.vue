<template>
    <div class="card">
        <!-- Resto de tu código -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form
                        @submit.prevent="storeForm"
                        action="/vehicle"
                        method="POST"
                    >
                        <div class="form-group">
                            <label for="basicInput">Marca</label>
                            <input
                                type="text"
                                class="form-control "
                                id="basicInput"
                                placeholder="Marca"
                                v-model="form.brand"
                                v-bind:class="{ 'is-invalid': errors && errors.brand }"
                            />
                            <div v-if="errors && errors.brand" class="invalid-feedback">
                                {{ errors.brand[0] }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Modelo</label>
                            <input
                                type="text"
                                class="form-control"
                                id="helpInputTop"
                                placeholder="Modelo"
                                v-model="form.model"
                                v-bind:class="{ 'is-invalid': errors && errors.model }"
                            />
                            <div v-if="errors && errors.model" class="invalid-feedback">
                                {{ errors.model[0] }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Patente</label>
                            <input
                                type="text"
                                class="form-control"
                                id="helpInputTop"
                                placeholder="Patente"
                                v-model="form.license_plate"
                                v-bind:class="{ 'is-invalid': errors && errors.license_plate }"
                            />
                            <div v-if="errors && errors.license_plate" class="invalid-feedback">
                                {{ errors.license_plate[0] }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Año</label>
                            <input
                                type="text"
                                class="form-control"
                                id="helpInputTop"
                                placeholder="Año"
                                v-model="form.year"
                                v-bind:class="{ 'is-invalid': errors && errors.year }"
                            />
                            <div v-if="errors && errors.year" class="invalid-feedback">
                                {{ errors.year[0] }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Precio</label>
                            <input
                                type="text"
                                class="form-control"
                                id="helpInputTop"
                                placeholder="Precio"
                                v-model="form.price"
                                v-bind:class="{ 'is-invalid': errors && errors.price }"
                            />
                            <div v-if="errors && errors.price" class="invalid-feedback">
                                {{ errors.price[0] }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Dueño</label>
                            <select
                                class="form-control"
                                v-model="form.id_user"
                                v-bind:class="{
                                    'is-invalid': errors && errors.id_user
                                }"
                            >
                                <option value="">Seleccionar dueño</option>
                                <option
                                    v-for="user in users"
                                    :key="user.id"
                                    :value="user.id"
                                    >{{ user.name }}</option
                                >
                            </select>
                            <div
                                v-if="errors && errors.id_user"
                                class="invalid-feedback"
                            >
                                {{ errors.id_user[0] }}
                            </div>
                        </div>

                        <router-link to="/vehicle" class="btn btn-danger">Regresar</router-link>
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
            form: {},
            errors: null,
            users: []
        };
    },
    methods: {
        storeForm() {
            axios
                .post("/api/vehicles", this.form)
                .then(response => {
                    if (response.data.status) {
                        this.$noty.success(response.data.messege);
                        this.$router.push({ name: "vehicle" });
                    }
                })
                .catch(error => {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error("Error storing form:", error);
                    }
                });
        },
        getData() {
            axios
                .get("/api/users")
                .then(response => {
                    this.users = response.data;
                })
                .catch(error => {
                    console.error("Error fetching user data:", error);
                });
        }
    },
    mounted() {
        this.getData();
    }
};
</script>
