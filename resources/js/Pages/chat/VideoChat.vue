<template>
<app-layout title="s">
  <!-- <div class="container"> -->
    <h1 class="text-center">Laravel Video Chat</h1>
    <div class="w-full flex flex-rows bg-gray-800">

      <div v-if="SharedScreen">
         <div class="flex flex-rows space-x-2 h-1/5">
              <div class="flex" v-for="user in users" :key="user.id">
              <video class="object-cover m-auto w-1/5" v-if="user.image"  :ref="user.name" autoplay :poster='`/storage/${user.image}`' :alt="user.name"></video>
              <video  class="object-cover m-auto w-1/5 " v-else  :ref="user.name" autoplay poster='/noimage.jpg'  :alt="user.name"></video>
                <h1>{{user.name}}</h1>
            </div>
         </div>
         <div>
             <video class="m-auto h-2/5 object-cover mb-20" ref="SharedScreen" autoplay></video>
         </div>
      </div>

      <div v-else  :class="userCheck?'w-3/4 bg-blue-500 grid  grid-cols-2 gap-4':'w-3/4 bg-red-500'" ref="main">
            <div class="flex" v-for="user in users" :key="user.id">
                  <video class="object-cover m-auto h-4/5" v-if="user.image"  :ref="user.name" autoplay :poster='`/storage/${user.image}`' :alt="user.name"></video>
                    <video class="object-cover m-auto h-4/5 " v-else   :ref="user.name" autoplay poster='/noimage.jpg'  :alt="user.name"></video>
                <h1>{{user.name}}</h1>
            </div>
            <div  class="flex">
                <!-- <p>my video</p> -->
                <video
                :class="userCheck?'m-auto  h-4/5 object-cover':'object-cover m-auto  w-3/5'"
                :poster="$page.props.user.profile_photo_path?`/storage/${$page.props.user.profile_photo_path}`:'/noimage.jpg'"
                ref="video-here" autoplay></video>
                <!-- <img :class="userCheck?`m-auto rounded-full object-cover h-64`:'m-auto rounded-full h-96'" v-else :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name"/> -->
            </div>
       </div>



        <video-set :show="show" :stream="streamPermision" @close="close"/>
       <div class="w-1/4 bg-red-400">
          <message-container :messages="messages" @messageSend="messageSend"/>
       </div>
    </div >
    <div class="fixed tod bottom-10 w-screen bg-gray-500 h-16 flex flex-row items-center">
        <button
        @click="start"
        class="p-2 pl-5 pr-5 bg-blue-500 text-gray-100 text-lg rounded-lg focus:border-4 border-blue-300">
         화면 공유</button>
        <button
        @click="closeVideo"
        class="p-2 pl-5 pr-5 bg-blue-500 text-gray-100 text-lg rounded-lg focus:border-4 border-blue-300">
         {{ activeVideo?'비디오 끄기':'비디오 켜기' }}</button>
          <button
          @click="closeAudio"
          class="p-2 pl-5 pr-5 bg-blue-500 text-gray-100 text-lg rounded-lg focus:border-4 border-blue-300">
         {{ activeVideo?'음소거':'오디오 키기' }}</button>
    </div>



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
  props: ['user','roomId','isManager'],
  data() {
    return {
      channel: null,
      stream: null,
      streamPermision:null,
      show:false,
      peers: {},
      users:[],
      messages:[],
      activeVideo:true,
      activeOudio:true,
      SharedScreen:false,
      SharedStream:null
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
        console.log(this.peers)
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
    async start(){
          const vm=this
          this.SharedScreen=true
          await navigator.mediaDevices.getDisplayMedia({
            video: true
          }).then(function(stream){
               const videoHere = vm.$refs['SharedScreen'];
               console.log(videoHere)
               console.log(stream)
               videoHere.srcObject =stream
              for(let i=0;i<vm.users.length;i++){
                vm.getPeer(vm.users[i].id,'SharedScreen',true,stream,'SharedScreen')
            }
          }).catch(function(e){
              console.log(e)
          });
          this.videoCom();
    //  document.documentElement.requestFullscreen()

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
    },
    videoCom(){
      if(!this.isManager){
        const share= this.$refs['SharedScreen']
        console.log(videoThere)
        share.srcObject=this.SharedStream
        console.log(this.SharedStream)

      }
        for(let i=0;i<this.users.length;i++){
            if(this.users[i].stream){
               const videoThere = this.$refs[this.users[i].name];
               videoThere.srcObject = this.users[i].stream;
            }
        }
    }
    ,
    getPeer(userId,userName, initiator,stream=this.stream,myName=this.user.name) {
      if(this.peers[userId+userName] === undefined) {
        let peer = new Peer({
          initiator,//이거때문에 시그널 바로실행
          stream: stream,
          trickle: false
        });
        peer.on('signal', (data) => {
          this.channel.whisper(`client-signal-${userId}`, {
            userId: this.user.id,
            userName:myName,
            data: data
          });

        })
        .on('stream', (stream) => {
          console.log('스트림 받아옴')
        //   this.users[userId].stream=stream;
      
        if(userName='SharedScreen'){
            this.SharedStream=stream
        }
        else{
          for(let i=0;i<this.users.length;i++){
            if(this.users[i].id==userId){
                this.users[i].stream=stream;
            }
        }
        }
        this.videoCom()

        //   const videoThere = this.$refs[userName];
        //   videoThere.srcObject = stream;
        //   console.log(videoThere)
        })
        .on('close', () => {
          const peer = this.peers[userId+userName];
          if(peer !== undefined) {
            peer.destroy();
          }
          console.log('피어 쪽닫힘')
          delete this.peers[userId+userName];
        });
        this.peers[userId+userName] = peer;
      }
      return this.peers[userId+userName];
    },
    close(permision){
        this.show=false;

        const videoHere = this.$refs['video-here'];
        videoHere.srcObject = this.streamPermision;


        if(!permision){
              this.closeVideo()
          }
          else{
            this.activeVideo=true
          }
       this.peerConnetion()


    },
    closeVideo(){
       const vm=this
         this.stream.getTracks().forEach(function(track) {
            if(track.kind=='video'){
                track.enabled=!track.enabled
                vm.activeVideo=track.enabled
                }
            });
    },
    closeAudio(){
      const vm=this
         this.stream.getTracks().forEach(function(track) {
            if(track.kind=='audio'){
                track.enabled=!track.enabled
                vm.activeOudio=track.enabled
                }
            });
    }

    ,
    async showVideo(){
      try{
        let streamPermision = await navigator.mediaDevices.getUserMedia({video:true,audio: true  });
        if(streamPermision){
          this.streamPermision=streamPermision
          this.stream=this.streamPermision
          this.show=true
        }
        else{
          this.stream=null
           this.peerConnetion()
        }
      }
      catch(err){
         try{
           this.streamPermision = await navigator.mediaDevices.getUserMedia({audio: true  });
          if(streamPermision){
            this.stream = streamPermision;
            this.peerConnetion()
            }
            else{
              this.stream=null
               this.peerConnetion()
            }
         }catch(err){
           this.peerConnetion()

         }
      }
    },
    peerConnetion(){
      for(let i=0;i<this.users.length;i++){
                this.getPeer(this.users[i].id,this.users[i].name,true)
            }
    }
    ,
    async setupVideoChat() {
    const vm=this
    this.channel=await window.Echo.join('presence-video-chat.'+this.roomId)
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
          vm.showVideo()
      })
      .joining((user) => {
          this.users.push(user)
          console.log("evnet !!!!!!!!!")
     })
      .leaving((user) => {
          this.users.splice(this.users.indexOf(user), 1);
        const peer = this.peers[user.id+user.name];
        if(peer !== undefined) {
            peer.destroy();
          }
          console.log('유저 나감')
          delete this.peers[user.id+user.name];
      })
      .listenForWhisper('client-signal-'+this.user.id,(signal)=>{
          console.log(signal)
        if(signal.userName=='SharedScreen'){
            this.SharedScreen=true
            const peer = this.getPeer(signal.userId,'SharedScreen' ,false,null,'SharedScreen');
           peer.signal(signal.data);
          }
          else{
            const peer = this.getPeer(signal.userId,signal.userName ,false);
            peer.signal(signal.data);
          }
           })
      .listenForWhisper('client-message-'+this.roomId,(message)=>{
                     console.log(message)
                     this.messages.push(message)
              });
      // this.showVideo()
    },
  }
};
</script>
