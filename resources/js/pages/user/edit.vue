<template>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form @submit.prevent="updateForm" action="/users" method="Update">
                        <div class="form-group">
                            <label for="basicInput">Nombre</label>
                            <input type="text" class="form-control" id="basicInput" placeholder="Nombre"
                                v-model="form.name" :class="{ 'is-invalid': errors.name }">
                            <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Apellido</label>
                            <input type="text" class="form-control" id="helpInputTop" placeholder="Apellido"
                                v-model="form.last_name" :class="{ 'is-invalid': errors.last_name }">
                            <div v-if="errors.last_name" class="invalid-feedback">{{ errors.last_name[0] }}</div>
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Correo</label>
                            <input type="text" class="form-control" id="helpInputTop" placeholder="Correo"
                                v-model="form.email" :class="{ 'is-invalid': errors.email }">
                            <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
                        </div>

                        <router-link to="/user" class="btn btn-danger">Regresar</router-link>
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['id'],
    data() {
        return {
            form: {
                name: '',
                last_name: '',
                email: ''
            },
            errors: {}
        };
    },
    methods: {
        getData() {
            axios.get(`/api/users/${this.id}/edit`)
                .then(response => {
                    this.form = response.data; // Asigna directamente los datos a this.form
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);
                });
        },
        updateForm() {
            this.form.created_at = new Date(this.form.created_at).toISOString().slice(0, 19).replace('T', ' ');
            this.form.updated_at = new Date(this.form.updated_at).toISOString().slice(0, 19).replace('T', ' ');
            axios.put(`/api/users/${this.id}`, this.form)
                .then(response => {
                    if (response.data.status) {
                        this.$noty.success(response.data.messege);
                        this.$router.push({
                            name: 'user',
                        });
                    }
                })
                .catch(error => {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error('Error updating user:', error);
                    }
                });
        }
    },
    mounted() {
        this.getData();
    }
};
</script>
