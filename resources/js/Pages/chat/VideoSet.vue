<template>
       <dialog-modal :show="show" @close="close" >
               <template v-slot:title>
                 <h1 class="block w-full text-center text-gray-800 text-2xl font-bold mb-6">얼굴을 봐라</h1>
               </template>


              <template v-slot:content>
                     <video
                class="m-auto max-w-56 h-56 object-cover"
                ref="video" autoplay></video>
                     <button
                      @click="faceOkay(true)" 
                      class="block bg-green-400 hover:bg-green-600 text-white uppercase text-lg mx-auto p-4 rounded" >
                            On
                     </button>
                      <button 
                       @click="faceOkay(false)"
                      class="p-2 pl-5 pr-5 bg-yellow-500 text-gray-100 text-lg rounded-lg focus:border-4 border-yellow-300">
                             Off</button>
              </template>

       </dialog-modal>

</template>

<script>
import DialogModal from'@/Jetstream/DialogModal.vue';
export default {
       props:['stream','show'],
       components:{
              DialogModal
       },
       // mounted(){
       //        const videoHere = this.$refs['video'];
       //         videoHere.srcObject = this.stream;
       // },
       updated(){
                const videoHere = this.$refs['video'];
                if(videoHere){
                    videoHere.srcObject = this.stream;
                    console.log(this.stream)
                }
       },
    
       data(){
              return{
                    permision:false,
              }
       }
       ,
       methods:{
              faceOkay(check){
                     this.permision=check
                     this.$emit('close',this.permision)
              },
             
       }
}
</script>
