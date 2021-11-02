<template>
    <form action="" class="w-75 m-auto">
        <div v-for="error in errors" class="alert alert-danger" role="alert">
            {{error}}
        </div>
        <h2>Создать задачу</h2>
        <input type="text" class="form-control mt-2" placeholder="Название задачи" v-model="taskName">
        <input type="text" class="form-control mt-2" placeholder="Описание задачи" v-model="taskDescription">
        <input type="text" class="form-control mt-2" placeholder="Выполняющий" v-model="keyword">
        <ul v-if="users.length > 0 && listUser" class="list-group mt-3">
            <li class="list-group-item" v-for="user in users" :key="user.id" @click="setExecutor(user)">
                {{ user.login + " " + user.name }}
            </li>
        </ul>
        <label class="pt-3">Дата начала</label>
        <input type="datetime-local" class="form-control mt-2" placeholder="Дата начала" v-model="dateStart">
        <label class="pt-3">Окончания</label>
        <input type="datetime-local" class="form-control mt-2" placeholder="Дата окончания" v-model="dateEnd">
        <button @click.prevent="checkErrors" class="btn btn-primary w-100 mt-2 mb-5">Создать задачу</button>
    </form>
</template>

<script>
import axios from "axios";

export default {
    name: "modalWindow-component",
    props: ["userId", "roomId"],
    data() {
        return {
            taskName: '',
            taskDescription: '',
            executorId: '',
            dateStart: '',
            dateEnd: '',
            users: [],
            keyword: '',
            listUser: true,
            errors:[]
        }
    },
    created() {
        console.log(this.roomId)
        console.log(this.userId)
    },
    watch: {
        keyword() {
            this.fetchUsers();
        }
    },
    methods: {
        createNewTask() {
            console.log(this.executorId + 'dasd')
            axios.post('api/create-task', {
                title: this.taskName,
                description: this.taskDescription,
                author_id: this.userId,
                executor_id: this.executorId,
                date_end: this.dateEnd,
                date_start: this.dateStart,
                room_id: this.roomId,
            }).then(res => {
                console.log(res.data)
                this.$router.go(this.$router.currentRoute)
            }).catch(err => {
                console.log(err.message)
            });

        },
        checkErrors() {
            this.errors.length = 0;
            if(this.keyword.trim().length === 0){
                this.errors.push('Поле выполняющего не должно быть пусто')
            }
            if(this.dateStart.trim().length === 0){
                this.errors.push('Дата начала должна быть указана')
            }
            if(this.dateEnd.trim().length === 0){
                this.errors.push('Дата окончания должна быть указана')
            }
            if(this.taskName.trim().length === 0){
                this.errors.push('Название задачи должно быть указаано')
            }
            if(this.taskDescription.trim().length === 0){
                this.errors.push('Описание задачи должно быть указаано')
            }
            if (this.errors.length === 0) {
                this.createNewTask()
            }

        },
        fetchUsers() {
            axios.get('api/getUsers', {params: {keyword: this.keyword}})
                .then(res => {
                    console.log(this.users = res.data)
                });
        },

        setExecutor(user) {
            this.executorId = user.id;
            console.log(user.id)
            this.users.length = 0;
            this.keyword = user.login
            this.listUser = false

        }
    }
}
</script>

<style scoped>

li {
    cursor: pointer;
}
</style>
