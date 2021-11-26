<template>
       <nav class="font-sans flex flex-col text-center sm:flex-row sm:text-left sm:justify-between py-4 px-6 bg-white shadow sm:items-baseline w-full">
  <div class="mb-2 sm:mb-0">
        <span class="text-2xl no-underline text-grey-darkest hover:text-blue-dark"></span>
  </div>
  <div>
    <button  class="text-lg no-underline text-grey-darkest hover:text-blue-dark ml-2">One</button>
  </div>
</nav>
</template>

<script>
import Button from '../../Jetstream/Button.vue'
export default {
  components: { Button },
       
}
</script>