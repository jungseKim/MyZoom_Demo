<template>
    <dialog-modal :show="show" :closeable="closeable">
        <template v-slot:title>
            <h1>hi</h1>
        </template>
        <template v-slot:content>
            <h2>hellow</h2>
            <button @click="closes" >close</button>
        </template>
    </dialog-modal>
</template>

<script>
import DialogModal from '../../Jetstream/DialogModal.vue'
export default {
    components:{
        DialogModal
    },
    props:['show'],
    data(){
        return{
            closeable:false
        }
    },
    methods:{
        open(){
            this.show=true
        },
        closes(){
            // this.closeable=true;
            this.$emit('close')
            // this.show=false;
       }
    }
}
</script>
