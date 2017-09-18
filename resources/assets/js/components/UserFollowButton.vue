<template>
    <a class="btn btn-sm btn-success" v-bind:class="{'follows': !followed}" v-cloak="true"  v-text="text" v-on:click="follow"
       style="width: 100px;"></a>
</template>

<script>
    export default {
        props:['user'],
        mounted() {
            axios.post('/api/user/isfollowed',{'user':this.user}).then(response => {
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
                return this.followed ? '已关注' : '关注他'
            }
        },
        methods: {
            follow() {
                axios.post('/api/user/follow',{'user':this.user}).then(response => {
                    this.followed = response.data.followed
                })
            }
        }
    }
</script>