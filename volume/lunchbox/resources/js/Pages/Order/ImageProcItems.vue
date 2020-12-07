<template>
  <div>
    <div v-for="(im, index) in cropedItems" :key="im.uid">
      <div class="imageContainer">
        <img
          class="regist-target-img mt-3"
          :src="im.src"
          :id="registId('rgi-', index)"
          alt="Cropped Image"
        />
        <flat-pickr
          :id="registId('rg-', index)"
          name="orderdate"
          class="regist-target ml-3 mt-6 pt-3"
          :config="config"
          v-model="date[index]"
          @on-change="onChangeDate"
          placeholder="日付を指定 (m/dd)"
        >
        </flat-pickr>
      </div>
    </div>
  </div>
</template>

<script>
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import 'flatpickr/dist/themes/confetti.css';
// import { localeJa } from 'flatpickr/dist/l10n/ja.js';

export default {
  name: 'ImageProcItems',
  components: {
    flatPickr,
  },
  props: {
    cropedItems: { type: Array, required: true },
  },
  data() {
    return {
      date: [],
      config: {
        dateFormat: 'md',
        monthSelectorType: 'static',
      },
    };
  },
  methods: {
    registId(pre, v) {
      return pre + ('00' + v).slice(-2);
    },
    /**
     * 指定箇所以降の日付を +1で再セット
     */
    onChangeDate(selectedDates, dateStr, instance) {
      var dt = selectedDates[0];
      var id = parseInt(instance.element.id.replace('rg-', ''));
      var max_id = document.getElementsByName('orderdate').length - 1;
      console.log(selectedDates[0], dateStr, instance.element.id, id, max_id);
      if (dateStr == '') return;

      for (let i = id + 1; i <= max_id; i++) {
        this.date[i] = dt.setDate(dt.getDate() + 1);
      }
    },
  },
};
</script>