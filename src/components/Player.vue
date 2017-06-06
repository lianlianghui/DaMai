<template>
	<div class="player_box">
		<div class="left_box">
			<!-- <img :src="musicName.pic || 'http://s.cn.bing.net/th?id=OSA.wCIYE0tP08avWA&w=80&h=80&c=8&rs=1&pid=SatAns'" alt=""> -->
			<img :src="musicName.musicImg || 'assets/images/default.png'" alt="" v-if="musicName.musicImg">
			<img src="../assets/images/default.png" alt="" v-if="!musicName.musicImg">
		</div>
		<div class="center_box">
			<!-- <p>歌曲：{{ musicName.title }}</p>
			<audio :src="musicName.msc" autoplay controls></audio> -->
			<p>歌曲：{{ musicName.musicName }}</p>
			<audio :src="$store.state.APIUrl+musicName.mp3Src" autoplay controls></audio>
			<!-- <audio :src="'http://www.xiami.com/widget/0_'+ musicName.songID +'/singlePlayer.swf'" autoplay controls></audio> -->
			<!-- <embed :src="'http://www.xiami.com/widget/0_'+ musicName.songID +'/singlePlayer.swf'" type="application/x-shockwave-flash" width="257" height="33" wmode="transparent"></embed> -->
		</div>
		<!-- <div class="right_box">
			<input type="button" value="播放">
		</div> -->
	</div>
</template>


<script type="es6">
import { mapGetters } from 'vuex'

export default {
  name: 'player',
  data(){
  	return {

  	}

  },
  cretead(){

  	 this.start();
  },
   computed: {
      ...mapGetters(['musicName','isLogin'])
    },
   methods:{
   	 start(){

   	 }
   }

}
</script>

<style scoped>
	.player_box{
		/*height: 104px;*/
		background-color: #333;
		color: #fff;
		position: fixed;
    width: 100%;
    bottom: 57px;
		left: 0px;
	}
	.player_box > div{ float: left; width: 30%;}

	.left_box img{
		width:70%;
		margin-left: -20px;
		padding-top: 5px;
	}
	.right_box{
		width: 50px !important;
    height: 50px;
    background: orange;
    line-height: 50px;
    right: 30px;
    top: 50%;
    position: absolute;
    margin-top: -25px;
	}
	.center_box{
		width:250px !important;
		text-align: left;
	}
	.center_box p{
		margin: 5px 0px;
		width: 100%;
	}
	.center_box audio{
		width: 250px;
    margin-left: -13px;
	}
</style>
