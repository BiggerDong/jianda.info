<template>
    <div>
        <div class="row">
            <div class="col-md-2" id="votebtn" style="margin-right: -65px;">
                <button class="votebtn" v-html="text" v-on:click="vote" v-bind:class="{'true': voted}"
                        data-toggle="tooltip" data-placement="left" title="赞同答案">
                </button>
            </div>
            <div class="col-md-2 " style="margin-right: -25px;">
                <button class="combtn" data-toggle="collapse" v-html="textc" @click="showCommentsForm">
                </button>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;margin-bottom: -20px;">
            <div class="col-md-12">
                <div class="collapse">
                    <div class="well">
                        <div class="comshow" v-for="comment in comments">
                            <div class="row" style="margin: -6px">
                                <div class="col-md-3"><a href="#" style="color: #333;">{{ comment.user.name }}</a> :</div>
                                <div class="col-md-9 col-md-pull-1" style="color: #666;"> {{ comment.body }}</div>
                            </div>
                            <hr>
                        </div>
                        <div class="form-group" style="padding-bottom: 15px;">
                            <form @submit.prevent>
                                <textarea class="form-control" name="" id="" rows="2" placeholder="写下你的评论"
                                          style="margin-bottom: 15px;box-shadow: none;resize: none;"
                                          v-model="body"  required></textarea>
                                <button class="btn btn-sm btn-success pull-right" @click="store">评论</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['answer','count','countc'],
        mounted() {
            axios.post('/api/answer/' + this.answer + '/votes/users').then(response => {
                this.voted = response.data.voted
            })
        },
        data() {
            return {
                voted: false,
                body: '',
                comments: [],
                total: this.countc
            }
        },
        computed: {
            text() {
                return '<i class="iconfont" style="font-size: 15px;">&#xe748;</i> ' + this.count
            },
            textc() {
                return '<i class="iconfont" style="font-size: 15px;">&#xe65f;</i> <span>' + this.total + '条评论</span>'
            },
        },
        methods: {
            vote() {
                axios.post('/api/answer/vote',{'answer':this.answer}).then(response => {
                    this.voted = response.data.voted
                    response.data.voted ? this.count ++ : this.count --
                })
            },
            store() {
                axios.post('/api/comment',{'answer':this.answer,'body':this.body}).then(response => {
                    let comment = {
                        user : {
                            name:Jianda.name
                        },
                        body: response.data.body
                    }
                    if (comment.body == null) {
                        return false
                    }
                    this.comments.push(comment)
                    this.body = ''
                    this.total ++
                })
            },
            showCommentsForm() {
                this.getComments()
            },
            getComments() {
                axios.get('/api/answer/' + this.answer + '/comments').then(response => {
                    this.comments = response.data
                })
            }
        }
    }
</script>
