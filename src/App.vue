<script setup>
import CreateTodo from './components/CreateTodo.vue';
import ViewTodo from './components/ViewTodo.vue';

</script>

<template >
    <body class=" bg-gray-100 ">
      <div class=" p-10 flex justify-center ">
      <main>
        <div class=" flex justify-center mb-10">
          <img alt="Vue logo" class="logo" src="./assets/logo.svg" width="125" height="125" />
        </div>
        <div class="flex space-x-20">
          <div >
              <ViewTodo />
          </div>
          <div>
            <CreateTodo />
          </div>
        </div>
      </main>
    </div>
  </body>

</template>


