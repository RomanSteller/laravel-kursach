<template>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <div class="chat w-100" id="chat" style="display: flex;flex-direction: column-reverse">
                    <div  v-for="message in messages" :key="message">
                        <p class="left w-100">{{ message }}</p>
                    </div>
                    <div v-for="message in serverMessages" :key="message">
                        <p class="right w-100">{{ message }}</p>
                    </div>
                </div>
                <hr>
                <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage">
            </div>
        </div>
    </div>
</template>

<script>


export default {
    name: "chat",
    props: ['roomId'],
    data() {
        return {
            messages: [],
            textMessage: '',
            textAuthor: '',
            user: this.$store.getters.setUser,
            userId: '',
            serverUserId: '',
            serverMessages: []
        }
    },
    mounted() {
        window.Echo.channel('channel.' + this.roomId)
            .listen('ChatMessage', (e) => {
                this.serverMessages.push(e.data.user.name + ' ' + e.data.text);
                this.serverUserId = e.data.user.id;
            })
    },
    methods: {
        sendMessage() {
            axios.post('api/message', {
                text: this.textMessage,
                roomId: this.roomId,
                user: this.user
            }).then(res => {
            });
            this.messages.push('Вы ' + this.textMessage);
            this.textMessage = '';
        }
    }
}
</script>

<style scoped>
.chat {
    width: 150px;
    height: 150px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    overflow: auto;
}

.left {
    text-align: left;
    background: rgba(170, 230, 154, .5);
    padding: 5px 10px;
}

.right {
    text-align: right;
    background: rgba(79, 196, 219, .5);
    padding: 5px 10px;
}

</style>
