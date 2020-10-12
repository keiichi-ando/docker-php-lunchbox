<template>
  <fieldset>
    <select @change="updateValue">
      <option disabled selected value="">メニューを選択</option>
      <template v-for="(plan, index) in options">
        <option :value="plan.id" :key="index">
          {{ plan.name }}
        </option>
      </template>
    </select>
  </fieldset>
</template>

<script>
  export default {
    name: 'ImageProcSelect',
    props: {
      options: { type: Array, required: true },
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
