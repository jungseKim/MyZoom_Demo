<template>
        <div>
        <div class="h-3/4 rounded-lg bg-gray-200 overflow-y-scroll  scrollbar-hide" ref="messagess">
            <div ref="container" class="container" v-for="message in messages" :key="message">
                <div id="messages" class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
                <div class="chat-message" v-if="message.userId != $page.props.user.id">
                        <div class="flex items-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                            <div><span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">
                                {{ message.data }}
                                </span></div>
                            </div>
                            <img class="h-8 w-8 rounded-full object-cover" :src="message.image" :alt="message.userName" />
                            <!-- <img src="https://images.unsplash.com/photo-1549078642-b2ba4bda0cdb?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=3&amp;w=144&amp;h=144" alt="My profile" class="w-6 h-6 rounded-full order-1"> -->
                        </div>
                </div>
                <div class="chat-message" v-else>
                        <div class="flex items-end justify-end">
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
                            <div><span class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white ">
                                {{ message.data }}
                                </span></div>
                            </div>
                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                            <!-- <img src="https://images.unsplash.com/photo-1590031905470-a1a1feacbb0b?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=3&amp;w=144&amp;h=144" alt="My profile" class="w-6 h-6 rounded-full order-2"> -->
                        </div>
                </div>
            </div>
            </div>
        </div>
         <div class="flex w-full bg-white-400 ">
             <div class="relative">
           <input @keyup.enter="send"  type="text"  v-model="content"  class=" w-full pl-10 pr-20 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Let do chatting..">
            <div class="absolute top-2 right-2">   <i class="fas fa-paper-plane fa-2x" @click="send"></i> </div>
        </div>
             <!-- <input class="w-3/4" @keyup.enter="send" type="text" v-model="content"/>

               <div class="flex w-1/4 justify-center">


                </div>  -->
         </div>
                <!-- <button  @click="send">send</button> -->
    </div>
</template>

<script>
export default {
       props:['messages','user']
       ,
       data(){
              return{
                     content:''
              }
       },

       methods:{
              send(){
                     this.$emit('messageSend',this.content)
                     this.content=null
                    //  this.scrollToEnd()
              },
              scrollToEnd: function() {
                const messages = this.$refs.messagess;
                messages.scrollTop = messages.scrollHeight;
                },
       }

}
</script>
