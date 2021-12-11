<template>
       <main class="grid w-full min-h-screen bg-gray-900 place-content-center">
    <div class="flex items-center max-w-md mx-auto bg-white rounded-full " x-data="{ search: '' }">
        <div class="w-full">
            <input type="search" class="w-full px-4 py-1 text-gray-900 rounded-full focus:outline-none"
                placeholder="name" v-model="name">
        </div>
        <div>
            <button @click="letgo"  class="flex items-center justify-center w-12 h-12 text-gray-100 rounded-full"
                :class="(name.length > 0) ? 'bg-purple-500' : 'bg-gray-500 cursor-not-allowed'"
                :disabled="name.length == 0">
                <i class="fas fa-door-open"></i>
            </button>
        </div>
    </div>
</main>
</template>

<script>
import { Method } from '@inertiajs/inertia'

import { Inertia } from '@inertiajs/inertia'
export default {
       props:['thiskey','id'],
       data(){
              return {
                     name:''
              }
       },
        methods:{
               letgo(){
                     Inertia.post('/gest/video/'+this.id,{
                            thiskey:this.thiskey,
                            id:this.id,
                            name:this.name
                     })
               }
        }
       
       
}
</script>