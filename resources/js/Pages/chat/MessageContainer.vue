<template>
        <div>
        <div class="h-36 overflow-y-scroll" ref="messagess">
            <div class="container" v-for="message in messages" :key="message">
                <!-- <img src="https://cdn1.iconfinder.com/data/icons/website-internet/48/website_-_male_user-512.png" style="width:100%;" /> -->
                <p>{{message.data}}</p>
                <!-- <span class="time-right">11:00</span> -->
            </div>
        </div>
         <input type="text" v-model="content"/>
                <button @click="send">send</button>
    </div>
</template>

<script>
export default {
       props:['messages']
       ,
       data(){
              return{
                     content:''
              }
       }
       ,
       methods:{
              send(){
                     this.$emit('messageSend',this.content)
                     this.content=null
              }
       }
       ,
       watch: {
        messages() {
            // 화면에 추가된 후 동작하도록
            this.$nextTick(() => {
                let messages = this.$refs.messagess;

                messages.scrollTo({ top: messages.scrollHeight, behavior: 'smooth' });
            });
        },
    },
}
</script>