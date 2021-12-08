<template>
       <!-- component -->
        <jet-dialog-modal :show="show" @close="close" >
                <template #content>
                       <div class="m-10">
                     <span class="text-2xl font-black ">{{year}}년</span>
                     <span class="text-2xl font-black ">{{month}}월</span>
                     <span class="text-2xl font-black ">{{day}}일</span>
                       </div>
              <div class="flex flex-row">
                     <div class="flex flex-row">
                     <select name="hours" @change="setH($event)">
                            <option v-for="hours in hourses" :key="hours" :value="hours">{{ hours }}</option>
                     </select>
                            <p class="text-xl font-black">시 </p>
                     </div> 
                     <div class="flex flex-row">
                     <select name="minute" @change="setM($event)">
                            <option v-for="minute in minutes" :key="minute" :value="minute">{{ minute }}</option>
                     </select>
                     <p class="text-xl font-black">분 </p>
              
                     </div>     
                      <p class="text-xl font-black"> 뒤 시작</p>     
               </div>
               </template>
                 <template #footer>
                        <div class="flex ">
                               <button @click="confirm(true)"
                               class="bg-indigo-600 hover:bg-blue-dark text-white font-bold py-3 px-6 rounded">
                                    예약 완료
                               </button>

                               <button @click="confirm(false)"
                               class="bg-indigo-600 hover:bg-blue-dark text-white font-bold py-3 px-6 rounded" >
                                    예약 취소
                               </button>
                        </div>
                 </template>
         </jet-dialog-modal>
</template>

<script>

import JetDialogModal from '@/Jetstream/DialogModal.vue'
import { computed } from '@vue/reactivity'
import axios from 'axios'
export default {
       props:['show','groupId'],
       data(){
              return{
                     year:null,
                     month:null,
                     day:null,
                     hourses:[],
                     minutes:[],
                     H:null,
                     M:null
              }
       },
       components:{
              JetDialogModal
       },
       methods:{
       setH(event){
              this.H=event.target.value   
       }
       ,
       setM(event){
       this.M=event.target.value
           
       },
       confirm(check){
              if(check){
                     const vm=this;
                     // console.log(+this.H*60+(+this.M))
                     axios.post('/notice/Reservation/'+this.groupId,{
                            delay:(+this.H*60+(+this.M))
                     }).then((res)=>{
                            vm.close()
                     })
              }                    
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
              this. day = today.getDay();  // 요일
            
              let hours = today.getHours(); // 시
              let minute = today.getMinutes();  
             
              for(let i=0 ; i<12;i++){
                     this.hourses.push(i)
              }
              for(let i=0 ; i<61;i+=5){
                     this.minutes.push(i)
              }
             

       }
}
</script>