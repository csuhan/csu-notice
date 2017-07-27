<template>
    <div>
        <div v-for="list in cnlists">
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
    </div>
</template>
<script>
    import weui from 'weui.js'
    export default{
        name:'cn-lists',
        props:['cnlists']
    }
</script>