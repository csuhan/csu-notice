<template>
    <div>
        <div class="banner"><h1>校内通知</h1></div>
        <div v-for="list in cnlists.lists">
            <router-link v-bind:to="{name:'DetailPage',params:{id:list.id,title:list.title,dept:list.dept,pubtime:list.pubtime,viewer:list.viewer}}" tag="div">
                <div class="weui-panel">
                    <div class="weui-panel__bd">
                        <div class="weui-media-box weui-media-box_text">
                            <h4 class="weui-media-box__title">{{list.title}}</h4>
                            <ul class="weui-media-box__info">
                                <li class="weui-media-box__info__meta">{{list.dept}}</li>
                                <li class="weui-media-box__info__meta">{{list.pubtime}}</li>
                                <li class="weui-media-box__info__meta weui-media-box__info__meta_extra">浏览:{{list.viewer}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </router-link>
        </div>
        <infinite-loading  :on-infinite="onInfinite" ref="infiniteLoading"></infinite-loading>
        <!--<cn-loading v-show="isshowLoading"></cn-loading>-->
        <cn-footer>新媒体工作室</cn-footer>
    </div>
</template>
<script>
    import cnLoading from '../components/cnloading.vue'
    import InfiniteLoading from 'vue-infinite-loading'
    import cnFooter from '../components/cnfooter.vue'
    import config from '../config/index.js'
    export default{
        name:'home-page',
        components:{
            cnLoading,
            InfiniteLoading,
            cnFooter
        },
        data(){
            return {
                isshowLoading:true,
                cnlists:'',
            }
        },
        methods:{
            onInfinite(){
                //初次访问
                if(!this.cnlists.now_page)
                {
                    this.$http.get(config.baseUrl+'?cn-lists=1').then(suce => {
                        this.cnlists = suce.body;
                        this.$refs.infiniteLoading.$emit('$InfiniteLoading:loaded');
                    },error => {
                        alert('数据读取异常，请重试');
                        this.$refs.infiniteLoading.$emit('$InfiniteLoading:complete');
                    })
                }
                else
                {
                    if(this.cnlists.now_page<this.cnlists.total_page)
                    {
                        this.$http.get(config.baseUrl+'?cn-lists='+parseInt( this.cnlists.now_page+1))
                            .then(suce => {
                            this.cnlists.now_page = suce.body.now_page;
                            this.cnlists.lists = this.cnlists.lists.concat(suce.body.lists);
                            this.$refs.infiniteLoading.$emit('$InfiniteLoading:loaded');
                        },error => {
                            alert('数据读取异常，请重试');
                            this.$refs.infiniteLoading.$emit('$InfiniteLoading:complete');
                        })
                    }
                    else
                    {
                        this.$refs.infiniteLoading.$emit('$InfiniteLoading:complete');
                    }
                }
            }
        }

    }
</script>
<style scoped>
    .banner{
        width: 100%;
        height: 100px;
        /*background-color: #007cc3;*/
        background-image: url("../assets/banner.jpg");
        background-size:cover;
    }
    .banner h1{
        color: white;
        text-align: center;
        line-height: 100px;
        background-color: RGBA(0,124,195,.5);
    }
</style>