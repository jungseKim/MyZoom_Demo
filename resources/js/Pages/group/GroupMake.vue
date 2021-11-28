<template>
              <group-layout>
                     <template #content>
         <div class="m-10">
    <div class=" px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20 bg-clip-padding bg-opacity-60 border border-gray-200" style="backdrop-filter: blur(20px);">
            <label for="title" class="block text-sm font-medium text-gray-700">
                    그룹이름</label>
             <input id="title" class="w-full" type="text" v-model="title" ref="inputs">
            <p class="text-red-400">{{$page.props.errors.title}}</p>
              <label for="introduction" class="block text-sm font-medium text-gray-700">
                    그룹 소개</label>
             <input id="introduction" class="w-full" type="text" v-model="introduction" ref="inputs">
              <p class="text-red-400">{{$page.props.errors.introduction}}</p>

             <div class="col-span-6 sm:col-span-3">
                <label for="country" class="block text-sm font-medium text-gray-700">
                    그룹원 초대</label>
                    <div class="flex flex-rows">

                <input id="title" class="w-full" type="text" v-model="name" ref="inputs" @keyup.enter="search"><i @click="search()" class="fas fa-search fa-2x"></i>
                    </div>
                </div >

       <!-- component -->
              <div class="flex items-center justify-center  bg-gray-200 m-5">
              <div class="container">

              <div class="flex justify-center p-4 mb-10">
                     <h1 class="text-xl text-blue-500">초대 명단</h1>
              </div>
                     <div class="flex justify-center m-3">
                            <div class="bg-white shadow-xl rounded-lg w-2/3">
                                   <ul class="divide-y divide-gray-300">
                                   <li v-for="user in users" :key="user.id" class="p-4 hover:bg-gray-50 cursor-pointer text-bold">
                                     
                                     <div class="flex flex justify-between ">
                                              <img
                                   :src="user.image?user.image:`https://ui-avatars.com/api/?name=${user.name}&color=7F9CF5&background=EBF4FF`" 
                                   class="w-1/5 rounded-full"/>
                                         <span class="self-center mr-5 text-2xl text-bold">{{ user.name }}</span> 
                                         <i @click="userRemove(user)" class="fas fa-trash-alt self-center fa-2x hover:bg-gray-50 "></i>
                                     </div>
                               
                                   </li>
                                  
                                   </ul>
                              </div>
                     </div>
              </div>
              </div>

                    <div class="justify-items-center px-4 py-3 mt-8 bg-white text-right sm:px-6">
                        <button type="submit"
                            @click="store"
                            class="mr-4 inline-flex justify-center w-24 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md ring ring-gray-500 ring-offset-4  text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2  focus:ring-indigo-500">
                            Create
                        </button>
                       
                     </div>
    </div>
         </div>

         <jet-dialog-modal :show="searchUser" @close="searchUser = false">
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
                     
                        <!-- <Link :href="'/profile/'+viewed_user.name">
                            <span class="mr-1 font-black">{{viewed_user.name}}</span>
                        </Link> -->
                      
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
                     <jet-secondary-button @click="userAdd">
                            초대하기
                     </jet-secondary-button>
                     </template>
              </jet-dialog-modal>
         </template>
</group-layout>
</template>

<script>
import axios from 'axios'
import GroupLayout from './GroupLayout.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetDialogModal from '@/Jetstream/ConfirmationModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetLabel from '@/Jetstream/Label.vue'
 
import { useForm } from '@inertiajs/inertia-vue3'   
import { Inertia } from '@inertiajs/inertia'
export default {
       components:{
              GroupLayout,
              JetSecondaryButton,
            JetDialogModal,
            JetInput,
            JetLabel

       },
       data(){
              return{
                     name:'',
                     title:null,
                     searchUser:false,
                     temp:null,
                     users:[],
                     introduction:null
              }
       },
       methods:{
              userRemove(user){
                    this.users.splice(this.users.indexOf(user), 1);
              },
              store(){
                   
                      const form = useForm({
                            users:this.users,
                            title:this.title,
                            introduction:this.introduction
                            })
                    Inertia.post('/group/store',form,{
                        onError:(errors)=>this.errnow(errors)
                    })
                     // axios.post('/group/store',{
                     //        users:this.users,
                     //        title:this.title
                     // })
                     // .then((response)=>{
                     //        // console.log(response)
                     // })
              },
              userAdd(){
                     this.users.push({
                            id:this.searchUser.id,
                            name:this.searchUser.name,  
                            image:this.searchUser.image
                     })
                     this.searchUser=false
              },
              search(){
                     if(this.name==this.$page.props.user.name){
                            return alert('자신을 초대할 수없습니다.')
                     }
                     axios.get('/group/search', {
                            params: {
                            name: this.name
                            }
                     }).then(response=>{
                            console.log(response.data)
                            if(response.data==404){
                                  return alert('없는 회원입니다')
                            }
                            this.searchUser=response.data
                     }).catch((err)=>{
                            console.log(err)
                     })
              }
       }
}
</script>