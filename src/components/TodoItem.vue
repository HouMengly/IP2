<template>
  <li class="list" :class="{ completed: todo.completedAt != null }">
    <div class="todo-content" @click="toggleStatus(todo.id)">
      <input 
        type="checkbox" 
        :checked="todo.completedAt != null" 
        @click.stop
      />
      <span class="task">{{ todo.name }}</span>
    </div>
    <button class="delete-btn" @click.stop="deleteTodo(todo.id)">
      <i class="uil uil-trash-alt"></i>
    </button>
  </li>
</template>

<script>
import { useTodoStore } from "../stores/todo";
export default {
  setup() {
    const todoStore = useTodoStore();
    return { todoStore };
  },
  props: ["todo", "icon"],
  methods: {
    toggleStatus(todoId) {
      this.todoStore.toggleStatus(todoId);
    },
    deleteTodo(todoId) {
      if (confirm('Are you sure you want to delete this task?')) {
        this.todoStore.deleteTodo(todoId);
      }
    }
  },
};
</script>

<style scoped>
.list {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 15px;
  background: #fff;
  border-radius: 5px;
  margin-bottom: 10px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.list:hover {
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.todo-content {
  display: flex;
  align-items: center;
  flex-grow: 1;
}

.completed {
  opacity: 0.7;
}

.completed .task {
  text-decoration: line-through;
}

.task {
  margin-left: 10px;
  flex-grow: 1;
}

input[type="checkbox"] {
  cursor: pointer;
}

.delete-btn {
  background: none;
  border: none;
  color: #ff5c5c;
  cursor: pointer;
  padding: 5px;
  margin-left: 10px;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.list:hover .delete-btn {
  opacity: 1;
}

.delete-btn:hover {
  color: #ff0000;
}
</style>