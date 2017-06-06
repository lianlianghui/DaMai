<template>
  <div id="app">
    <mt-header fixed title="推荐" @click.native="$router.go(-1)">
    </mt-header>
    <router-view></router-view>
    <mt-tabbar style="position:fixed;" v-model="selected">
       <mt-tab-item id="tab1">
          <router-link to="/">推荐</router-link>
       </mt-tab-item>
       <mt-tab-item id="tab2">
        <router-link to="/category">分类</router-link>
       </mt-tab-item>
       <mt-tab-item id="tab3">
         <router-link to="/find">发现</router-link>
        </mt-tab-item>
       <mt-tab-item id="tab4">
         <router-link to="/mine">我的</router-link>
        </mt-tab-item>
    </mt-tabbar>
  </div>
</template>

<script type="es6">
import Player from './components/Player'
export default {
  name: 'app',
  data() {
    return {
      selected : 'tab1'
    }
  },
  components: {
    Player
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  /*margin-top: 60px;*/
  margin-bottom: 145px;
  margin-top:40px;
}
.logo{
  display: block;
  margin:auto;
}
.mint-header-button.is-left:before{
  content: '返回';
  color:#fff;
}
.mint-tabbar a{
    font-size: 16px;
    color: #000;
    text-decoration: none;
    padding: 20px 0;
}
</style>
