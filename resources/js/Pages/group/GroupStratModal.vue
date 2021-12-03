<template>
       <jet-dialog-modal :show="gruop" @close="gruop = false ">
        <template #content>
               <div class="w-full mx-3 overflow-hidden bg-white border rounded md:w-12/12 md:mx-0 lg:mx-0">
                <div class="flex justify-between w-full p-3">

                    <span class="px-2 rounded cursor-pointer hover:bg-gray-300"></span>
                    </div>
                    <div class="px-3 pb-2">
                    <div class="text-center">
                           <span class="font-bold text-lg bg-gray-100">회의시작</span>
                    <hr class="my-4">
                            <span class="font-bold text-lg">Group: {{ gruop.offerGroupTitle }} </span>
                      <!-- <span class="mr-1 font-black">{{showNotice.offerGroup.title}}</span> -->
                    </div>


                    </div>
                </div>
                       </template>

                     <template #footer>
                     <div class="flex items-center">
                            <button @click="Move(true)" class="bg-green-300 w-2/5">
                           참가하기
                     </button>

                     <button @click="Move(false)" class="bg-red-300 w-2/5">
                            닫기
                     </button>
                     </div>
                     </template>
              </jet-dialog-modal>
</template>

<script>
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import { Inertia } from '@inertiajs/inertia'
export default {
       props:['gruop'],
       components:{
              JetDialogModal
       },
       methods:{
              Move(check){
                     if(check){
                      Inertia.get('/group/video/'+this.group.offerGroupId)
                     }
                     this.$emit('close');
              }
       }
}
</script>
