<template>
  <div class="relative overflow-x-auto sm:rounded-lg shadow-lg mb-10">
    <table v-if="todos && todos.length > 0" class="w-full text-sm text-left rtl:text-right text-gray-500">
      <thead class="text-xs text-gray-700 uppercase bg-white ">
        <tr>
          <th class="px-6 py-3">ID</th>
          <th class="px-6 py-3">Title</th>
          <th class="px-6 py-3">Description</th>
          <th class="px-6 py-3">Update</th>
          <th class="px-6 py-3">Delete</th>
        </tr>
      </thead>
      <tbody >
        <tr v-for="({todo}) in todos" :key="todo.id" class="odd:bg-gray-200 even:bg-gray-100 ">
          <td class="px-6 py-4">{{ todo.id }}</td>
          <td class="px-6 py-4">
            <input v-model="todo.title" :disabled="!todo.editing" />
          </td>
          <td class="px-6 py-4">
            <input v-model="todo.description" :disabled="!todo.editing" />
          </td >
          <td class="px-6 py-4">
            <button @click="toggleEdit(todo)" class="mr-2">Edit</button>
            <button v-if="todo.editing" @click="saveChanges(todo)">Save</button>
          </td>
          <td class="px-6 py-4">
            <button @click="deleteTodo(todo.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-else>
      <p>No todos found.</p>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, reactive } from 'vue';
import axios from 'axios';

export default {
  setup() {
    const todos = reactive([]);
    const isEditing = ref(false); // Flag to indicate whether editing mode is active

    const fetchTodos = async () => {
      try {
        const response = await axios.get('http://localhost/vue_api/read.php');
        todos.splice(0); // Clear todos array
        response.data.forEach(todo => {
          todos.push({ ...todo, editing: false });
        });
      } catch (error) {
        console.error('Error fetching todos:', error);
      }
    };

    const toggleEdit = (todo) => {
      todo.editing = !todo.editing;
      isEditing.value = todo.editing; // Set editing flag based on todo's editing state
    };

    const saveChanges = async (todo) => {
      try {
        // Send a PUT request to the API endpoint with the updated todo data
        await axios.put(`http://localhost/vue_api/update.php?id=${todo.id}`, {
          title: todo.title,
          description: todo.description
        },
        console.log('successful')
        );

        // Set the editing flag to false after saving changes
        todo.editing = false;
        isEditing.value = false;

        // No need to fetch updated todos here since the PUT request already updated the data in the database
      } catch (error) {
        console.error('Error saving changes:', error);
      }
    };


    const deleteTodo = async (id) => {
      try {
        await axios.delete(`http://localhost/vue_api/delete.php?id=${id}`);
        todos.splice(todos.findIndex(todo => todo.id === id), 1);
      } catch (error) {
        console.error('Error deleting todo:', error);
      }
    };

    const startPolling = () => {
      setInterval(() => {
        // Only fetch todos if not in editing mode
        if (!isEditing.value) {
          fetchTodos();
        }
      }, 5000); // Poll every 5 seconds (adjust as needed)
    };

    onMounted(() => {
      fetchTodos(); // Fetch initial data
      startPolling(); // Start polling for new data
    });
    
    return { todos, toggleEdit, saveChanges, deleteTodo };
  }
};
</script>
