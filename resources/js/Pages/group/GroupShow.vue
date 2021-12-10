<template >
<group-layout>
       <template #content>
              
   <div class="m-10">
    <div class=" px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20 bg-clip-padding bg-opacity-60 border border-gray-200" style="backdrop-filter: blur(20px);">
     <div class="mx auto text-center border-2 rounded-full p-2 border-purple-100 bg-purple-100">
        <span class="text-2xl text-base  font-extrabold">{{group.title}}의 그룹 </span>
     </div>
      <div class="max-w-md mx-auto">
        
        <div class="divide-y divide-gray-200">
          <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
            <div class="text-center"><p class="font-bold text-xl ">그룹원</p></div>
            <ul class="list-disc space-y-2 divide-y-2 divide-border-black rounded-md  p-2  border-2  p-5">
              <li v-for="user in group.users" :key="user.id" class="flex items-start">
                <!-- <span class="h-6 flex items-center sm:h-7">
                  <svg class="flex-shrink-0 h-5 w-5 text-cyan-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                  </svg>
                </span> -->
                <img :src="user.profile_photo_url" class="w-16 h-16 rounded-full">
                <p class="m-auto text-2xl font-bold">
                  {{ user.name }}
                </p>
              </li>
            </ul> 
          </div>
          
        </div>
      </div>
      <div class="pt-6 text-base leading-6 font-bold sm:text-lg sm:leading-7">
            <!-- <p>See me on <a class="font-bold text-blue-700" href="https://www.linkedin.com/in/ferdianar/"> LinkedIn </a></p> -->
            <div class="text-center"><p class="font-bold text-xl text-base ">소개말</p></div>
           <div class="rounded-md  p-2  border-2  p-5  text-center">

            <p class="text-cyan-600">
                {{ group.introduction }}
                </p>
           </div>
          </div>
        <div class="flex m-5 items-center space-x-10">
         <button v-if="group.user_id==$page.props.user.id" @click="nowSatrt" class="py-3 px-6 text-white rounded-lg bg-gray-500 shadow-lg block md:inline-block">바로시작</button>
           <button @click="dataClick" v-if="group.user_id==$page.props.user.id" class="py-3 px-6 text-white rounded-lg bg-gray-500 shadow-lg block md:inline-block">예약하기</button>
          <user-search-modal :searchUser="searchUser" @close="searchUser=false" @userAdd="userAdd()" />
        </div>
        <div class="text-center"><p class="font-bold text-xl ">유저 초대</p></div>
         <div class="flex flex-rows" v-if="group.user_id==$page.props.user.id">
                <input id="title" class="w-full" type="text" v-model="name" ref="inputs" @keyup.enter="search"><i @click="search()" class="fas fa-search fa-2x"></i>
           </div>
          
        <div class="text-center"><p class="font-bold text-xl ">회의기록</p></div>
            <ul class="list-disc space-y-2 divide-y-2 divide-border-black rounded-md  p-2  border-2  p-5">
              <li  v-for="re in reservations" :key="re.id" class="flex items-start">
                <p v-if="nowTime(re.Time)" class="m-0 text-xl text-red-700">예약중 </p>
                <p class="m-auto text-2xl font-bold">
                  {{ re.Time }}
                </p>
                <i v-if="group.user_id==$page.props.user.id && nowTime(re.Time)" @click="cancle(re)" class="fas fa-times self-center"></i>
              </li>
            </ul> 


         <div   @click="GroupRemove" class="mt-5 flex flex-row-reverse">
           <i  class="fas fa-trash-alt fa-2x self-center hover:bg-red-300 "></i>
         </div>
    </div>
  </div>
  <group-reservation :show="show" :groupId="group.id" @close="close"/>
  </template>
</group-layout>
</template>
<script>

import GroupLayout from './GroupLayout.vue'
import { Inertia } from '@inertiajs/inertia'
import UserSearchModal from  './UserSearchModal.vue'
import GroupReservation from './GroupReservation.vue'
import axios from 'axios'
export default {
    props:['group','reservations'],
       components:{
              GroupLayout,
              GroupReservation,
              UserSearchModal
       },
       data(){
         return{
           show:false,
           nama:null,
           searchUser:null
         }
       }
       ,
       methods:{
         cancle(re){
           const vm=this;
           axios.delete('/notice/cancle/'+re.id).
           then((res)=>{
             console.log(res)
             vm.$inertia.reload(['reservations'])
           })
         },
         close(){
           this.show=false;
           this.$inertia.reload(['reservations'])
         },
          nowTime(t){
            var re = new Date(t);
            var now = new Date();
            if(re>now){
              return true;
            }
            else{
              return false;
            }
          },  
          nowSatrt(){
             Inertia.get('/group/video/'+this.group.id)
          },
          dataClick(){
            this.show=true;
          },
          GroupRemove(){
            Inertia.delete('/group/destroy/'+this.group.id)
          },
          search(){
                    if(this.name==this.$page.props.user.name){
                          return alert('자신을 초대할 수없습니다.')
                    }
                    axios.get('/group/search', {
                          params: {
                          name: this.name
                          }
                    }).then(response=>{
                          console.log(response.data)
                          if(response.data==404){
                                return alert('없는 회원입니다')
                          }
                          this.searchUser=response.data
                    }).catch((err)=>{
                          console.log(err)
                    })
            },
            userAdd(){
              axios.post('/group/eazyAdd/'+this.group.id,{
                user_id:this.searchUser.id
              }).then((res)=>{
                console.log(res.data)
                if(res.data==300){
                  return alert('이미 그룹내에 포함 되어있습니다')
                }
                return alert('가입신청을 전송하였습니다.')
              })
            this.name=null;
            this.searchUser=false
            }
            
          
       }

}
</script>