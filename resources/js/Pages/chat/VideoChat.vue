<template>
<!-- <app-layout title="s"> -->
    <div class="w-full h-screen flex flex-rows p-10 bg-gray-700 justify-between" >

    <div v-if="SharedScreen" class="h-4/5 flex flex-col gap-x-4">
         <div class="flex flex-row justify-center gap-4   mt-0 pb-0 ">
              <div :class="userCheck?'flex flex-col w-1/6 mb-0 pb-0 border-2 rounded-lg':'flex flex-col w-1/12 mb-0 pb-0 border-2 rounded-lg'"
               v-for="user in users" :key="user.id">
              <video class="object-cover h-full  w-full"  :ref="user.name" autoplay :poster="user.image?`/storage/${user.image}`:'/noimage.jpg'" :alt="user.name"></video>
               <div class="flex justify-center " >
                <div></div>
                <h1 class=" font-bold text-lg text-white" >{{user.name}}</h1>
                <i v-if="!user.activeOudio" class="fas fa-microphone-slash "></i>
                <i v-else class="fas fa-microphone"></i>
                </div>
               </div>
             <div :class="userCheck?'flex flex-col w-1/6 mb-0 pb-0 border-2 rounded-lg':'flex flex-col w-1/12 mb-0 pb-0 border-2 rounded-lg'"
             >
               <video
                class="object-cover h-full  w-full"
                :poster="$page.props.user.profile_photo_path?`/storage/${$page.props.user.profile_photo_path}`:'/noimage.jpg'"
                ref="video-here" autoplay></video>
                 <div class="flex  justify-center" >
                <div></div>
                <h1 class=" font-bold text-lg text-white" >my video</h1>
                <i v-if="!activeOudio" class="fas fa-microphone-slash"></i>
                <i v-else class="fas fa-microphone "></i>
                </div>
             </div>
         </div>
         <div class="flex flex-col  p-5 ">
            <h1 class=" font-bold text-lg text-white text-center" >share Video</h1>
             <video class="border-4 m-auto w-3/5  h-7/8 object-cover mb-20" ref="SharedScreen" autoplay muted></video>
         </div>
      </div>

      <div v-else-if="userCheck"  class="w-3/4 h-1/2  grid  grid-cols-2 gap-4 p-3" ref="main">
            <div class="flex flex-col border-2 rounded-lg " v-for="user in users" :key="user.id">
                  <video class="object-cover m-auto w-2/5  h-4/5"   :ref="user.name" autoplay :poster="user.image?`/storage/${user.image}`:'/noimage.jpg'" :alt="user.name"></video>
                <div class="flex justify-between p-7 " >
                <div></div>
                <h1 class=" font-bold text-2xl text-white" >{{user.name}}</h1>
                <i v-if="!user.activeOudio" class="fas fa-microphone-slash fa-2x"></i>
                <i v-else class="fas fa-microphone fa-2x"></i>
                </div>
                <!-- <div v-if="user.audioActive">트루</div> -->
            </div>
            <div  class="flex flex-col border-2 rounded-lg ">
                <!-- <p>my video</p> -->
                <video
                :class="userCheck?'m-auto w-2/5  h-4/5 object-cover ':'object-cover m-auto  h-2/5'"
                :poster="$page.props.user.profile_photo_path?`/storage/${$page.props.user.profile_photo_path}`:'/noimage.jpg'"
                ref="video-here" autoplay></video>
                 <div class="flex justify-between p-7 " >
                <div></div>
                <h1 class=" font-bold text-2xl text-white" >my video</h1>
                <i v-if="!activeOudio" class="fas fa-microphone-slash fa-2x"></i>
                <i v-else class="fas fa-microphone fa-2x color-white" ></i>
                </div>
            </div>
       </div>
     
      <div v-else  class="w-3/4 h-1/2  grid  grid-cols-3 gap-4 p-3" ref="main">
          <div class="flex flex-col border-2 rounded-lg " v-for="user in users" :key="user.id">
                <video class="object-cover m-auto w-2/5  h-4/5"   :ref="user.name" autoplay :poster="user.image?`/storage/${user.image}`:'/noimage.jpg'" :alt="user.name"></video>
              <div class="flex justify-between p-7 " >
              <div></div>
              <h1 class=" font-bold text-2xl text-white" >{{user.name}}</h1>
              <i v-if="!user.activeOudio" class="fas fa-microphone-slash fa-2x"></i>
              <i v-else class="fas fa-microphone fa-2x"></i>
              </div>
              <!-- <div v-if="user.audioActive">트루</div> -->
          </div>
          <div  class="flex flex-col border-2 rounded-lg ">
              <!-- <p>my video</p> -->
              <video
              class="m-auto w-2/5  h-4/5 object-cover"
              :poster="$page.props.user.profile_photo_path?`/storage/${$page.props.user.profile_photo_path}`:'/noimage.jpg'"
              ref="video-here" autoplay></video>
                <div class="flex justify-between p-7 " >
              <div></div>
              <h1 class=" font-bold text-2xl text-white" >my video</h1>
              <i v-if="!activeOudio" class="fas fa-microphone-slash fa-2x"></i>
              <i v-else class="fas fa-microphone fa-2x color-white" ></i>
              </div>
          </div>
      </div>
       


        <video-set :show="show" :stream="streamPermision" @close="close"/>
       <div class="w-1/6  ">
          <message-container class="h-full " ref="messages" :users="users" :user="user" :messages="messages" @messageSend="messageSend" />
       </div>
    </div >
    <div class="fixed tod bottom-10 w-4/5 bg-gray-500 h-16 flex flex-row gap-x-2 items-center rounded-lg  justify-between mx-10">
        <div class="flex gap-x-2">
            <button
        @click="closeVideo"
        class="p-2 pl-5 pr-5 bg-blue-500 text-gray-100 text-lg rounded-lg focus:border-4 border-blue-300">
         {{ activeVideo?'비디오 끄기':'비디오 켜기' }}</button>
          <button
          @click="closeAudio"
          class="p-2 pl-5 pr-5 bg-blue-500 text-gray-100 text-lg rounded-lg focus:border-4 border-blue-300 ">
         {{ activeVideo?'음소거':'오디오 키기' }}</button>
        </div>
        <div class="flex flex-row gap-x-2 items-center">
          <button
        v-if="isManager"
        @click="copyPath"
        class="self-start p-2 pl-5 pr-5 bg-blue-500 text-gray-100 text-lg rounded-lg focus:border-4 border-blue-300">
         링크 복사</button>
            <button
        v-if="isManager"
        @click="start"
        class="self-start p-2 pl-5 pr-5 bg-blue-500 text-gray-100 text-lg rounded-lg focus:border-4 border-blue-300">
         화면 공유</button>
            <i class="fas fa-sign-out-alt fa-2x mr-2" @click="exit"></i>
            <!-- <i class="fas fa-door-open fa-2x mr-2"></i> -->
        </div>
    </div>



<!-- </app-layout> -->
</template>
<script>
import Peer from 'simple-peer';
import AppLayout from '@/Layouts/AppLayout.vue'
import axios from 'axios'
import MessageContainer from './MessageContainer.vue';
import Button from '../../Jetstream/Button.vue';
import VideoSet from './VideoSet.vue'
import { Inertia } from '@inertiajs/inertia'
export default {
  props: ['user','roomId','isManager','isGest'],
  data() {
    return {
      channel: null,
      stream: null,
      streamPermision:null,
      show:false,
      peers: {},
      users:{},
      messages:[],
      activeVideo:true,
      activeOudio:true,
      SharedScreen:false,
      SharedStream:null,
    }
  },
   components:{
      AppLayout,
      MessageContainer,
      Button,
      VideoSet
    }
  ,
  beforeUnmount(){
      this.RoomOut();


  },
  mounted() {
    //   window.document.documentElement.requestFullscreen()
    this.setupVideoChat()

    window.addEventListener('beforeunload', this.RoomOut)
  }
  ,
  computed:{
    userCheck(){
      let i=0;
      for(let key in this.users){
        i+=1;
        if(i>3){
          return false
        }
      }
      return true
    }
  },
  methods: {
    async copyPath() {
          
          let key=await axios.get('/group/path/'+this.roomId);
          
          const t = document.createElement("textarea");
          document.body.appendChild(t);
          t.value = window.document.location.href+'?thiskey='+key.data;
          t.select();
          document.execCommand('copy');
          document.body.removeChild(t);
          alert('복사 되었습니다.')
      },
    exit(){
      if(this.isGest){
        //  axios.delete('/gest/out/'+this.user.id)
         Inertia.get('/gest/out/'+this.roomId)
  }
   else{
        Inertia.get('/group/index')
   }
    },
    messageSend(content){
        console.log(this.peers)
        this.channel.whisper('client-message-'+this.roomId, {
              userId: this.user.id,
              userName:this.user.name,
              image:this.$page.props.user.profile_photo_url,
              data:content
           });
        this.messages.push({
             userId: this.user.id,
              userName:this.user.name,
              data:content})
          this.messageScroll()
    },
    messageScroll(){
      const vm=this
      setTimeout(function() {
      const messages=vm.$refs.messages
    messages.scrollToEnd()
    }, 300);
    }
    ,
    async start(){
          const vm=this
          if(!this.SharedScreen){
          await navigator.mediaDevices.getDisplayMedia({
            video: true
          }).then(function(stream){
             vm.SharedScreen=true
            vm.SharedStream=stream
             for(let key in vm.users){
               const user=vm.users[key]
              vm.getPeer(user.id,'SharedScreen',true,stream,'SharedScreen')
             }
          }).catch(function(e){
              console.log(e)
          });
          }else{
              this.SharedScreen=false
              this.SharedStream.getTracks().forEach(function(track) {
                track.stop();
                });
              this.SharedStream=null
            for(let key in this.users){
               const user=this.users[key]
              this.peers[user.id+'SharedScreen'].destroy()
            delete this.peers[user.id+'SharedScreen'];
             }
          }
        //   let vm=this;
          setTimeout(function() {
            vm.videoCom()}, 300);
        //   setTimeout()

    //  document.documentElement.requestFullscreen()

    },
    RoomOut(){
      window.Echo.leave('presence-video-chat.'+this.roomId);
   if(this.stream){
      this.stream.getTracks().forEach(function(track) {
    track.stop();
    });
   }

    for (let key in this.peers) {
                const p = this.peers[key]
                p.destroy()
                delete this.peers[key]
             }
             if(this.isGest){
        //  axios.delete('/gest/out/'+this.user.id)
         Inertia.get('/gest/out/'+this.roomId)
  }
  
    },
    videoCom(check){
      if(this.SharedScreen ){
        const share= this.$refs['SharedScreen']
        if(!share.srcObject){
          share.srcObject=this.SharedStream
          share.muted = true;
          share.play()
        }
        console.log(share.srcObject)

      }
      if(this.stream){
        const videoHere = this.$refs['video-here'];
        videoHere.srcObject = this.stream;
         videoHere.muted=true;

      }

        for(let key in this.users){
          const user=this.users[key]
          // console.log(user)
           if(user.stream){
               const videoThere = this.$refs[user.name];
               videoThere.srcObject = user.stream;
               console.log(videoThere)
            }
        }
    }
    ,
    getPeer(userId,userName, initiator,stream=this.stream,myName=this.user.name) {
      if(this.peers[userId+userName] === undefined) {
        let peer = new Peer({
          initiator,//이거때문에 시그널 바로실행
          stream: stream,
          trickle: false,
	config:{ iceServers: [
        {
        url: 'turn:numb.viagenie.ca',
        credential: 'muazkh',
        username: 'webrtc@live.com'
},
{
        url: 'turn:numb.viagenie.ca:3478?transport=udp',
        credential: 'JZEOEt2V3Qb0y27GRntt2u2PAYA=',
        username: '28224511:1379330808'
},
{
        url: 'turn:numb.viagenie.ca?transport=tcp',
        credential: 'JZEOEt2V3Qb0y27GRntt2u2PAYA=',
        username: '28224511:1379330808'
}
]
}
        });
        peer.on('signal', (data) => {
          this.channel.whisper(`client-signal-${userId}`, {
            userId: this.user.id,
            userName:myName,
            data: data,
            activeOudio:this.activeOudio
          });

        })
        .on('stream', (stream) => {

        if(userName=='SharedScreen'){
            console.log("ddkdkdkd")
            this.SharedStream=stream
            console.log(this.SharedStream)
            this.videoCom(true)
        }
        else{
              for(let key in this.users){
                const user=this.users[key]
                if(user.id==userId){
                      user.stream=stream;
                      console.log(user)
                  }
              }
        this.videoCom(false)
        }
       })
        .on('close', () => {
          const vm=this
          if(userName=='SharedScreen' && !this.isManager){
            console.log('공유중지')
            this.SharedScreen=false
            this.SharedStream=null
            setTimeout(function() {
            vm.videoCom()}, 300);
          }
          // const peer = this.peers[userId+userName];

          // if(peer !== undefined) {
          //   peer.destroy();
          // }
          console.log('피어 쪽닫힘')
          delete this.peers[userId+userName];
        })
        .on('error', (err) => {
          console.log(err.message)
        });
        this.peers[userId+userName] = peer;
      }
      return this.peers[userId+userName];
    },

    close(permision){
        this.show=false;

        if(!permision){
              this.closeVideo()
      const videoHere = this.$refs['video-here'];
         videoHere.srcObject = this.streamPermision;
          videoHere.muted=true;
      }
          else{
             const videoHere = this.$refs['video-here'];
        videoHere.srcObject = this.streamPermision;
            videoHere.muted=true;
            this.activeVideo=true
          }
       this.peerConnetion()


    },
    closeVideo(){
       const vm=this
         try{
           this.stream.getTracks().forEach(function(track) {
            if(track.kind=='video'){
                track.enabled=!track.enabled
                vm.activeVideo=track.enabled
                }
            });
        } catch(err){
       alert('비디오 장치가 없습니다')
     }
    },
    closeAudio(){
      const vm=this
     try{
           this.stream.getTracks().forEach(function(track) {
            if(track.kind=='audio'){
                track.enabled=!track.enabled
                vm.activeOudio=track.enabled

                vm.channel.whisper('client-media-'+vm.roomId, {
                userId: vm.user.id,
                activeOudio:vm.activeOudio
           });
                }
            });
     }
     catch(err){
       alert('오디오장치가 없습니다')
     }


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
        this.activeVideo=false
         try{
           this.streamPermision = await navigator.mediaDevices.getUserMedia({audio: true  });
          if(this.streamPermision){
            this.stream = this.streamPermision;
            this.peerConnetion()
            }
            else{
              this.activeOudio=false
              this.stream=null
               this.peerConnetion()
            }
         }catch(err){
            this.activeOudio=false
           this.peerConnetion()

         }
      }
    },
    peerConnetion(){
      for(let key in this.users){
        const user=this.users[key]
          this.getPeer(user.id,user.name,true)
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
                    this.users[users[i].id]=users[i]
                }
            }
          }
          vm.showVideo()
      })
      .joining((user) => {
          // this.users.push(user)
          const vm=this
          this.users[user.id]=user
          if(this.SharedStream && this.isManager){
             vm.getPeer(user.id,'SharedScreen',true,vm.SharedStream,'SharedScreen')


          }
     })
      .leaving((user) => {
          // this.users.splice(this.users.indexOf(user), 1);
          delete this.users[user.id]
        if (this.isManager){
          // const peer = this.peers[user.id+'SharedScreen'];
          //    if(peer !== undefined) {
          //      peer.destroy();
          // }
            delete this.peers[user.id+'SharedScreen'];
        }
          // const peer = this.peers[user.id+user.name];
          //   peer.removeAllListeners('close')
        // if(peer !== undefined) {
        //     peer.destroy();
        //   }
          console.log('유저 나감')

          delete this.peers[user.id+user.name];
      })
      .listenForWhisper('client-signal-'+this.user.id,(signal)=>{
          this.users[signal.userId].activeOudio=signal.activeOudio

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
                      this.messageScroll()
              })
        .listenForWhisper('client-media-'+this.roomId,(data)=>{
              console.log(data)
               this.users[data.userId].activeOudio=data.activeOudio
        });

    },
  }
};
</script>
