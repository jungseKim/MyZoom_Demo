<template >
     <app-layout title="chatList">
       <div class="flex flex-row">
           <div class="container mx-auto p-8">
                <div class="grid grid-cols-3 gap-4">
                <div class="border-solid border-4 border-light-blue-500 bg-purple-600 bg-opacity-25 text-center h-20"
                v-for="item in list" :key="item.id">
                <Link class="align-text-middle"  :href="route('chat.room',[roomId=item.id])"> {{item.title}}</Link>
                <br>               {{   item.users.length  }}/{{ item.peoples }}
                </div>
                </div>
            </div>
            <div class="w-1/4">
                <button @click="open" >
                    클릭
                </button>
                <!-- <dialog-modal :show="show"/> -->
                <room-make-modal :show="show" v-on:close="close"/>
            </div>
       </div>
       </app-layout>
</template>

<script>
 import AppLayout from '@/Layouts/AppLayout.vue'
 import { Link } from '@inertiajs/inertia-vue3';
 import { Inertia } from '@inertiajs/inertia'
 import RoomMakeModal from './RoomMakeModal.vue'
// import DialogModal from '../../Jetstream/DialogModal.vue'
export default{
    props:['list','users'],
    components:{
      AppLayout,
      Link,
      RoomMakeModal
    },
    data(){
        return{
            show:false
        }
    },
  created(){
    Inertia.reload({ only: ['list'] })
    console.log(this.list);
  },
  computed:{
    //   roomPeple(item){
    //       return item.peoples
    //   }
  },
  methods:{
      open(){
          this.show=true;
      },
      close(){
          this.show=false;
      }
  }
}
</script>
