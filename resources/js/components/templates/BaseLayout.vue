<template>
    <div>
        <div class="container">
            
            <b-navbar class="pt-4">
                <template #brand>
                    <b-navbar-item href="/">
                        <slot name="logo"></slot>
                    </b-navbar-item>
                </template>

                <template #start>
                    <b-navbar-item href="#">
                        Home
                    </b-navbar-item>
                    <b-navbar-item href="#">
                        Documentation
                    </b-navbar-item>
                    <b-navbar-dropdown label="Info">
                        <b-navbar-item href="#">
                            About
                        </b-navbar-item>
                        <b-navbar-item href="#">
                            Contact
                        </b-navbar-item>
                    </b-navbar-dropdown>
                </template>

                <template #end>
                    <b-navbar-dropdown label="Info" :hoverable="true" right arrowless>
                        <b-navbar-item href="#">
                            Halaman Belajar
                        </b-navbar-item>
                        <b-navbar-item href="#">
                            Profil
                        </b-navbar-item>
                        <b-navbar-item href="#">
                            Logout
                        </b-navbar-item>
                    </b-navbar-dropdown>
                </template>
            </b-navbar>

        </div>

        <section class="section">
            <div class="container">
                <div class="columns">
                    <div class="column is-2">
                        <b-menu>
                            <b-menu-list>
                                <b-menu-item v-for="menu in sideMenu" :key="menu" :label="menu.label"></b-menu-item>
                            </b-menu-list>
                        </b-menu>

                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: 'base-layout',

    props: {
        sideMenu: Array
    },

    data() {
        return {

        }
    }
}
</script>