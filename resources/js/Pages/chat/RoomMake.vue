<template >
       <app-layout title="RoomMake">

             <title>방제목을 적어주세요</title>
          <div class="container flex-row	m-12 w-4/5 border-2">
           <form v-on:submit.prevent>
            <label for="title" class="block text-sm font-medium text-gray-700">
                    방제목</label>
             <input id="title" class="w-full" type="text" v-model="title" ref="inputs">
             <div >{{$page.props.user.name}}</div>

             <div class="col-span-6 sm:col-span-3">
                <label for="country" class="block text-sm font-medium text-gray-700">
                    인원제한</label>
                <select id="country" name="country" autocomplete="country" v-model="peoples"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value=2>2명</option>
                    <option value=3>3명</option>
                    <option value=4>4명</option>
                </select>
                {{peoples}}
                </div >
                    <div class="justify-items-center px-4 py-3 mt-8 bg-white text-right sm:px-6">
                        <button type="submit"
                            @click="send"
                            class="mr-4 inline-flex justify-center w-24 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md ring ring-gray-500 ring-offset-4  text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2  focus:ring-indigo-500">
                            New
                        </button>
                        <button type="submit"
                            class="inline-flex justify-center w-24 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md ring  ring-indigo-500 ring-offset-4 bg-indigo-600 hover:bg-indigo-700 text-whitefocus:outline-none focus:ring-2  focus:ring-indigo-500">
                            Save
                        </button>
                     </div>
           </form>
         </div>
       </app-layout>
</template>

<script>
import Button from '../../Jetstream/Button.vue'
import axios from 'axios'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
export default {
  components: { Button ,AppLayout},
      data(){
             return{
              title:'',
              peoples:''
             }
      },
      methods:{
             send()
             {      if(this.title.length<2){
                    return alert("방제목은 최소 2글자 입니다")
             }
                     const form = useForm({
                            title: this.title,
                            peoples: this.peoples,
                            })
                    Inertia.post('/chat/store',form,{
                        onError:(errors)=>this.errnow(errors)
                    })
                 
             }
             ,
             errnow(err){
                 this.$refs.inputs.value=err.title;
             }


      }
}
</script>
