<template>
    <div>
        <img src="../assets/about-header.jpg" alt="">
        <div class="about">
            <h2>中南大学校内公告通知</h2>
            <p style="text-align: center">本程序由中南大学新媒体工作室制作与维护<br>如有任何问题或者建议<br>请在官微留言<br>我们会尽快解决</p>
            <router-link to="/" class="weui-btn weui-btn_primary">前往首页</router-link>
            <router-link to="/search" class="weui-btn weui-btn_plain-primary">搜索</router-link>
        </div>
        <cn-footer :fixed="true">新媒体工作室</cn-footer>
    </div>
</template>
<script>
    import cnFooter from '../components/cnfooter.vue'
    export default{
        name:'about',
        components:{
            cnFooter
        }
    }
</script>
<style scoped>
    img{
        width: 100%;
    }
    .about{
        margin: 50px 20px auto 20px;
    }
    .about h2{
        color: #007cc3;
        text-align: center;
    }
    .about a{
        margin: 20px auto;
    }
</style>