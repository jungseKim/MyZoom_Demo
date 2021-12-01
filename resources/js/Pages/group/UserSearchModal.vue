<template>
       <jet-dialog-modal :show="searchUser" >
        <template #title>
             유저정보
        </template>

        <template #content>
               <div class="w-full mx-3 overflow-hidden bg-white border rounded md:w-12/12 md:mx-0 lg:mx-0">
                <div class="flex justify-between w-full p-3">

                    <span class="px-2 rounded cursor-pointer hover:bg-gray-300"></span>
                    </div>
                        <img v-if="searchUser.image" class="w-full bg-cover" :src="'/storage/'+searchUser.image" />
                        <img v-else  src="/noimage.jpg" class="mx-auto w-20 h-20 rounded-full" :alt="searchUser.name">
                    <div class="px-3 pb-2">
                    <div class="flex flex-row items-center mt-2">
                    </div>
                    <hr class="my-4">
                    <div >
                            <span class="font-bold text-lg">이름</span><br>
                      <span class="mr-1 font-black">{{searchUser.name}}</span>
                    </div>
                   
                    <div class="my-4" >
                           <span class="font-bold text-lg">이메일</span><br>
                        <span>{{searchUser.email}}</span>
                    </div>
                    
                    </div>
            </div>
                     </template>

                     <template #footer>
                     <jet-secondary-button @click="$emit=userAdd">
                            초대하기
                     </jet-secondary-button>
                     </template>
              </jet-dialog-modal>
</template>

<script>
export default {
       props:['searchUser']
}
</script>