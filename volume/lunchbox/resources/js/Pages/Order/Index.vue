<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Lunch menu for : {{ name }}
      </h2>
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
                  {{ day.date | shortdate }}
                  <div class="img_container">
                    <a :href="day.date | imagesrc">
                      <img
                        class="img-thumbnail img"
                        :src="day.date | imagesrc"
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
                        <span v-show="name != 'guest'">済</span>
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
        <input class="btn btn-info" type="button" v-on:click="test()" />ボタン
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";

export default {
  async mounted() {
    this.clearMessages();

    await window.axios
      .get("/api/order")
      .then((res) => {
        console.log(res.data);
        if ("error" in res.data) {
          this.setErrMessages(res.error);
          return;
        }
        this.name = res.data.name;
        this.calendar = res.data.calendar;
      })
      .catch((err) => {
        console.log(err);
        this.setErrMessages(err.message);
      });
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
    imgcon(v) {
      if (v) {
        return "";
      }
      return "imgcontainer";
    },

    test() {
      console.log("call test");
      window.axios
        .get("/api/user")
        .then((res) => {
          console.log(res);
        })
        .catch((err) => {
          this.setErrMessages(err);
        });
    },
  },
  data() {
    return {
      name: "",
      calendar: [],
      imgobj: { fallbacksrc: "/assets/images/fallback.jpg" },
      imghover: "",
      messages: { info: [], err: [] },
    };
  },
  filters: {
    shortdate: function (value) {
      if (!value) return "";
      value = value.toString();
      return value.substr(5);
    },
    imagesrc: function (value) {
      if (!value) return "";
      var date = new Date(value);
      if (date == NaN) return "";

      var mm = date.getMonth() + 1;
      var dd = date.getDate();

      mm = ("0" + mm).slice(-2);
      dd = ("0" + dd).slice(-2);
      return "/assets/images/" + mm + dd + ".png";
    },
  },
  components: {
    AppLayout,
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
