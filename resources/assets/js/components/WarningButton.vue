<template>
    <button class="flagbtn"  @click="open(question)">
        <i class="iconfont" style="font-size: 13px;">&#xe603;</i>
        <span>举报</span>
    </button>
</template>


<script>
    export default {
        props: ['question'],
        data() {
            return {

            }
        },
        methods: {
            open(question) {
                this.$confirm('此问题真的有违规内容需要举报么?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                }).then(() => {
                        axios.put('/api/questions/'+ question + '/warning'),
                        this.$notify({
                            type: 'success',
                            title: '感谢你的举报!',
                            message: '我们会尽快处理此问题',
                            offset: 100
                        });
                }).catch(() => {
                    return false;
                });
            }
        }
    }
</script>