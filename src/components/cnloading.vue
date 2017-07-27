<template>
    <div :class="classtype">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-loading weui-icon_toast"></i>
            <p class="weui-toast__content">数据加载中</p>
        </div>
    </div>
</template>
<script>
    export default{
        name:'cn-loading',
        props:['isshow'],
        data(){
            return{
            }
        },
        computed:{
            classtype:function () {
                if(this.isshow === true)
                    return 'show'
                if(this.isshow === false || this.isshow === "")
                    return 'hide'
            }
        }
    }
</script>
<style>
    .hide{
        opacity: 0; display: none;
    }
    .show{
        opacity: 1;
    }
</style>