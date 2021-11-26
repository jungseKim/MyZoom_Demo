<template>
<group-layout>
                      <template #content>
                       
    <div class="flex flex-col container  mt-10 mx-auto w-full items-center justify-center bg-white dark:bg-gray-800 rounded-lg shadow">
       <h1 class="mx-auto bt-5 text-bold text-2xl"> 알림 목록</h1>
  <ul class="flex flex-col divide-y w-full p-5">
    <li class="flex flex-row" v-for="notice in notices" :key="notice.id">
      <div class="select-none cursor-pointer hover:bg-gray-50 flex flex-1 items-center p-4">
        <div class="flex flex-col w-10 h-10 justify-center items-center mr-4">
          <a href="#" class="block relative">
            <img alt="profil"  :src="notice.data.offerUser.image?notice.data.offerUser.image:`https://ui-avatars.com/api/?name=${notice.data.offerUser.name}&color=7F9CF5&background=EBF4FF`"  class="mx-auto object-cover rounded-full h-10 w-10" />
          </a>
        </div>
        <div class="flex-1 pl-1 mr-16">
          <div class="font-medium dark:text-white">{{notice.data.offerUser.name}}</div>
          <div class="text-gray-600 dark:text-gray-200 text-sm">{{notice.data.offerGroup.introduction}}</div>
        </div>
        <div class="text-gray-600 dark:text-gray-200 text-xs">{{notice.created_at}}</div>
      </div>
    </li>

  </ul>
</div>
   </template>
</group-layout>
</template>

<script>
import Button from '../../Jetstream/Button.vue'
import GroupLayout from './GroupLayout.vue'
export default {
  props:['notices']
  ,
  components: { Button ,GroupLayout},
       
}
</script>