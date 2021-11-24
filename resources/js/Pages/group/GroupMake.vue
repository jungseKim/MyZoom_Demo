<template>
              <group-layout>
                     <template v-slot:content>
          <div class="container flex-row	m-auto w-2/3 border-2">
           <form v-on:submit.prevent>
            <label for="title" class="block text-sm font-medium text-gray-700">
                    그룹이름</label>
             <input id="title" class="w-full" type="text" v-model="title" ref="inputs">
             <div >{{$page.props.user.name}}</div>
              
              
             <div class="col-span-6 sm:col-span-3">
                <label for="country" class="block text-sm font-medium text-gray-700">
                    그룹원 초대</label>
                    <div class="flex flex-rows">

                <input id="title" class="w-full" type="text" v-model="name" ref="inputs"><i @click="search(name)" class="fas fa-search fa-2x"></i>
                    </div>
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
         </template>
</group-layout>
</template>

<script>
import axios from 'axios'
import GroupLayout from './GroupLayout.vue'
export default {
       components:{
              GroupLayout
       },
       data(){
              return{
                     name:'',
                     title:''
              }
       },
       methods:{
              search(name){
                     console.log(name)
                     axios.get('/group/search',{
                            searchName:name
                     }).then((response=>{
                            console.log(response.data)
                     })).catch((err)=>{
                            console.log(err)
                     })
              }
       }
}
</script>