<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Lunch menu for : {{ user_name }}
      </h2>
      <div>
        <button
          type="button"
          :class="buttonClass(plan.id)"
          v-for="plan in plans"
          :key="plan.id"
          v-on:click="test(plan.id)"
        >
          {{ plan.name }}
        </button>
      </div>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <table class="table">
            <thead class="text-center">
              <tr>
                <td style="color: maloon">日</td>
                <td>月</td>
                <td>火</td>
                <td>水</td>
                <td>木</td>
                <td>金</td>
                <td style="color: bule">土</td>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(week, index) in calendar" :key="index">
                <td v-for="day in week" :key="day.date">
                  {{ formatShortDate(day.date) }}
                  <div class="img_container">
                    <a :href="imagesrc(day.date, day.ordered_plan_id)">
                      <img
                        class="img-thumbnail img"
                        :src="imagesrc(day.date, day.ordered_plan_id)"
                        @error="replaceByDefault"
                      />
                      <div
                        v-show="day.can_change == ''"
                        class="img_text_overlay"
                        @mouseover="imghover = day.date"
                        @mouseleave="imghover = ''"
                        :class="{
                          img_text_overlay_hover: imghover == day.date,
                        }"
                      >
                        <span v-show="user_name != 'guest'">済</span>
                      </div>
                    </a>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <span v-show="!messages.err[0] == ''" class="alert alert-warning">
          <div v-for="(message, index) in messages.err" :key="index">
            {{ message }}
          </div>
        </span>
        <span v-show="!messages.info[0] == ''" class="alert alert-info">
          <div v-for="(message, index) in messages.info" :key="index">
            {{ message }}
          </div>
        </span>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";

export default {
  async mounted() {
    this.clearMessages();
    await this.getPersonalOrders();
  },
  methods: {
    replaceByDefault(e) {
      return (e.target.src = "/assets/images/fallback.png");
    },
    setErrMessages(msg) {
      this.messages.err.push(msg);
    },
    setMessages(msg) {
      this.messages.info.push(msg);
    },
    clearMessages() {
      this.messages = { info: [], err: [] };
    },
    getPersonalOrders() {
      window.axios
        .get("/api/order")
        .then((res) => {
          console.log(res.data);
          if ("error" in res.data) {
            this.setErrMessages(res.error);
            return;
          }
          this.calendar = res.data.calendar;
        })
        .catch((err) => {
          console.log(err);
          this.setErrMessages(err.message);
        });
    },
    buttonClass: function (id) {
      if (id == this.active_plan_id) {
        return "btn btn-primary mr-3";
      }
      return "btn btn-outline-secondary mr-3";
    },
    formatShortDate: function (value) {
      if (!value) return "";
      value = value.toString();
      return value.substr(5);
    },
    imgcon(v) {
      if (v) {
        return "";
      }
      return "imgcontainer";
    },
    imagesrc: function (value, ordered_plan_id) {
      if (!value) return "";

      var plan_id = this.active_plan_id
      if (ordered_plan_id) plan_id = ordered_plan_id
      var date = new Date(value);
      if (date == NaN) return "";

      var mm = date.getMonth() + 1;
      var dd = date.getDate();

      mm = ("0" + mm).slice(-2);
      dd = ("0" + dd).slice(-2);
      return "/assets/images/" + plan_id + "/" + mm + dd + ".png";
    },
    test() {
      console.log("call test");
      this.active_plan_id = this.active_plan_id == 1 ? 2 : 1;
      this.getPersonalOrders();
      //   window.axios
      //     .get("/api/user")
      //     .then((res) => {
      //       console.log(res);
      //     })
      //     .catch((err) => {
      //       this.setErrMessages(err);
      //     });
    },
  },
  data() {
    return {
      calendar: [],
      imgobj: { fallbacksrc: "/assets/images/fallback.jpg" },
      imghover: "",
      messages: { info: [], err: [] },
      active_plan_id: 1,
    };
  },

  filters: {},
  components: {
    AppLayout,
  },
  props: {
    user_name: {
      type: String,
    },
    plans: {
      type: Array,
    },
  },
};
</script>
<style scoped>
.img_container {
  position: relative;
  text-align: center;
}
.img {
  width: 100%;
}
.img_text_overlay {
  position: absolute;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  top: 0;
  bottom: 0;
}
.img_text_overlay_hover {
  opacity: 0.5;
}
</style>
