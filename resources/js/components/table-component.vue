<template>
    <div v-if="!load" class="spinner-border" role="status"></div>
    <div v-else class="container-fluid">
        <div v-if="user" class="d-flex justify-content-between">
            <main class="content w-75">
                <div>
                    <div v-if="this.$route.name === 'room'">
                        <router-link :to="{name:'new-task',params:{'userId':userId,'roomId':roomId}}"
                                     class="btn btn-outline-success mt-1 mb-2">Создать новую задачу
                        </router-link>
                    </div>
                    <div v-else-if="this.$route.name === 'new-task'">
                        <a href="" class="btn btn-outline-success m-1" @click.prevent="this.$router.go(-1)">Обратно</a>
                    </div>
                </div>
                <hr>
                <router-view></router-view>
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12 col-lg-6 col-xl-3"
                             v-for="status in statuses"
                             :key="status.id"
                             @drop="onDrop($event, status.id)"
                             @dragover.prevent
                             @dragenter.prevent>
                            <div class="card card-border-primary">
                                <div class="card-header">
                                    <h5 class="card-title">{{ status.status_name }}</h5>
                                </div>
                                <div class="card-body p-3 ">
                                    <div
                                         v-for="task in tasks.filter(x => x.status_id === status.id)"
                                         @dragstart="onDragStart($event, task)"
                                         :key="task .id"
                                         draggable="true"
                                    >
                                        <div :class="[task.executor_id === userId ? 'card-body p-3 bg-primary' : 'card-body p-3 bg-light']">
                                            <p>{{ task.description}}</p>
                                            <div class="float-right mt-n1"><img
                                                src="https://bootdey.com/img/Content/avatar/avatar6.png" width="32"
                                                height="32" class="rounded-circle" alt="Avatar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
            <div>
                <button type="button" class="btn btn-primary mt-2" @click="this.chatOn=!this.chatOn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-chat" viewBox="0 0 16 16">
                        <path
                            d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"></path>
                    </svg>
                </button>
                <chat v-if="this.chatOn" :roomId="roomId"></chat>
            </div>

        </div>
        <div v-else-if="!user" class="w-100">
            <h1>Вы не авторизированны</h1>
        </div>
    </div>


</template>
<script>

import {ref, defineComponent, onBeforeMount, computed,inject} from 'vue';
import axios from 'axios'

import loader from './loader-component'
import rightPanel from './rightPanel-component'
import chat from './chat-component'
import {useRoute} from "vue-router";

export default defineComponent({
    name: 'table-component',
    components: {
        loader,
        chat,
        rightPanel
    },
    data() {
        return {
            chatOn: false
        }
    },
    setup({root}) {
        const tasks = ref(),
            stateUser = inject('store'),
            statuses = ref(),
            user = ref(stateUser.getters.setUser),
            route = useRoute(),
            roomId = route.params.id,
            load = ref(false),
            userId = ref(stateUser.getters.setUser.id)


        onBeforeMount(async () => {
            const res = await axios.post('api/tasks/' + roomId),
                res1 = await axios.get('/api/all-status');

            tasks.value = res.data[0];
            statuses.value = res1.data[0];

            load.value = true;
        });

        function onDragStart(e, item) {
            e.dataTransfer.dropEffect = 'move'
            e.dataTransfer.effectAllowed = 'move'
            e.dataTransfer.setData('itemId', item.id.toString())
        }

        function onDrop(e, statusId) {
            const itemId = parseInt(e.dataTransfer.getData('itemId'))
            tasks.value = tasks.value.map(x => {

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
            tasks,
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

/*.table {*/
/*    display: grid;*/
/*    grid-template-columns: 1fr 1fr 1fr 1fr;*/
/*    gap: 10px;*/
/*}*/

/*.droppable {*/
/*    padding: 15px;*/
/*    border-radius: 10px;*/
/*    background: #2c3e50;*/
/*    margin-bottom: 10px;*/
/*    min-height: 300px;*/
/*}*/

/*.droppable h4 {*/
/*    color: white;*/
/*}*/

/*.draggable {*/
/*    background: white;*/
/*    padding: 5px;*/
/*    border-radius: 5px;*/
/*    margin-bottom: 5px;*/
/*    margin-top: 10px;*/
/*}*/

/*.my_class {*/
/*    background-color: aqua;*/
/*}*/

/*.draggable h5 {*/
/*    margin: 0;*/
/*}*/


body {
    margin-top: 20px;
    background: #fafafa
}

.card-body.p-3.bg-light{
    border: 1px solid ghostwhite;
    margin-top: 3px;
}

.card-body.p-3.bg-primary{
    color:white;
    margin-top: 3px;
}


.card {
    margin-bottom: 1.5rem;
    box-shadow: 0 .25rem .5rem rgba(0, 0, 0, .025)
}

.card-border-primary {
    border-top: 4px solid #2979ff
}

.card-border-secondary {
    border-top: 4px solid #efefef
}

.card-border-success {
    border-top: 4px solid #00c853
}

.card-border-info {
    border-top: 4px solid #3d5afe
}

.card-border-warning {
    border-top: 4px solid #ff9100
}

.card-border-danger {
    border-top: 4px solid #ff1744
}

.card-border-light {
    border-top: 4px solid #f8f9fa
}

.card-border-dark {
    border-top: 4px solid #6c757d
}

.card-header {
    border-bottom-width: 1px
}

.card-actions a {
    color: #495057;
    text-decoration: none
}

.card-actions svg {
    width: 16px;
    height: 16px
}

.card-actions .dropdown {
    line-height: 1.4
}

.card-title {
    font-weight: 500;
    margin-top: .1rem
}

.card-subtitle {
    font-weight: 400
}

.card-table {
    margin-bottom: 0
}

.card-table tr td:first-child,
.card-table tr th:first-child {
    padding-left: 1.25rem
}

.card-table tr td:last-child,
.card-table tr th:last-child {
    padding-right: 1.25rem
}

.card-img-top {
    height: 100%
}

.card {
    margin-bottom: 1.5rem;
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, .025);
}

.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e5e9f2;
    border-radius: .2rem;
}

.card-header:first-child {
    border-radius: calc(.2rem - 1px) calc(.2rem - 1px) 0 0;
}

.card-header {
    border-bottom-width: 1px;
}

.card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    color: inherit;
    background-color: #fff;
    border-bottom: 1px solid #e5e9f2;
}
</style>
