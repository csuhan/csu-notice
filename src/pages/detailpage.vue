<template>
    <div>
        <div class="header">
            <div class="title">{{$route.params.title}}</div>
            <div class="article__info">
                <div>{{$route.params.dept}}</div>
                <div>{{$route.params.pubtime}}</div>
                <div>浏览:{{$route.params.viewer}}</div>
            </div>
        </div>
        <div id="article" class="weui-article" v-html="article"></div>
        <div class="download" v-show="hasDownload">
            <div class="weui-cells__title">附件</div>
            <div class="weui-cells">
                <div v-for="down in downloads">
                    <i class="weui-icon-download"></i>
                    <a :href="down.link">{{down.title}}</a>
                </div>
            </div>

        </div>
        <cn-loading :isshow="isshowLoading"></cn-loading>
        <cn-footer>新媒体工作室</cn-footer>
    </div>

</template>
<script>
    import cnLoading  from '../components/cnloading.vue'
    import cnFooter from '../components/cnfooter.vue'
    import config from '../config/index.js'
    import base64 from 'base64-js'
    export default{
        name:'detail-page',
        components:{
            cnLoading,
            cnFooter
        },
        created(){
            this.$http.get(config.baseUrl+'?cn-article='+this.$route.params.id).then(suce => {
                this.article = suce.body.article;
                this.hasDownload = suce.body.has_download;
                this.downloads = suce.body.downloads;
                this.isshowLoading = false;
            },error => {
                alert('网络连接错误，请重试');
            });
        },
        data(){
            return{
                isshowLoading: true,
                article:'',
                hasDownload: true,
                downloads:[]
            }
        }
    }
</script>
<style scoped>
    .header{
        margin: 10px auto auto 10px;
        border-bottom: 1px solid #ddd;
    }
    .title{
        font-size: 16px;
        color: #007cc3;
    }
    .article__info{
        font-size: 13px;
        color: #ddd;
    }
    .article__info div{
        display: inline-block;
        margin: auto 0.2em;
    }
    .download{
        margin: 5px;
    }
    .download a{
        font-size: 14px;
    }
</style>
