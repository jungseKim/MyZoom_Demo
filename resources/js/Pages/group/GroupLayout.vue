<template>
    <!-- component -->
<div class="flex ">
      <nav class="flex flex-col bg-purple-700 w-30 h-screen px-4 tex-gray-700 border border-purple-900">
        <div class="flex flex-wrap mt-8">
          <div class="w-1/2 mx-auto">
            <img
              :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name"
              class="mx-auto w-20 h-20 rounded-full"
            />
          </div>
          <!-- <div class="w-1/2">
            <span class="font-semibold text-white">안읽은 알람</span>
            <button class="bg-red-500 text-white px-4 py-2 rounded-md border border-blue-500 hover:bg-white hover:text-green-500">
              {{$page.props.user.notice_number.length  }}
            </button>
          </div> -->
        </div>
        <div class="mt-10 mb-4">
          <ul class="ml-4">
            <li class="mb-2 px-4 py-4 text-gray-100 flex flex-row  border-gray-300 hover:text-black   hover:bg-gray-300  hover:font-bold rounded rounded-lg">
              <span>
                <svg class="fill-current h-5 w-5 " viewBox="0 0 24 24">
                  <path
                    d="M16 20h4v-4h-4m0-2h4v-4h-4m-6-2h4V4h-4m6
                        4h4V4h-4m-6 10h4v-4h-4m-6 4h4v-4H4m0 10h4v-4H4m6
                        4h4v-4h-4M4 8h4V4H4v4z"
                  ></path>
                </svg>
              </span>
              <a :href="route('group.index')" :active="route().current('group.index')">
                <span class="ml-2">Dashboard</span>
              </a>
            </li>
            <li v-if="$page.props.notReadNotice" class="mt-0">
                <div class="flex">
                  <span class="text-red-300 mx-auto">new  {{$page.props.notReadNotice}}</span>
                </div>
            </li>
            <li class="mb-2 px-4 py-4 text-gray-100 flex flex-row  border-gray-300 hover:text-black   hover:bg-gray-300  hover:font-bold rounded rounded-lg">
           
              <span>
                <i class="far fa-envelope"></i>
              </span>
              <a :href="route('notice.index')" :active="route().current('notice.index')">
               
                <span class="ml-2">Notification</span>
              </a>
            </li>
            <li class="mb-2 px-4 py-4 text-gray-100 flex flex-row  border-gray-300 hover:text-black   hover:bg-gray-300  hover:font-bold rounded rounded-lg">
              <span>
                <svg class="fill-current h-5 w-5 " viewBox="0 0 24 24">
                  <path
                    d="M19 19H5V8h14m-3-7v2H8V1H6v2H5c-1.11 0-2 .89-2
                        2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0
                        00-2-2h-1V1m-1 11h-5v5h5v-5z"
                  ></path>
                </svg>
              </span>
              <a :href="route('group.create')" :active="route().current('group.create')">
               
                <span class="ml-2">Group Create</span>
              </a>
            </li>
            <li class="mb-2 px-4 py-4 text-gray-100 flex flex-row  border-gray-300 hover:text-black   hover:bg-gray-300  hover:font-bold rounded rounded-lg">
              <span>
                <svg class="fill-current h-5 w-5" viewBox="0 0 24 24">
                  <path
                    d="M12 4a4 4 0 014 4 4 4 0 01-4 4 4 4 0 01-4-4 4 4 0
                        014-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4
                        8-4z"
                  ></path>
                </svg>
              </span>
              <a href="#">
                <span class="ml-2">Team</span>
              </a>
            </li>
            <li class="mb-2 px-4 py-4 text-gray-100 flex flex-row  border-gray-300 hover:text-black   hover:bg-gray-300  hover:font-bold rounded rounded-lg">
              <span>
                <svg class="fill-current h-5 w-5 " viewBox="0 0 24 24">
                  <path
                    d="M12 13H7v5h5v2H5V10h2v1h5v2M8
                        4v2H4V4h4m2-2H2v6h8V2m10 9v2h-4v-2h4m2-2h-8v6h8V9m-2
                        9v2h-4v-2h4m2-2h-8v6h8v-6z"
                  ></path>
                </svg>
              </span>
              <a href="#">
                <span class="ml-2">Tasks</span>
              </a>
            </li>
            <li class="mb-2 px-4 py-4 text-gray-100 flex flex-row  border-gray-300 hover:text-black   hover:bg-gray-300  hover:font-bold rounded rounded-lg">
              <span>
                <svg
                  class="fill-current h-5 w-5 "
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M7 3C8.86384 3 10.4299 4.27477 10.874 6H19V8H10.874C10.4299 9.72523 8.86384 11 7 11C4.79086 11 3 9.20914 3 7C3 4.79086 4.79086 3 7 3ZM7 9C8.10457 9 9 8.10457 9 7C9 5.89543 8.10457 5 7 5C5.89543 5 5 5.89543 5 7C5 8.10457 5.89543 9 7 9Z"
                    fill="currentColor"
                  />
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M17 20C15.1362 20 13.5701 18.7252 13.126 17H5V15H13.126C13.5701 13.2748 15.1362 12 17 12C19.2091 12 21 13.7909 21 16C21 18.2091 19.2091 20 17 20ZM17 18C18.1046 18 19 17.1046 19 16C19 14.8954 18.1046 14 17 14C15.8954 14 15 14.8954 15 16C15 17.1046 15.8954 18 17 18Z"
                    fill="currentColor"
                  />
                </svg>
              </span>
              <a href="#">
                <span class="ml-2">Settings</span>
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <!-- <section class="relative block w-full">
    <img class="absolute top-0 w-full h-full bg-center bg-cover"
    src="/background-2.jpg"/> -->
    <!-- <div class="absolute top-0 w-full h-full bg-center bg-cover" >
      <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
    </div> -->
    <!-- <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden h-70-px" style="transform: translateZ(0px)">
      <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
        <polygon class="text-blueGray-200 fill-current" points="2560 0 2560 100 0 100"></polygon>
      </svg>
    </div> -->
<!-- <div class="w-3/4">  -->
<div class="bg-cover w-full" style="background-image: url('/background-2.jpg')">
      <slot name="content">
                </slot>
                </div>
  <!-- </section> -->
       
       <jet-dialog-modal :show="showNotice" @close="showNotice = false ">
        <template #content>
               <div class="w-full mx-3 overflow-hidden bg-white border rounded md:w-12/12 md:mx-0 lg:mx-0">
                <div class="flex justify-between w-full p-3">

                    <span class="px-2 rounded cursor-pointer hover:bg-gray-300"></span>
                    </div>
                    <div class="px-3 pb-2">
                    <div >
                            <span class="font-bold text-lg">{{ showNotice.offerUser_name }}님으로 부터 메세지가 왔습니다</span>
                      <!-- <span class="mr-1 font-black">{{showNotice.offerGroup.title}}</span> -->
                    </div>
                    <hr class="my-4">
                    
                
                    </div>
                </div>
                       </template>

                     <template #footer>
                     <jet-secondary-button @click="confirm(true)" class="bg-green-300 w-1/5">
                            보러가기
                     </jet-secondary-button>

                     <jet-secondary-button @click="confirm(false)" class="bg-red-300 w-1/5">
                            닫기
                     </jet-secondary-button>
                     </template>
              </jet-dialog-modal>

        <group-strat-modal :gruop="group" :show="group" @close="group=false"/>
</div>


   
</template>

<script>
import JetNavLink from '@/Jetstream/NavLink.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import GroupStratModal from './GroupStratModal.vue'
import { Inertia } from '@inertiajs/inertia'
export default {
  components:{
    JetNavLink,
    JetDialogModal,
    JetSecondaryButton,
    GroupStratModal
  },
  data(){
    return{
      showNotice:false,
      group:false
    }
  }
  ,
  mounted(){
      Echo.private('App.Models.User.' + this.$page.props.user.id)
    .notification((notification) => {
      console.log(notification)
      if(notification.group){
          this.group=notification
      }
      else{
        this.showNotice=notification
      }
      //이거 온리 로 바꾸자 
        Inertia.reload({ only: ['notReadNotice'] })
      //  this.$page.props.notReadNotice+=1
    });
  }
  ,
  methods:{
     confirm(check){
      if(check){
        Inertia.get('/group/notice')
      }
      else{
         this.showNotice=false;
      }
       
    }
  }
}
</script>