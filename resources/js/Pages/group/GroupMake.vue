<template>
              <group-layout>
                     <template #content>
          <div class="container flex-row	m-auto w-2/3 border-2">
            <label for="title" class="block text-sm font-medium text-gray-700">
                    그룹이름</label>
             <input id="title" class="w-full" type="text" v-model="title" ref="inputs">
             <div >{{$page.props.user.name}}</div>
              
              
             <div class="col-span-6 sm:col-span-3">
                <label for="country" class="block text-sm font-medium text-gray-700">
                    그룹원 초대</label>
                    <div class="flex flex-rows">

                <input id="title" class="w-full" type="text" v-model="name" ref="inputs"><i @click="search()" class="fas fa-search fa-2x"></i>
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
                     title:'',
                     searchUser:false,
                     temp:null,
                     users:[]
              }
       },
       methods:{
              userAdd(){
                     this.users.append({
                            id:this.searchUser.id,
                            name:this.searchUser.name,       
                     })
                     this.searchUser=false
              },
              search(){
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