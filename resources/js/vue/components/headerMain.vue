<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <router-link :to="{name:'home'}" class="navbar-brand" >
                    Dashboard
                </router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <router-link :to="{name:'home'}" class="nav-link">Home</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name:'customer'}" class="nav-link">Customer</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name:'sales'}" class="nav-link">Sales</router-link>
                            </li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    {{ userData.name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <router-link :to="{name:'account'}" class="dropdown-item">Account</router-link>
                                    <router-link :to="{name:'security'}" class="dropdown-item">Security</router-link>
                                    <a class="dropdown-item" href="#" @click.prevent="logout()">Logout</a>
                                    <form ref="logoutform" action="/logout" method="POST" class="d-none">
                                        <input type="hidden" name="_token" :value="csrf">
                                    </form>
                                </div>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>
<script>    
import { mapGetters } from "vuex";
export default {
    name: 'headerMain',
    data () {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            userData: {},
        }
    }, 
    created(){
        this.userData = this.$store.getters.getUserData;
    },
    methods : {
        logout(){
            this.$refs.logoutform.submit();
            //document.getElementById('logout-form').submit();
        },
    },
    watch:{
        "getUserData": function(){
            this.userData = this.$store.getters.getUserData;
        }
    },
    computed: {
        ...mapGetters({ getUserData: 'getUserData' })
    }
}
</script>
<style lang="css" scoped>
</style>
