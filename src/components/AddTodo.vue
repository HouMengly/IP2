<template>
  <div class="input-field">
    <textarea
      v-model="newTodo"
      @keyup.enter.prevent="submit"
      ref="input"
      placeholder="Enter your new todo"
    ></textarea>
    <i class="uil uil-notes note-icon"></i>
  </div>
</template>

<script>
export default {
  data() {
    return {
      newTodo: "",
    };
  },
  methods: {
    submit() {
      if (!this.newTodo.trim()) return;
      this.$emit("added", this.newTodo.trim());
      this.newTodo = "";
    },
  },
};
</script>