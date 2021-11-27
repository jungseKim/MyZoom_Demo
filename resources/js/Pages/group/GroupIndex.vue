<template>
       <group-layout>
       <template #content>
        <main  class="relative ">
        
          
                    <div class="h-20 w-full bg-pink-150">
                        <div class="text-2xl text-bold text-center font-mono text-white ">well come</div>
                    </div>
               
                    <div class="grid grid-cols-3 w-2/3 h-1/2 p-10">
                  <div class=" flex justify-center items-center" v-for="group in groups" :key="group.id">
                  <div class="container flex justify-center">
                    <div class="max-w-sm py-32">
                      <div class="bg-white relative shadow-lg hover:shadow-xl transition duration-500 rounded-lg">
                       <div class="grid grid grid-cols-2">
                          <img v-for="user in group.users" :key="user.id" class="object-cover w-2/3 mx-auto h-2/3 rounded-full" :src="user.profile_photo_url" />
                       </div>
                        <div class="py-6 px-8 rounded-lg bg-white">
                          <h1 class="text-gray-700 font-bold text-2xl mb-3 hover:text-gray-900 hover:cursor-pointer">{{group.title}}</h1>
                          <p class="text-gray-700 tracking-wide">{{group.introduction}}</p>
                          <button class="mt-6 py-2 px-4 bg-yellow-400 text-gray-800 font-bold rounded-lg shadow-md hover:shadow-lg transition duration-300">자세히 보기</button>
                        </div>
                        <div class="absolute top-2 right-2 py-2 px-4 bg-white rounded-lg">
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
export default {
       components:{
              GroupLayout
       },
       props:['groups']
}
</script>