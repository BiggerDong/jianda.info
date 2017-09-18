<template>
    <a class="col-md-2 pull-right" id="topic-follow-s"  v-on:click="follow"
    ><span style="color: #8899a6;" v-text="text"></span></a>
</template>

<script>
    export default {
        props:['topic'],
        mounted() {
            axios.post('/api/topic/isfollowed',{'topic':this.topic}).then(response => {
                this.followed = response.data.followed
            })
        },
        data() {
            return {
                followed: '',
            }
        },
        computed: {
            text() {
                return this.followed ? '√正在关注' : '+关注话题'
            }
        },
        methods: {
            follow() {
                axios.post('/api/topic/follow',{'topic':this.topic}).then(response => {
                    this.followed = response.data.followed
                })
            }
        }
    }
</script>