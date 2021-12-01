<template>
        <div class="select-none cursor-pointer hover:bg-gray-50 flex flex-1 items-center p-4">
        <div @click="$emit=showThisNotice(notice)" class="flex justis-start">
          <div class="flex flex-col w-10 h-10 justify-center items-center mr-4">
          <a href="#" class="block relative">
            <img alt="profil"  :src="`https://ui-avatars.com/api/?name=G&color=7F9CF5&background=1adc79`"  class="mx-auto object-cover rounded-full h-10 w-10" />
          </a>
        </div>
        <div class="flex-1 pl-1 mr-16">
          <div class="font-medium dark:text-white text-xl text-blod">{{notice.data.offerGroupTitle}}</div>
          <!-- <div class="text-gray-600 dark:text-gray-200 text-sm">{{notice.data.offerGroup.introduction}}</div> -->
        </div>
        </div>
       <div class="flex flex-col">
          <div v-if="!notice.read_at" class="text-red-500 text-bold"> NEW !</div>
          <div class="text-gray-600 dark:text-gray-200 text-xs">{{notice.created_at}}</div>
       </div>
      
      </div>
</template>

<script>
export default {
       props:['notice']
}
</script>