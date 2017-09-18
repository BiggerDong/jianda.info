<template>
    <a class="btn btn-sm btn-success pull-right" v-bind:class="{'followh': !followed}"  v-text="text" v-on:click="follow"
       style="width: 70px;margin-top: -9px;"></a>
</template>

<script>
    export default {
        props:['question'],
        mounted() {
            axios.post('/api/question/isfollowed',{'question':this.question}).then(response => {
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
                return this.followed ? '已关注' : '关注问题'
            }
        },
        methods: {
            follow() {
                axios.post('/api/question/follow',{'question':this.question}).then(response => {
                    this.followed = response.data.followed
                })
            }
        }
    }
</script>