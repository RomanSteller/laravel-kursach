<template>
    <div class="container pt-5">
        <div v-for="error in errors" class="alert alert-danger" role="alert">
            {{ error }}
        </div>
        <form action="" class="m-auto">
            <h3>Создать проект (комнату)</h3>
            <input type="text" class="form-control mt-2" v-model="room_name" placeholder="Название проекта"
                   id="name_project">
            <input type="text" class="form-control mt-2" v-model="room_description" placeholder="Описание проекта"
                   id="name_subject">
            <button type="button" @click.prevent="checkErrors" class="btn btn-primary mt-2 w-100">Сохранить изменения</button>
        </form>
    </div>
</template>

<script>
export default {
    name: "newRoom-component",
    data() {
        return {
            room_name: '',
            room_description: '',
            errors: []
        }
    },
    methods:{
        checkErrors() {
            this.errors.length = 0;
            if (this.room_name.trim().length === 0) {
                this.errors.push('Поле с названием комнаты не должно быть пусто')
            }
            if (this.room_name.trim().length === 0) {
                this.errors.push('Поле с описание не должно быть пусто')
            }
            if (this.errors.length === 0) {
                this.createRoom();
            }
        },
        createRoom() {
            axios.post('api/my-rooms/create',{
                id: this.$store.getters.setUser.id,
                description: this.room_description,
                name: this.room_name
            }).then(res => {
                this.$router.push({name: 'room', params: {id: res.data.id}})
            });
        }
    }
}
</script>

<style scoped>
form {
    width: 450px;
}
</style>
