<template>
<group-layout>
  <template #content>
  <div class="m-10">
    <div class="text-center px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20 bg-clip-padding bg-opacity-60 border border-gray-200" style="backdrop-filter: blur(20px);">
       <h1 class="text-2xl text-base  font-extrabold"> 알림 목록</h1>
  <ul class="flex flex-col divide-y w-full p-5">
    <li class="flex flex-row" v-for="notice in notices" :key="notice.id" @click="showThisNotice(notice) ">
      <group-notice v-if="notice.data.group" :notice="notice" />
      <user-notice v-else :notice="notice"/>
     <i @click="noticeRemove(notice.id)" class="fas fa-trash-alt fa-x self-center hover:bg-gray-50 "></i>
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
    <group-strat-modal :gruop="group"  @close="group=false"/>
   </template>
</group-layout>
</template>

<script>
import Button from '../../Jetstream/Button.vue'
import GroupLayout from './GroupLayout.vue'

import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import axios from 'axios'
import UserNotice from './UserNotice.vue'
import GroupNotice from './GroupNotice.vue'
import GroupStratModal from './GroupStratModal.vue'
import { Inertia } from '@inertiajs/inertia'
export default {
  props:['notices']
  ,
  data(){
    return{
      showNotice:false,
      userIn:false,
      group:false
    }
  },
  mounted(){
    this.$page.props.user.notice_number=0
  }
  ,
  methods:{
    noticeRemove(id){
      axios.delete('/notice/destroy/'+id)
      .then((res)=>{
        console.log('success')
      })
       Inertia.reload({ only: ['notices'] })
      // axios.delete()
    },
    showThisNotice(showNotice){
      showNotice.read_at=true;
      if(showNotice.data.group){
        this.group=showNotice.data
        return
      }
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
          Inertia.get('/group/show/'+this.showNotice.id)
        })
      }else{

          this.showNotice=false;
      }
    }
  }
  ,
  components: { Button
  ,GroupLayout,
  JetSecondaryButton,
  JetDialogModal,
  UserNotice,
  GroupNotice,
  GroupStratModal},

}
</script>
