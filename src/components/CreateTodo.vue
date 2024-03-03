<!-- CreateTodo.vue -->  
  <template>
    <div class="border border-gray-900/5 p-10  shadow-lg rounded-lg bg-white">
      <h2 class="text-base font-bold leading-7 text-gray-900 mb-5">Create Todo</h2>
      <div>
        <form @submit.prevent="createTodo">
          <div>
            <label for="title" class="block text-md font-medium leading-6 text-gray-900 mb-2">Title</label>
            <input type="text" v-model="title" id="title" class="border p-1 rounded-md w-full mb-3 bg-gray-100" placeholder="Enter title" required>
          </div>
          <div>
            <label for="description" class="block text-md font-medium leading-6 text-gray-900 mb-2">Description</label>
            <textarea v-model="description" id="description" class="border p-1 rounded-md w-full mb-3 bg-gray-100" placeholder="Description"></textarea>
          </div>
          <div class="mt-6 flex items-center justify-center gap-x-6">
            <button type="submit" class="rounded-md bg-indigo-600 px-10 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create</button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        title: '',
        description: ''
      };
    },
    methods: {
      createTodo() {
        axios.post('http://localhost/vue_api/create.php', { title: this.title, description: this.description })
          .then(response => {
            console.log(response.data);
            // Optionally, you can redirect to the list page after creating a todo
            // this.$router.push('/todos');
          })
          .catch(error => {
            console.error(error);
            // Handle error
          });
      }
    }
  }
  </script>
  