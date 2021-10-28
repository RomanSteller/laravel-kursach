<template>
        <loader v-if="load"/>
        <router-link :to="{name:'new-task',params:{'userId':userId,roomId:roomId}}" class="btn btn-outline-success m-5">
            Create new task
        </router-link>
        <router-view></router-view>
        <div v-if="user && !load" class="table">
            <div v-for="status in statuses"
                 :key="status.id"
                 @drop="onDrop($event, status.id)"
                 class="droppable"
                 @dragover.prevent
                 @dragenter.prevent>
                <h4>{{ status.status_name }}</h4>
                <div v-for="post in posts.filter(x => x.status_id === status.id)"
                     @dragstart="onDragStart($event, post)"
                     class="draggable"
                     :class="{'my_class': post.executor_id === userId}"
                     :key="post.id"
                     draggable="true">
                    <h5 class="btn-group">{{ post.title }}</h5>
                </div>
            </div>
        </div>
        <div v-else-if="!user && !load">
            <h1>Вы не авторизированны</h1>
        </div>
        <chat :roomId="roomId"></chat>
</template>
<script>

import {ref, defineComponent, onBeforeMount, computed} from 'vue';
import axios from 'axios'

import loader from './loader-component'
import chat from './chat-component'
import {useRoute} from "vue-router";

export default defineComponent({
    name: 'table-component',
    components: {
        loader,
        chat
    },
    setup({root}) {
        const posts = ref(),
            statuses = ref(),
            user = ref(),
            route = useRoute(),
            roomId = route.params.id,
            load = ref(true),
            userId = ref(),
            stateUser = computed(() => root.$store.getters.setUser)

        onBeforeMount(async () => {
            console.log(stateUser);
            await axios.get('/api/user', {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            }).then(res => {
                console.log(res.data)
                user.value = res.data[0];
                userId.value = user.value.id;
                load.value = false
            }).catch(err => {
                console.log(err)
                load.value = false
            });

            const res = await axios.post('api/tasks/' + roomId),
                res1 = await axios.get('/api/all-status');

            posts.value = res.data[0];
            statuses.value = res1.data[0];

        });

        function onDragStart(e, item) {
            e.dataTransfer.dropEffect = 'move'
            e.dataTransfer.effectAllowed = 'move'
            e.dataTransfer.setData('itemId', item.id.toString())
        }

        function onDrop(e, statusId) {
            const itemId = parseInt(e.dataTransfer.getData('itemId'))
            posts.value = posts.value.map(x => {

                if (x.executor_id !== userId.value) return x;
                if (x.id === itemId) {
                    x.status_id = statusId
                    axios.post('/api/change-status', {
                        statusId: statusId,
                        id: x.id
                    }).then(res => {
                        console.log(res.data.message);
                    });
                }
                return x
            })
        }

        return {
            statuses,
            posts,
            user,
            onDragStart,
            onDrop,
            load,
            userId,
            roomId
        }
    }
})

</script>

<style scoped>


.table {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    gap: 10px;
}

.droppable {
    padding: 15px;
    border-radius: 10px;
    background: #2c3e50;
    margin-bottom: 10px;
    min-height: 300px;
}

.droppable h4 {
    color: white;
}

.draggable {
    background: white;
    padding: 5px;
    border-radius: 5px;
    margin-bottom: 5px;
    margin-top: 10px;
}

.my_class {
    background-color: aqua;
}

.draggable h5 {
    margin: 0;
}
</style>
