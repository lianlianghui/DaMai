import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    musicName: '',
    isLogin: '',
    episode: '',
    cartNoonList: '',
    cate: '',
    musicList: '',
    singerList: '',
    singerMusic: '',
    detail: '',
    content: '',
    detailArr: '',
    APIUrl: 'http://localhost:9999' // =http://localhost:801/0601/Kyrenemy-project/src/api 在服务器配置文件已配置
  },
  getters: {
    musicName: state => state.musicName,
    isLogin: state => state.isLogin
  },
  mutations: {
    setName (state, name) {
      // console.log(name.musicImg)
      state.musicName = name
    },
    doLogin (state, userName) {
      if (userName === 'admin') {
        state.isLogin = true
      } else {
        state.isLogin = false
      }
    }
    // ,
    // setCartList (state, list) {
    //   state.cartNoonList = list
    // }
  },
  actions: {
    getCartoon ({commit, state}) {
      Vue.http.jsonp(state.APIUrl + '/public/cartoon').then(res => {
        // console.log(res.data)
        // commit('setCartList', res.data)
        state.cartNoonList = res.data
        // console.log(state.cartNoonList.cate[0].cateName)
      })
    },
    getSchool ({commit, state}, id) {
      // console.log(id)
      console.log(id)
      Vue.http.jsonp(state.APIUrl + '/public/cartoon/' + id).then(res => {
        state.cate = res.data
      })
    },
    getMusic ({commit, state}) {
      Vue.http.jsonp(state.APIUrl + '/public/admin/music/mobileMusic').then(res => {
        state.musicList = res.data
        console.log(state.musicList)
      })
    },
    getSingerMusic ({commit, state}, id) {
      console.log(id)
      Vue.http.jsonp(state.APIUrl + '/public/admin/music/singerMusic/id/' + id).then(res => {
        state.singerMusic = res.data
        console.log(state.singerMusic)
      })
    },
    getSinger ({commit, state}) {
      Vue.http.jsonp(state.APIUrl + '/public/admin/singer/mobileSinger').then(res => {
        state.singerList = res.data
        console.log(state.singerList)
      })
    },
    getEpisode ({commit, state}, id) {
      console.log(id)
      Vue.http.jsonp(state.APIUrl + '/public/episode/' + id).then(res => {
        state.episode = res.data
      })
    },
    getDetail ({commit, state}, id) { // Error!!!!!!!!!!!!
      console.log(id)
      Vue.http.jsonp(state.APIUrl + '/public/detail/' + id).then(res => {
        state.detail = res.data
        state.content = state.detail[0].content.substr(1, state.detail[0].content.length - 2)
        console.log(state.content)
        state.detailArr = state.content.split(',')
        for (var i = 0; i < state.detailArr.length; i++) {
          state.detailArr[i] = state.detailArr[i].substr(1, state.detailArr[i].length - 2)
        }
        console.log(state.detailArr)
      })
    }
  }// actions end
})
export default store
