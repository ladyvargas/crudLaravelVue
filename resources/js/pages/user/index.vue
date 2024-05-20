<template>
    <div class="card">
        <div class="card-body">
            <!-- button atas -->
            <template>
                <v-toolbar flat>
                    <v-toolbar-title>Lista de usuarios</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" dark class="mb-2">
                        <v-icon left>mdi-file-import</v-icon>
                        <input
                            type="file"
                            @change="subirExcel"
                            class="hidden-input"
                        />
                    </v-btn>
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
            <!-- end button atas -->
            <!-- header -->
            <v-card-title>
                <v-spacer></v-spacer>
                <!-- search engine -->
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
                        <td>{{ item.name }}</td>
                        <td>{{ item.last_name }}</td>
                        <td>{{ item.email }}</td>
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
import readXlsFile from "read-excel-file";
export default {
    data() {
        return {
            headers: [
                {
                    text: "Nombre",
                    value: "name"
                },
                {
                    text: "Apellido",
                    value: "last_name"
                },
                {
                    text: "Correo",
                    value: "email"
                }
            ],
            data: [],
            search: "",
            modelDelete: false
        };
    },
    methods: {
        GetData() {
            axios
                .get("/api/users")
                .then(response => {
                    this.data = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        createRoute() {
            this.$router.push("/user/create");
        },
        editRoute(item) {
            this.$router.push({ name: "edit_user", params: { id: item.id } });
        },
        deleteItem(item) {
            // item = collection or {}
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
                    axios.delete("/api/users/" + item.id).then(response => {
                        const idx = this.data.indexOf(item);
                        this.data.splice(idx, 1);

                        Swal.fire(
                            "Eliminado!",
                            "Se ha eliminado correctamente.",
                            "success"
                        );
                    });
                }
            });
        },
        subirExcel(event) {
            const input = event.target;
            readXlsFile(input.files[0]).then(rows => {
                rows.slice(1).forEach(row => {
                    const newUser = {
                        name: row[0],
                        last_name: row[1],
                        email: row[2]
                    };
                    // Verificar si el usuario ya existe por su correo electrónico
                    axios
                        .get(`/api/users/${newUser.email}/edit`)
                        .then(existingUser => {
                            if (existingUser) {
                                // Si el usuario ya existe, asignar el ID existente al vehículo
                                this.saveVehicle(existingUser.data.id, row);
                            } else {
                                // Si el usuario no existe, crear uno nuevo
                                axios
                                    .post("/api/users", newUser)
                                    .then(response => {
                                        console.log(
                                            "Usuario guardado:",
                                            response.data
                                        );
                                        const userId = response.data.userId; // Obtener el ID del usuario creado
                                        this.saveVehicle(userId, row);
                                    })
                                    .catch(error => {
                                        console.error(
                                            "Error al guardar usuario:",
                                            error
                                        );
                                    });
                            }
                        })
                        .catch(error => {
                            console.error("Error al verificar usuario:", error);
                        });
                });
            });
        },
        saveVehicle(userId, row) {
            const newVehicle = {
                brand: row[3],
                model: row[4],
                license_plate: row[5],
                year: row[6],
                price: row[7],
                id_user: userId // Asignar el ID del usuario al campo id_user del vehículo
            };
            axios
                .post("/api/vehicles", newVehicle)
                .then(response => {
                    console.log("Vehículo guardado:", response.data);
                    // Envío de correo electrónico después de guardar correctamente el vehículo
                    this.enviarCorreo();
                })
                .catch(error => {
                    console.error("Error al guardar vehículo:", error);
                });
        },
        // Método para enviar correo electrónico
        enviarCorreo() {
            axios
                .post("/api/send-email")
                .then(response => {
                    console.log("Correo electrónico enviado:", response.data);
                })
                .catch(error => {
                    console.error("Error al enviar correo electrónico:", error);
                });
        }
    },

    mounted() {
        this.GetData();
    }
};
</script>
