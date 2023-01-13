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

    apiCall(apiQuery, params) {
      axios.get(API_URL + apiQuery, params)
        .then(() => {

          this.getAllData();
        });
    },

    paramsConstructor(mykey, myvalue) {
      const params = {
        params: {
          [`${mykey}`]: myvalue
        }
      }

      return params
    },

    formSubmit(e) {

      e.preventDefault();

      const params = this.paramsConstructor('newTodo', this.newTodo);

      this.apiCall("add-todo.php", params);
    },

    removeElem(key) {
      const params = this.paramsConstructor('removeTodo', key);

      this.apiCall("remove-todo.php", params);
    },

    completedTask(key) {
      const params = this.paramsConstructor('taskStatus', key);

      this.apiCall("task-status.php", params);
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

            <span :class="todoEl.completed ? 'completed' : ''" @click="completedTask(key)" role="button">
              {{ todoEl.text }}
            </span>

            <span class="badge bg-danger rounded-pill" @click="removeElem(key)" role="button">X</span>
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
