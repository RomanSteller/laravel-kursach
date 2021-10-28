<template>
  <form action="" class="w-25 m-auto">
    <h2>Создать задача</h2>
    <input type="text" class="form-control mt-2" placeholder="Название задачи" v-model="taskName">
    <input type="text" class="form-control mt-2" placeholder="Описание задачи" v-model="taskDescription">
    <input type="text" class="form-control mt-2" placeholder="Выполняющий" v-model="keyword">
    <ul v-if="users.length > 0 && listUser" class="list-group mt-3">
      <li class="list-group-item" v-for="user in users" :key="user.id" @click="setExecutor(user)">{{user.name}}</li>
    </ul>
    <label class="pt-3">Дата начала</label>
    <input type="datetime-local" class="form-control mt-2" placeholder="Дата начала" v-model="dateStart">
    <label class="pt-3">Окончания</label>
    <input type="datetime-local" class="form-control mt-2" placeholder="Дата окончания" v-model="dateEnd">
    <button @click="createNewTask" class="btn btn-primary w-100 mt-2 mb-5">Создать задачу</button>
  </form>
</template>

<script>
import axios from "axios";

export default {
  name: "modalWindow-component",
  props:["userId","roomId"],
  data(){
    return{
      taskName: '',
      taskDescription: '',
      executorId: '',
      dateStart: '',
      dateEnd: '',
      users:[],
      keyword:null,
      listUser: true
    }
  },
  created() {
    console.log(this.roomId)
    console.log(this.userId)
  },
  watch:{
    keyword(){
      this.fetchUsers();
    }
  },
  methods:{
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
      }).catch(err=>{
        console.log(err.message)
      });

    },
    fetchUsers(){
      axios.get('api/getUsers',{params:{keyword:this.keyword}})
          .then(res=>{
            console.log(this.users =  res.data)
          });
    },

    setExecutor(user){
      this.executorId = user.id;
      console.log(user.id)
      this.users.length = 0;
      this.keyword = user.name
      this.listUser = false

    }
  }
}
</script>

<style scoped>

li{
  cursor: pointer;
}
</style>
