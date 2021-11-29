<template>
<group-layout>
                      <template #content>
                       
  <div class="m-10">
    <div class="text-center px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20 bg-clip-padding bg-opacity-60 border border-gray-200" style="backdrop-filter: blur(20px);">
       <h1 class="text-2xl text-base  font-extrabold"> 알림 목록</h1>
  <ul class="flex flex-col divide-y w-full p-5">
    <li class="flex flex-row" v-for="notice in notices" :key="notice.id" @click="showThisNotice(notice)">
      <div class="select-none cursor-pointer hover:bg-gray-50 flex flex-1 items-center p-4">
        <div class="flex flex-col w-10 h-10 justify-center items-center mr-4">
          <a href="#" class="block relative">
            <img alt="profil"  :src="notice.data.offerUser_image?notice.data.offerUser_image:`https://ui-avatars.com/api/?name=${notice.data.offerUser_name}&color=7F9CF5&background=EBF4FF`"  class="mx-auto object-cover rounded-full h-10 w-10" />
          </a>
        </div>
        <div class="flex-1 pl-1 mr-16">
          <div class="font-medium dark:text-white">{{notice.data.offerUser_name}}</div>
          <!-- <div class="text-gray-600 dark:text-gray-200 text-sm">{{notice.data.offerGroup.introduction}}</div> -->
        </div>
       <div class="flex flex-col">
          <div v-if="!notice.read_at" class="text-red-500 text-bold"> NEW !</div>
          <div class="text-gray-600 dark:text-gray-200 text-xs">{{notice.created_at}}</div>
       </div>
      </div>
    </li>
  </ul>

</div>
</div>
<jet-dialog-modal :show="showNotice" @close="showNotice = false">
        <template #title>
             {{ showNotice.user.name }}의 메세지입니다
        </template>

        <template #content>
               <div class="w-full mx-3 overflow-hidden bg-white border rounded md:w-12/12 md:mx-0 lg:mx-0">
                <div class="flex justify-between w-full p-3">

                    <span class="px-2 rounded cursor-pointer hover:bg-gray-300"></span>
                    </div>
                        <!-- <img v-if="searchUser.image" class="w-full bg-cover" :src="'/storage/'+searchUser.image" />
                        <img v-else  src="/noimage.jpg" class="mx-auto w-20 h-20 rounded-full" :alt="searchUser.name"> -->
                    <div class="px-3 pb-2">
                    <div >
                            <span class="font-bold text-lg">그룹 이름</span>:
                      <span class="mr-1 font-black">{{showNotice.title}}</span>
                    </div>
                    <hr class="my-4">
                    
                   
                    <div class="my-4" >
                           <span class="font-bold text-lg">그룹소개</span><br>
                        <span>{{showNotice.introduction}}</span>
                    </div>
                    
                    </div>
                </div>
                       </template>

                     <template #footer>
                     <jet-secondary-button v-if="userIn" @click="confirm(true)" class="bg-green-300 w-1/5">
                            가입하기
                     </jet-secondary-button>

                     <jet-secondary-button @click="confirm(false)" class="bg-red-300 w-1/5">
                            닫기
                     </jet-secondary-button>
                     </template>
              </jet-dialog-modal>
   </template>
</group-layout>
</template>

<script>
import Button from '../../Jetstream/Button.vue'
import GroupLayout from './GroupLayout.vue'

import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import axios from 'axios'

import { Inertia } from '@inertiajs/inertia'
export default {
  props:['notices']
  ,
  data(){
    return{
      showNotice:false,
      userIn:false
    }
  },
  mounted(){
    this.$page.props.user.notice_number=0
  }
  ,
  methods:{
    showThisNotice(showNotice){
      showNotice.read_at=true;
      axios.get('/group/info/'+showNotice.data.offerGroup).
      then((res)=>{
        console.log(res.data)
         this.showNotice=res.data.group;
         this.userIn=res.data.userIn;
      })
     
    },
    confirm(check){
      if(check){
        
        axios.post('/group/userAdd',{
          groupId:this.showNotice.id
        }).then((response)=>{
          console.log(response.data)
        })
      }
        this.showNotice=false;
    }
  }
  ,
  components: { Button ,GroupLayout,JetSecondaryButton,JetDialogModal},
       
}
</script>