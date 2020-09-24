<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="text-center">
          <!-- <HelloWorld msg="Welcome LunchBox Vue.js App" submsg="comment" /> -->
        </div>
        <div class="card">
          <div class="card-header">Lunch Menu (Example)</div>

          <div class="card-body p-0">
            <div>for : {{ name }}</div>

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
                    <div :class="imgcon(day.can_change)">
                      <a :href="day.date | imagesrc">
                        <img
                          class="img-fluid img-thumbnail img"
                          :src="day.date | imagesrc"
                          @error="replaceByDefault"
                        />
                        <div v-show="!day.can_change" class="textoverlay"> 済 </div>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <span v-show="!messages.err[0] == ''" class="alert alert-warning" >
        <div v-for="(message,index) in messages.err" :key="index">{{ message }}</div>
      </span>
      <span v-show="!messages.info[0] == ''" class="alert alert-info">
        <div v-for="(message,index) in messages.info" :key="index">{{ message }}</div>
      </span>
      <input class="btn btn-info" type="button" v-on:click="test()">ボタン</div>
    </div>
  </div>
</template>

<script>
import AppLayout from "./../Layouts/AppLayout";

export default {
  async mounted() {
    console.log(this.$style);
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
.imgcontainer {
  position: relative;
  text-align: center;
}
.textoverlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 3rem;
  color: red;
}
</style>
