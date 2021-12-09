<template>
       <group-layout>
       <template #content>
        <main  class="m-auto ">
          <div class="grid grid-cols-3 w-full h-1/2 p-10 gap-x-8 ">
                  <div class=" flex justify-center items-center  "  v-for="group in groups" :key="group.id" @click="move(group.id)"  >
                  <div class="container flex justify-center">
                    <div class="max-w-sm ">
                      <div class="bg-yellow-300 hover:bg-yellow-500  shadow-lg hover:shadow-xl transition duration-500 rounded-lg">
                       <div class="grid grid grid-cols-2 h-40 w-40">
                          <img v-for="user in group.users" :key="user.id" class="object-cover  mx-auto  rounded-full" :src="user.profile_photo_url" />
                       </div>
                        <div class="rounded-lg bg-white text-center">
                          <p class="text-gray-700 tracking-wide font-bold">그룹명</p>
                          <hr class="bg-yellow-300">
                          <h1 class="text-gray-700 font-bold text-xl mb-3 hover:text-gray-900 hover:cursor-pointer">{{format(group.title)}}</h1>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

          </main>
          </template>
       </group-layout>
</template>
<script>
import GroupLayout from './GroupLayout.vue'
import { Inertia } from '@inertiajs/inertia'
export default {
       components:{
              GroupLayout
       },
       props:['groups'],
       methods:{
         move(id){
            Inertia.get('/group/show/'+id)
         },
         format(title){
             if(title.length>6){
                  return title.slice(0,6)+'..'
             }
             return title
         }
       }
}
</script>
