<template>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <router-link class="navbar-brand" to="/">Home</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto" v-if="user">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name:'rooms',params:{id:user.id}}" >My rooms</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name:'new-room'}">Create new room</router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" @click="logout">Logout</a>
                    </li>
                </ul>
                <ul class="navbar-nav" v-else-if="!user">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/auth">Login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/registration">Registration</router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </div>


</template>

<script>
export default {
  name: "header-component",
  props: ["user"],
  methods:{
    logout() {
      localStorage.removeItem('token')
      this.$router.push('/');
      window.location.reload()
    }
  }
}
</script>

<style scoped>

</style>
