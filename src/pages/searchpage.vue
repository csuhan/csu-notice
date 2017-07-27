<template>
    <div>
        <div class="search-bar">
            <div class="weui-search-bar" :class="{'weui-search-bar_focusing':isFocusing }" id="searchBar" @click="searchBarFocusing">
                <form class="weui-search-bar__form">
                    <div class="weui-search-bar__box">
                        <i class="weui-icon-search"></i>
                        <input
                                type="search" class="weui-search-bar__input" placeholder="搜索" required=""
                                v-model="searchText" @keydown.enter="search">
                        <a href="javascript:" class="weui-icon-clear" @click="searchBarClear"></a>
                    </div>
                    <label class="weui-search-bar__label" >
                        <i class="weui-icon-search"></i>
                        <span>搜索</span>
                    </label>
                </form>
                <a href="javascript:" class="weui-search-bar__cancel-btn"  @click="searchBarCancle">取消</a>
            </div>
            <div class="weui-cells" v-show="searchText!==''">
                <div class="weui-cell weui-cell_access small-font" @click="search">搜索“{{searchText}}”</div>
            </div>

            <div class="search-lists" v-show="hasResult">
                <cn-lists :cnlists="cnlists.lists"></cn-lists>
                <infinite-loading :on-infinite="onInfinite" ref="infiniteLoading_search">
                    <span slot="no-more" class="weui-cells__title">只有这些数据了</span>
                </infinite-loading>
            </div>
            <cn-loading :isshow="isshowLoading"></cn-loading>
            <cn-footer :fixed="isFixed">新媒体工作室</cn-footer>
        </div>

    </div>
</template>
<script>
    import cnLoading from '../components/cnloading.vue'
    import InfiniteLoading from 'vue-infinite-loading'
    import cnLists from '../components/cnlists.vue'
    import cnFooter from '../components/cnfooter.vue'

    import config from '../config/index.js'

    export default {
        name:'search-page',
        data(){
            return{
                searchText:'',
                isFocusing: false,
                hasResult: false,
                isshowLoading:false,
                cnlists:'',
            }
        },
        components:{
            cnLoading,
            InfiniteLoading,
            cnLists,
            cnFooter
        },
        methods:{
            searchBarFocusing(){
                this.isFocusing = true;
            },
            searchBarCancle(){
              this.isFocusing = false;
            },
            searchBarClear(){
              this.searchText= '';
            },
            search(){
                this.isshowLoading = true;
                this.$http.get(config.baseUrl+'?cn-lists-search='+this.searchText+'&cn-lists-search-page=1')
                    .then(suce => {
                    this.cnlists = suce.body;
                    this.isshowLoading = false;
                    this.hasResult = true;
                    //初始化加载，缺少这一句则会无法更新状态
                    this.$refs.infiniteLoading_search.$emit('$InfiniteLoading:loaded');
                },error => {
                    alert('数据读取异常，请重试');
                })
            },
            onInfinite(){
                if(this.hasResult && this.cnlists.now_page<this.cnlists.total_page) {
                    this.$http.get(config.baseUrl+'?cn-lists-search='+this.searchText
                        +'&cn-lists-search-page='+parseInt(this.cnlists.now_page+1))
                        .then(suce => {
                            this.cnlists.now_page = suce.body.now_page;
                            this.cnlists.lists = this.cnlists.lists.concat(suce.body.lists);
                            this.$refs.infiniteLoading_search.$emit('$InfiniteLoading:loaded');
                    }, error => {
                        alert('数据读取异常，请重试');
                        this.$refs.infiniteLoading_search.$emit('$InfiniteLoading:complete');
                        })
                }
                else{
                    this.$refs.infiniteLoading_search.$emit('$InfiniteLoading:complete');
                }
            }
        },
        computed:{
            isFixed(){
                return !this.hasResult;
            }
        }

    }
</script>
<style>
    .small-font{
        font-size: 15px;
        word-break: break-all;
    }
</style>