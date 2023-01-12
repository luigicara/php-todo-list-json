<script>
import axios from 'axios';

const API_URL = "http://localhost/";

export default {
  name: 'ToDoList',

  data() {
    return {
      todolist: [],
      newTodo: "",
      indexToRemove: ""
    }
  },

  methods: {
    getAllData() {
      axios.get(API_URL + 'data.php')
        .then(res => {
          const data = res.data;
          this.todolist = data;
          console.log(this.todolist);
        })
    },

    formSubmit(e) {

      e.preventDefault();

      const params = {
        params: {
          'newTodo': this.newTodo
        }
      };

      axios.get(API_URL + "add-todo.php", params)
        .then(() => {

          this.getAllData();
        });
    },

    removeElem(key) {
      const params = {
        params: {
          'removeTodo': key
        }
      };

      axios.get(API_URL + "remove-todo.php", params)
        .then(() => {

          this.getAllData();
        });
    },

    completedTask(key) {
      const params = {
        params: {
          'taskStatus': key
        }
      };

      axios.get(API_URL + "task-status.php", params)
        .then(() => {

          this.getAllData();
        });
    }
  },

  mounted() {
    this.getAllData()
  }
}

</script>

<template>
  <div class="container">
    <h1 class="text-center">ToDoList</h1>

    <div class="row">
      <div class="col-3"></div>

      <div class="col">
        <ul class="list-group mx-auto">
          <li class="list-group-item d-flex justify-content-between align-items-center"
            v-for="(todoEl, key) in todolist" :key="key">

            <span :class="todoEl.completed ? 'completed' : ''" @click="completedTask(key)">
              {{ todoEl.text }}
            </span>

            <span class="badge bg-danger rounded-pill" @click="removeElem(key)">X</span>
          </li>
        </ul>

        <form @submit="formSubmit" class="text-center my-3">
          <input type="text" name="newTodo" v-model="newTodo" class="mx-5">
          <input type="submit" value="Add">
        </form>
      </div>

      <div class="col-3"></div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.completed {
  text-decoration: line-through;
}
</style>
