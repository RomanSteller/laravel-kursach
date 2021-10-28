<template>
  <form class="form-signin">
    <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
    <input type="text" class="form-control mt-2" placeholder="Login" v-model="regForm.login" required="" autofocus="">
    <input type="text" class="form-control mt-2" placeholder="Name" v-model="regForm.name" required="" autofocus="">
    <input type="email" class="form-control mt-2" placeholder="Email" v-model="regForm.email" required="" autofocus="">
    <input type="password" class="form-control mt-2" placeholder="Password" v-model="regForm.password" required="">
    <input type="password" class="form-control mt-2" placeholder="Confirm Password" v-model="regForm.confirm" required="">
    <button class="btn btn-primary w-100" @click.prevent="checkRegError">Sign up</button>
  </form>
</template>

<script>
import axios from "axios";

export default {
  name: "register-component",
  data() {
    return {
      errors: [],
      regForm: {
        login: '',
        name: '',
        password: '',
        confirm: '',
        email: ''
      },
    }
  },
  methods: {
    checkRegError() {
      this.errors.length = 0;
      let emailPatter = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/,
          cyrillicPattern = /[А-я-\s]/

      if (this.regForm.email.trim().length > 0) {
        if (!emailPatter.test(this.regForm.email)) {
          this.errors.push('Почта не является валлидной');
        }
      } else {
        this.errors.push('Поле с электронной почтой не должно быть пустым')
      }

      if (this.regForm.name.trim().length > 0) {
        if (!cyrillicPattern.test(this.regForm.name)) {
          this.errors.push('ФИО должно содержать только кириллистические символы')
        }
      } else {
        this.errors.push('Поле с ФИО не должно быть пустым')
      }

      if (this.regForm.login.trim().length === 0) {
        this.errors.push('Поле с логином не должно быть пустым')
      }

      if (this.regForm.password.length === 0 && this.regForm.confirm.length === 0) {
        this.errors.push('Поле с паролями не должны быть пустыми')
      }

      if (this.regForm.password !== this.regForm.confirm) {
        this.errors.push('Пароли должны совпадать')
      }

      if (this.errors.length === 0) {
        this.createUser()
      }
    },
    createUser() {
      axios.post('api/sanctum/register', this.regForm)
          .then(res => {
            console.log(res.data)

          })

    }
  }
}
</script>

<style scoped>

@import url('https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap');

.form-group {
  display: flex;
  flex-direction: column;
  text-align: left;
}

.form-group label {
  font-size: 15px;
  font-weight: bold;

}

form {
  font-family: 'Noto Sans', sans-serif;
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

.form-group input {
  border-radius: 0;
  border: 1px solid gainsboro;
  outline: none;
  font-size: 20px;
}

.form-group a {
  font-size: 16px;
  background: #0086b3;
  color: white;
  border-radius: 5px;
  font-weight: lighter;
  border: none;
  padding-top: 10px;
  padding-bottom: 10px;
  text-align: center;
}


</style>