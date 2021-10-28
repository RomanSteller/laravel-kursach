<template>
  <form class="form-signing">
    <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
    <input type="email" class="form-control" v-model="authForm.login" placeholder="Login">
    <input type="password" class="form-control mt-2" v-model="authForm.password" placeholder="Password">
    <button class="btn btn-lg btn-primary btn-block" @click.prevent="checkAuthError" type="submit">Sign in</button>
  </form>
</template>

<script>
import axios from "axios";

export default {
  name: "authorize-component",
  data(){
    return{
      errors:[],
      authForm: {
        login: '',
        password: ''
      }
    }
  },
  methods:{
    checkAuthError(){
      this.errors.length = 0;

      if (this.authForm.login.trim().length === 0){
        this.errors.push('Поле с логином не должно быть пустым')
      }
      if (this.authForm.password.trim().length === 0){
        this.errors.push('Поле с паролем не должно быть пустым')
      }
      if(this.errors.length === 0){
          console.log('123')
        this.authUser()
      }
    },
    async authUser(){
      const res = await axios.post('api/sanctum/token',this.authForm);

      localStorage.setItem('token',res.data.token);
      await this.$router.push('/');
        console.log(res.data[0])
    }
  }
}
</script>

<style scoped>


form {
  margin: 30px auto;
  max-width: 400px;
  background: #ffffff;
  color: #2c3e50;
  font-weight: bolder;
  border-radius: 10px;
  padding: 10px 30px;
}

.form-group input, button, a {
  margin-top: 10px;
  margin-bottom: 10px;
  padding: 5px 5px;
  border-radius: 0;
  border: 1px solid gainsboro;
}


</style>
