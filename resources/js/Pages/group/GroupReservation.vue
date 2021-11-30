<template>
       <!-- component -->
        <jet-dialog-modal :show="show" @close="close">
                <template #content>
              <div class="flex flex-rows gap-x-3 ">
              <span class="text-center text-lg text-bold">{{year}}년</span>
              <span class="text-center text-lg text-bold">{{month}}월</span>
              <span class="text-center text-lg text-bold">{{day}}일</span>
                 <select name="hours">
                     <option v-for="hours in hourses" :key="hours" :value="hours">{{ hours }}</option>
              </select>
                     <span>시</span>
              <select name="minute">
                     <option v-for="minute in minutes" :key="minute" :value="minute">{{ minute }}</option>
              </select>
                        <span>분</span>
              </div>
               </template>
                 <template #footer>
                        <div class="flex">
                               <button class="bg-green-300 w-1/5" @click="confirm(false)">
                                    예약 완료
                               </button>

                               <button class="bg-red-300 w-1/5" @click="confirm(false)">
                                    예약 취소
                               </button>
                        </div>
                 </template>
         </jet-dialog-modal>
</template>

<script>

import JetDialogModal from '@/Jetstream/DialogModal.vue'
import { computed } from '@vue/reactivity'
export default {
       props:['show'],
       data(){
              return{
                     year:null,
                     month:null,
                     day:null,
                     hourses:[],
                     minutes :[]
              }
       },
       components:{
              JetDialogModal
       },
       methods:{
       confirm(check){
              //라우터 부터 만들고 시작
                     // if(){
                            
                     // }
                     
              },
              close(){
            // this.closeable=true;
            this.$emit('close')
       },

       }
       ,mounted(){
              let today = new Date();

              this.year = today.getFullYear(); // 년도
              this.month = today.getMonth() + 1;  // 월
              this.date = today.getDate();  // 날짜
              let day = today.getDay();  // 요일
              let hours = today.getHours(); // 시
              let minute = today.getMinutes();  
             
              for(let i=hours ; i<25;i++){
                     this.hourses.push(i)
              }
              for(let i=minute ; i<61;i++){
                     this.minutes.push(i)
              }

       }
}
</script>