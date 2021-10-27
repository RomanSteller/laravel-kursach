<template>
    <div>
        <HeaderComponent :user=this.$store.state.user></HeaderComponent>
        <div class="container">
            <router-view/>
        </div>
    </div>
</template>

<script>

import {mapGetters} from "vuex/dist/vuex.mjs";
import 'jquery/src/jquery.js';
import 'popper.js/dist/popper.min.js';
import 'bootstrap/dist/js/bootstrap.min.js';
import HeaderComponent from '../components/header-component'
import {mapActions} from "vuex";

export default {
    components: {
        HeaderComponent
    },
    created() {
      this.getUser();
    },
    computed: {
        ...mapGetters(['setUser']),
        authUser() {
            return this.setUser;
        }
    },
    methods: {
        ...mapActions(['getUser','getUserForId'])
    }
}

</script>

<style>

@import '~bootstrap/dist/css/bootstrap.css';

.navigations {
    display: flex;
    justify-content: space-between;
}

* {
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Noto Sans', sans-serif;
}

router-link {
    margin-right: 30px;
    font-size: 15px;
}

header {
    display: flex;
    justify-content: space-between;
    padding: 10px 30px;
    background-color: white;
    align-items: center;
}

main {
    padding: 30px;
}

#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
}

#nav a {
    font-weight: bold;
    color: #2c3e50;
}

#nav a.router-link-exact-active {
    color: #42b983;

}

#nav a.router-link-exact-active.home {
    color: #2c3e50;
}

#nav a {
    margin-right: 10px;
    text-decoration: none;
}

</style>
