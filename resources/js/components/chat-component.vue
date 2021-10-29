<template>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <div class="chat w-100" id="chat">
                    <div v-for="(messages,index) in this.renderMessages" :key="index">
                        <p :class="{'left':messages.users.id === this.$store.getters.setUser.id,'right':messages.users.id !== this.$store.getters.setUser.id}">
                            {{messages.users.id === this.$store.getters.setUser.id ? 'Вы ' + messages.message : messages.users.login + ' ' + messages.message}}
                        </p>
                    </div>
                    <div v-for="message in messages" :key="message">
                        <p :class="{'left':message[0] === this.$store.getters.setUser.id, 'right': message[0] !== this.$store.getters.setUser.id }">
                            {{
                            message[0] === this.$store.getters.setUser.id ? 'Вы ' + message[2] : message[1] + ' ' + message[2]
                            }}
                        </p>
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
            user: this.$store.getters.setUser,
            authorUserId: null,
            renderMessages: null,
        }
    },
    async mounted() {
        await axios.get('/api/all-messages/'+this.roomId)
            .then(res=>{
                this.renderMessages = res.data
            });
        console.log(this.renderMessages)
        // this.renderMessages.push(messages.data)

        // this.messages.push(messages.data.)
        window.Echo.channel('channel.' + this.roomId)
            .listen('ChatMessage', (e) => {
                this.messages.push([e.data.user.id, e.data.user.login, e.data.text])
                this.authorUserId = e.data.user.id;
                console.log(this.messages);
            });
    },
    methods: {
        sendMessage() {
            axios.post('api/message', {
                text: this.textMessage,
                roomId: this.roomId,
                user: this.user,
                userId: this.$store.getters.setUser.id
            }).then(res => {
            });
            this.textMessage = ""

        }
    }
}
</script>

<style scoped>
.chat {
    width: 150px;
    height: 300px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    overflow: auto;
    font-size: 17px;
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
