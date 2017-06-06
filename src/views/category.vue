<template>
  <div>
   <h1>分类页面</h1>
    <mt-swipe :auto="4000">
      <mt-swipe-item><img src="../assets/images/banner1.jpg" alt=""></mt-swipe-item>
      <mt-swipe-item><img src="../assets/images/banner2.jpg" alt=""></mt-swipe-item>
      <mt-swipe-item><img src="../assets/images/banner3.jpg" alt=""></mt-swipe-item>
      <mt-swipe-item><img src="../assets/images/banner4.jpg" alt=""></mt-swipe-item>
    </mt-swipe> 
  </div>

</template>

<script type="es6">
import Vue from 'vue'
import { Swipe, SwipeItem, Cell,Toast} from 'mint-ui'
// import list from '../jsons/list'
Vue.component(Swipe.name, Swipe)
Vue.component(SwipeItem.name, SwipeItem)
export default{
  
}

</script>
<style>
.mint-swipe{
  height: 160px !important;
  width: 100% !important;
  margin-top: 40px;
}
.mint-swipe img{
  width: 100% !important;
}
</style>
