<template>
  <div>
    <table class="table mt-5">
      <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Название проекта</th>
        <th scope="col"></th>
      </tr>
      </thead>
      <tbody v-for="room in rooms" :key="room.id">
        <tr>
          <th scope="row">{{room.id}}</th>
          <td>{{ room.name }}</td>
          <td><router-link :to="{name:'room',params:{id:room.id}}" class="btn btn-success">Перейти в комнату</router-link></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import axios from 'axios';


export default {
  name: "rooms-component",
  components:{

  },
  data() {
    return {
      rooms: null
    }
  },
  created() {
    this.fetchRooms();
  },
  computed: {},
  methods: {
    fetchRooms() {
      let userid = this.$route.params.id;
      axios.post('/api/my-rooms/?id=' + userid).then(res => {
        this.rooms = res.data.rooms;

      });
    }
  }
}
</script>
<style scoped>

* {
  font-family: 'Noto Sans', sans-serif;
}

.btn-create-room {
  background-color: #0086b3;
  color: white;
}

.name {
  background-color: white;
  margin: 10px;
  border-radius: 7px;
  padding: 10px 20px;
  text-align: left;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.a-room {
  border: 0;
  background-color: #0086b3;
  color: white;
  font-size: 14px;
  padding: 10px 10px;
  border-radius: 4px;
  text-decoration: none;
}


</style>