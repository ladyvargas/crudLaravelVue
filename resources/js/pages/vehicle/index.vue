<template>
    <div class="card">
        <div class="card-body">
            <!-- button atas -->
            <template>
                <v-toolbar flat>
                    <v-toolbar-title>Lista de vehículos</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        @click.prevent="createRoute()"
                        dark
                        class="mb-2"
                    >
                        Crear
                    </v-btn>
                </v-toolbar>
            </template>
            <v-card-title>
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Buscar"
                    single-line
                    hide-details
                >
                </v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="data"
                :search="search"
                :items-per-page="10"
                class="elevation-2"
            >
                <template v-slot:item="{ item }">
                    <tr>
                        <td>{{ item.id }}</td>
                        <td>{{ item.brand }}</td>
                        <td>{{ item.model }}</td>
                        <td>{{ item.license_plate }}</td>
                        <td>{{ item.year }}</td>
                        <td>{{ userNameMap[item.id_user] }}</td>
                        <td>{{ item.price }}</td>
                        <td>
                            <v-icon @click="editRoute(item)">mdi-pencil</v-icon>
                            <v-icon color="error" @click="deleteItem(item)"
                                >mdi-delete</v-icon
                            >
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            headers: [
                {
                    text: "id", // nama header
                    value: "id" //  value dari database
                },
                {
                    text: "Marca",
                    value: "brand"
                },
                {
                    text: "Modelo",
                    value: "model" // action dari v-slot:item.action
                },
                {
                    text: "Patente",
                    value: "license_plate"
                },
                {
                    text: "Año",
                    value: "year"
                },
                {
                    text: "Dueño",
                    value: "id_user"
                },
                {
                    text: "Precio",
                    value: "price"
                }
            ],
            data: [], // isi data yang ada du databse
            search: "",
            modelDelete: false,
            userNameMap: {},
        };
    },
    methods: {
        GetData() {
            axios
                .get("/api/vehicles")
                .then(response => {
                    this.data = response.data;
                })
                .catch(eror => {
                    console.log(eror);
                });
        },
        async loadUserNames() {
            try {
                const response = await axios.get("/api/users");
                this.userNameMap = response.data.reduce((acc, user) => {
                    acc[user.id] = user.name;
                    return acc;
                }, {});
            } catch (error) {
                console.error("Error al cargar los nombres de usuario:", error);
            }
        },
        createRoute() {
            this.$router.push("/vehicle/create");
        },
        editRoute(item) {
            this.$router.push({
                name: "edit_vehicle",
                params: { id: item.id }
            });
        },
        deleteItem(item) {
            console.log(item.id);
            Swal.fire({
                title: "¿Está seguro que desea eliminar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si",
                cancelButtonText: "No"
            }).then(result => {
                if (result.isConfirmed) {
                    axios.delete("/api/vehicles/" + item.id).then(response => {
                        const idx = this.data.indexOf(item);
                        this.data.splice(idx, 1);
                        // alert
                        Swal.fire(
                            "Eliminado!",
                            "Se ha eliminado correctamente.",
                            "success"
                        );
                    });
                }
            });
        },
        editItem(item) {
            this.$router.push("/vehicle/" + item.id);
        }
    },

    mounted() {
        this.GetData();
        this.loadUserNames();
    }
};
</script>
