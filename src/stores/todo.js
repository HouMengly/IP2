import { defineStore } from "pinia";

export const useTodoStore = defineStore("todo", {
  state: () => ({
    todos: [],
  }),
  getters: {
    countTodos: (state) => state.todos.length,
  },
  actions: {
    async fetchTodos() {
      try {
        const res = await fetch("http://localhost:3100/tasks");
        const data = await res.json();
        this.todos = data;
      } catch (error) {
        console.error("Failed to fetch todos:", error);
      }
    },

    async toggleStatus(id) {
      if (typeof id !== "number" || isNaN(id)) {
        console.error("Invalid task ID for toggleStatus:", id);
        return;
      }

      const todo = this.todos.find((t) => t.id === id);
      if (!todo) return;

      const updatedStatus = {
        completedAt: todo.completedAt ? null : new Date().toISOString(),
      };

      try {
        await fetch(`http://localhost:3100/tasks/${id}`, {
          method: "PUT",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(updatedStatus),
        });

        todo.completedAt = updatedStatus.completedAt;
      } catch (error) {
        console.error("Failed to update task status:", error);
      }
    },
    
    async deleteTodo(id) {
      try {
        await fetch(`http://localhost:3100/tasks/${id}`, {
          method: "DELETE",
        });
        this.todos = this.todos.filter(todo => todo.id !== id);
      } catch (error) {
        console.error("Failed to delete todo:", error);
      }
    },
    
    async addTodo(name) {
      const newTodo = {
        name,
        description: "description", // update as needed
        createdAt: new Date().toISOString(),
        completedAt: null,
        user: { id: 1 }, // assuming user ID 1 for now
      };

      try {
        const res = await fetch("http://localhost:3100/tasks/create", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(newTodo),
        });

        const createdTodo = await res.json();
        this.todos.push(createdTodo);
      } catch (error) {
        console.error("Failed to add todo:", error);
      }
    },

    async clearAll() {
      try {
        await Promise.all(
          this.todos.map((todo) =>
            fetch(`http://localhost:3100/tasks/${todo.id}`, {
              method: "DELETE",
            })
          )
        );
        this.todos = [];
      } catch (error) {
        console.error("Failed to clear todos:", error);
      }
    },
  },
});