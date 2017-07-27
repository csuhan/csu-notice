<template>
    <div class="weui-footer" :class="{'weui-footer_fixed-bottom':fixed}">
        <p class="weui-footer__links">
            <router-link class="weui-footer__link" to="/">首页</router-link>
            <router-link class="weui-footer__link" to="/about">关于</router-link>
        </p>
        <p class="weui-footer__text">Copyright © 2016-2017 <slot></slot></p>
    </div>
</template>
<script>
    export default{
        name:'cn-footer',
        props:{
            fixed:{
                type:Boolean,
                default:false
             }
        }
    }
</script>