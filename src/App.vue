<template>
  <div id="app">
      <transition name="fade" tag="div" mode="out-in" duration="300">
        <router-view></router-view>
      </transition>
      <circle-menu ref="appmenu" class="menu-fixed-bottom"
                   type="top" :number="3" :circle="true"  :btn="true"
      :colors="['#007CC3','#007CC3','#007CC3','#007CC3','#007CC3']">
          <router-link slot="item_3" to="/" class="white-font">首页</router-link>
          <router-link slot="item_2" to="/search" class="white-font">搜索</router-link>
          <router-link slot="item_1" to="/about" class="white-font">关于</router-link>
      </circle-menu>
  </div>
</template>

<script>
import HomePage from './pages/homepage.vue'
import CircleMenu from 'vue-circle-menu'
export default {
        name: 'app',
        components:{
            HomePage,
            CircleMenu,
        },
      data () {
          return {
              isshowLoading: false
          }
      },
    watch:{
        '$route':function (val, oldval) {
            this.$refs.appmenu.open = false;
        }
    }

}
</script>

<style>
    /*导入weui库*/
    @import "./css/weui.css";

    .fade-enter-active, .fade-leave-active {
        transition: opacity .3s;
    }
    .fade-enter, .fade-leave-to{
        opacity: 0;
    }
    .menu-fixed-bottom{
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 999;
    }
    .white-font{
        color: white;
    }

</style>
