<template>
       <!-- component -->
        <jet-dialog-modal :show="show" @close="close">
                <template #content>
              <div class="mt-2 p-5 w-40 bg-white rounded-lg shadow-xl">
              <div class="flex">
              <select name="hours" class="bg-transparent text-xl appearance-none outline-none">
              <option v-for="hours in hours" :key="hours" :value="hours">{hours}</option>
              
              </select>
              <span class="text-xl mr-3">:</span>
              <select name="minutes" class="bg-transparent text-xl appearance-none outline-none mr-4">
              <option value="0">00</option>
              <option value="30">30</option>
              </select>
              <select name="ampm" class="bg-transparent text-xl appearance-none outline-none">
              <option value="am">AM</option>
              <option value="pm">PM</option>
              </select>
              </div>
              </div>
               </template>
                 <template #footer>
                 
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
                     hours:[]
              }
       },
       components:{
              JetDialogModal
       },
       methods:{
              close(){
            // this.closeable=true;
            this.$emit('close')
       },

       }
       ,mounted(){
              let today = new Date();

              this.year = today.getFullYear();
              this.month = ('0' + (today.getMonth() + 1)).slice(-2);
              this.day = ('0' + today.getDate()).slice(-2);
              hours = ('0' + today.getHours()).slice(-2); 
              for(let i=0; i<hours;i++){
                     this.hours.push(i+hours)
              }

       }
}
</script>