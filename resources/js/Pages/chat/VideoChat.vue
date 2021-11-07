<template>
<app-layout title="s">
  <!-- <div class="container"> -->
    <h1 class="text-center">Laravel Video Chat</h1>
    <div class="w-full flex flex-rows bg-gray-800">
      <div  :class="userCheck?'w-3/4 bg-blue-500 grid  grid-cols-2 gap-4':'w-3/4 bg-red-500'" ref="main">
            <div class="flex" v-for="user in users" :key="user.id">
                <p>{{user.name}}</p>
              <video class="object-cover m-auto h-56" v-if="user.image"  :ref="user.name" autoplay :poster='`/storage/${user.image}`' :alt="user.name"></video>
              <video  class="object-cover m-auto h-56 " v-else  :ref="user.name" autoplay poster='/noimage.jpg'  :alt="user.name"></video>
            </div>
            <div  class="flex">
                <!-- <p>my video</p> -->
                <video
                :class="userCheck?'m-auto max-w-56 h-56 object-cover':'object-cover m-auto h-96'"
                :poster="$page.props.user.profile_photo_path?`/storage/${$page.props.user.profile_photo_path}`:'/noimage.jpg'"
                ref="video-here" autoplay></video>
                <!-- <img :class="userCheck?`m-auto rounded-full object-cover h-64`:'m-auto rounded-full h-96'" v-else :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name"/> -->
            </div>
       </div>
        <video-set :show="show" :stream="streamPermision" @close="close"/>
       <div class="w-1/4 bg-red-400">
          <message-container :messages="messages" @messageSend="messageSend"/>
        <button
        @click="showVideo"
        class="p-2 pl-5 pr-5 bg-blue-500 text-gray-100 text-lg rounded-lg focus:border-4 border-blue-300">
          비디오 켜기</button>
       </div>
        <button
        @click="closeVideo"
        class="p-2 pl-5 pr-5 bg-blue-500 text-gray-100 text-lg rounded-lg focus:border-4 border-blue-300">
          비디오 끄기</button>

    </div>



    <!-- <div v-for="user in users" :key="user.id">
        <h1 :ref="user.name">{{user.name}}</h1>
         </div> -->
    <button @click="start">test</button>
  <!-- </div> -->
</app-layout>
</template>
<script>
import Peer from 'simple-peer';
import AppLayout from '@/Layouts/AppLayout.vue'
import axios from 'axios'
import MessageContainer from './MessageContainer.vue';
import Button from '../../Jetstream/Button.vue';
import VideoSet from './VideoSet.vue'
export default {
  props: ['user','roomId'],
  data() {
    return {
      channel: null,
      stream: null,
      streamPermision:null,
      show:false,
      peers: {},
      users:[],
      messages:[],
    }
  },
   components:{
      AppLayout,
      MessageContainer,
      Button,
      VideoSet
    },

  beforeUnmount(){
      this.RoomOut();
    window.Echo.leave('presence-video-chat.'+this.roomId);

  },
  mounted() {
    this.setupVideoChat()
  }
  ,
  computed:{
    userCheck(){
      if(this.users.length){
        return true
      }else{
        return false
      }
    }
  },
  methods: {
    messageSend(content){
        this.channel.whisper('client-message-'+this.roomId, {
              userId: this.user.id,
              userName:this.user.name,
              data:content
           });
        this.messages.push({
             userId: this.user.id,
              userName:this.user.name,
              data:content})
    },
    start(){
      console.log(this.channel)
      console.log(this.$refs.main.class)
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


        })
        .on('stream', (stream) => {
          const videoThere = this.$refs[userName];
          videoThere.srcObject = stream;
          console.log(stream)
        })
        .on('close', () => {
          const peer = this.peers[userId];
          if(peer !== undefined) {
            peer.destroy();
          }
          console.log('피어 쪽닫힘')
          delete this.peers[userId];
        });
        this.peers[userId] = peer;
      }
      return this.peers[userId];
    },
    close(permision){
        this.show=false;
        if(permision){
          const videoHere = this.$refs['video-here'];
          videoHere.srcObject = this.streamPermision;
          this.stream=this.streamPermision

         for(let i=0;i<this.users.length;i++){
                this.getPeer(this.users[i].id,this.users[i].name,true)

           }
        }
        
    },
    closeVideo(){
        let acc=null;
         this.stream.getTracks().forEach(function(track) {
            if(track.kind=='video'){
                acc=track
                track.enabled=!track.enabled
            }

            });
            console.log(acc.enabled)
    }
    ,
    async showVideo(){
      try{
        const streamPermision = await navigator.mediaDevices.getUserMedia({video:true,audio: true  });
        if(streamPermision){
          this.streamPermision=streamPermision
          this.show=true
        }
        else{
          this.stream=null
        }
      }catch(err){
       this.stream = null;
      //  alert('비디오가 없음니다')
      }

    },
    async setupVideoChat() {
      
      this.showVideo()

       this.channel=window.Echo.join('presence-video-chat.'+this.roomId)
        .here((users) => {
         console.log(users)
          if(users){
            for(let i=0;i<users.length;i++){
                if(this.user.id!=users[i].id){
                    console.log(users[i])
                    this.users.push(users[i])
                    //  this.getPeer(users[i].id,users[i].name,true)
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
        const peer = this.peers[user.id];
        if(peer !== undefined) {
            peer.destroy();
          }
          console.log('유저 나감')
          delete this.peers[user.id];
      })
      .listenForWhisper('client-signal-'+this.user.id,(signal)=>{
          const peer = this.getPeer(signal.userId,signal.userName ,false);
          peer.signal(signal.data);
           })
      .listenForWhisper('client-message-'+this.roomId,(message)=>{
                     console.log(message)
                     this.messages.push(message)
              });

    },
  }
};
</script>
