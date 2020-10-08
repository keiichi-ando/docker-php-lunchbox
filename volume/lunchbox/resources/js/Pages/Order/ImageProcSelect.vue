<template>
  <fieldset>
    <select :name="name" @change="updateValue">
      <template v-for="(option, index) in options">
        <option :value="option.value" :key="index">
          {{ option.label }}
        </option>
      </template>
    </select>
  </fieldset>
</template>

<script>
  export default {
    name: 'MySelect',
    props: {
      value: { type: String, required: true },
      options: { type: Array, required: true },
      name: { type: String, required: true },
    },
    methods: {
      updateValue: function(e) {
        this.$emit('input', e.target.value);
      },
    },
    mounted() {
      this.$emit('input', this.options[0].value);
    },
  };
</script>
