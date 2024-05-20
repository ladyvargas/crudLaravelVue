<template>
    <div id="sidebar" class='active'>
        <div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <img src="/images/logo.png" alt="" srcset="">
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                    <li class='sidebar-title'>Menú</li>

                    <router-link to="*" v-slot="{ href,navigate, isActive, isExactActive }" custom>
                        <li class="sidebar-item" :class="[isActive && 'active', isExactActive && '']">
                        <a :href="href" @click="navigate" class='sidebar-link'>
                            <i data-feather="user" width="20"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    </router-link>
                    <li class='sidebar-title'>Opciones</li>
                                                    <!-- link : navigasi : active : non active -->
                    <router-link to="/user" v-slot="{ href,navigate, isActive, isExactActive }" custom>
                                                <!-- add active link class -->
                        <li class="sidebar-item" :class="[isActive && 'active', isExactActive && '']">
                        <a :href="href" @click="navigate" class='sidebar-link'>
                            <i data-feather="user" width="20"></i>
                            <span>Usuarios</span>
                        </a>
                    </li>
                    </router-link>
                    <router-link to="/vehicle" v-slot="{ href,navigate, isActive, isExactActive }" custom>
                        <li class="sidebar-item" :class="[isActive && 'active', isExactActive && '']">
                        <a :href="href" @click="navigate" class='sidebar-link'>
                            <i data-feather="home" width="20"></i>
                            <span>Vehículos</span>
                        </a>
                    </li>
                    </router-link>
                </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>
</template>
