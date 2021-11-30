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
        </div>
    </div>
  </div>
  <group-reservation :show="show" @close="show=false"/>
  </template>
</group-layout>
</template>
<script>

import GroupLayout from './GroupLayout.vue'
import { Inertia } from '@inertiajs/inertia'
import GroupReservation from './GroupReservation.vue'
export default {
    props:['group'],
       components:{
              GroupLayout,
              GroupReservation
       },
       data(){
         return{
           show:false
         }
       }
       ,
       methods:{
          nowSatrt(){
             Inertia.get('/group/video/'+this.group.id)
          },
          dataClick(){
            this.show=true;
          }
       }

}
</script>