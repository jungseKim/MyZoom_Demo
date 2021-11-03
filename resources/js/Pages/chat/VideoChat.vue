<template>
<app-layout title="s">
  <!-- <div class="container"> -->
    <h1 class="text-center">Laravel Video Chat</h1>
    <div class="grid grid-flow-col grid-cols-3 grid-rows-2 gap-4">
      <div v-for="user in users" :key="user.id">
          <p>{{user.name}}</p>
        <video v-if="user.image"  :ref="user.name" autoplay :poster='`/storage/${user.image}`' :alt="user.name"></video>
        <video v-else  :ref="user.name" autoplay poster='/noimage.jpg' :alt="user.name"></video>
      </div>
      <div>
          <p>my video</p>
      <video v-if="stream" ref="video-here" autoplay></video>
      <img v-else :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
          </div>
    </div>

    <!-- <div v-for="user in users" :key="user.id">
        <h1 :ref="user.name">{{user.name}}</h1>
         </div> -->
    <button @click="start">test</button>
  <!-- </div> -->
</app-layout>
</template>
<script>
import Pusher from 'pusher-js';
import Peer from 'simple-peer';
import { Inertia } from '@inertiajs/inertia'
import AppLayout from '@/Layouts/AppLayout.vue'
import axios from 'axios'
export default {
  props: ['user','roomId'],
  data() {
    return {
      channel: null,
      stream: null,
      peers: {},
      users:[]
      // pusherKey:null
    }
  },
   components:{
      AppLayout,
    },

  beforeUnmount(){
      this.RoomOut();
    window.Echo.leave('presence-video-chat.'+this.roomId);

  },
  mounted() {
    this.setupVideoChat()
    console.log(this.$page.pro)

  },
  methods: {
    start(){
      console.log(this.$refs)
    },
    RoomOut(){
   if(this.stream){
      this.stream.getTracks().forEach(function(track) {
    track.stop();
    });
   }
    // if(this.peers){
    //     this.peers.forEach(function(p){
    //     p.close()
    // })
    // }
     axios.delete('/chat/'+this.roomId+'/room')
      .then(res=>{
        console.log(res.data)
      } )
    }
    ,
    getPeer(userId,userName, initiator) {
      if(this.peers[userId] === undefined) {
        let peer = new Peer({
          initiator,//이거때문에 시그널 바로실행
          stream: this.stream,
          trickle: false
        });
        peer.on('signal', (data) => {
          this.channel.whisper(`client-signal-${userId}`, {
            userId: this.user.id,
            userName:this.user.name,
            data: data
          });
          console.log(this.channel)

        })
        .on('stream', (stream) => {
            //아마 이새끼 스트림을 못받아서 그런거 같아
          const videoThere = this.$refs[userName];
          // console.log(this.$refs[`${userName}`])
          // console.log(userName)
          videoThere.srcObject = stream;
          // console.log('hoho')
        })
        .on('close', () => {
          const peer = this.peers[userId];
          if(peer !== undefined) {
            peer.destroy();
          }
          delete this.peers[userId];
        });
        this.peers[userId] = peer;
      }
      return this.peers[userId];
    },
    async setupVideoChat() {
      // To show pusher errors
      // Pusher.logToConsole = true;
//       navigator.mediaDevices.getUserMedia({ video: true, audio: true });
     
    //  const stream = await navigator.mediaDevices.getUserMedia({audio: true });
    //   const videoHere = this.$refs['video-here'];
    //   videoHere.srcObject = stream;
    //   this.stream = stream;
      try{
        const stream = await navigator.mediaDevices.getUserMedia({audio: true });
      const videoHere = this.$refs['video-here'];
      videoHere.srcObject = stream;
      this.stream = stream;
      }catch(err){
       this.stream = null;
      }
     
     //  console.log(this.stream)
      // const pusher = this.getPusherInstance();
      //  console.log('channel')

      //여기서 부터
      console.log(this.roomId)
       this.channel=window.Echo.join('presence-video-chat.'+this.roomId)
        .here((users) => {
         console.log(users)
          if(users){
            for(let i=0;i<users.length;i++){
                if(this.user.id!=users[i].id){
                    console.log(users[i])
                    this.users.push(users[i])
                     this.getPeer(users[i].id,users[i].name,true)
                }
            }
          }
      })
      .joining((user) => {
          this.users.push(user)
          console.log(user)
          console.log("evnet !!!!!!!!!")
     })
      .leaving((user) => {
          this.users.splice(this.users.indexOf(user), 1);
      })
      .listenForWhisper('client-signal-'+this.user.id,(signal)=>{
          const peer = this.getPeer(signal.userId,signal.userName ,false);
          peer.signal(signal.data);
           });

        // this.channel = pusher.subscribe('presence-video-chat-'+this.roomId);
        // console.log(this.channel)
        // this.channel.bind(`client-signal-${this.user.id}`, (signal) =>
        // {
        //   const peer = this.getPeer(signal.userId, false);
        //   peer.signal(signal.data);
        //   console.log('signal')
        // });
        // this.channel.bind('managerOut',(signal)=>{
        //   console.log('managerout')
        // })

    },
    // getPusherInstance() {
    //   //이거 멤버변수로 해놓으면 못받는듯
    //   console.log('09b388928591241646f6')
    //   return new Pusher(this.pusherKey, {
    //     authEndpoint: '/auth/video_chat',
    //     cluster: this.pusherCluster,
    //     auth: {
    //       headers: {
    //         //이거 블레이드 없어서 뷰에서 따로 보내줘야됨
    //         //그래서 일단 app블레이드 헤드 에다가 추가해놈
    //         'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content
    //    }
    //     }
    //   });
    // }
  }
};
</script>
<style>
/* .video-container {
  width: 90%;
  height: 700px;
  margin: 8px auto;
  border: 3px solid #000;
  position: relative;
  box-shadow: 1px 1px 1px #9e9e9e;
}
.video-here {
  width: 130px;
  position: absolute;
  left: 10px;
  bottom: 16px;
  border: 1px solid #000;
  border-radius: 2px;
  z-index: 2;
}
.video-there {
  width: 100%;
  height: 100%;
  z-index: 1;
}
.text-right {
  text-align: right;
} */
</style>
