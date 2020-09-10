<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="text-center">
          <HelloWorld msg="Welcome LunchBox Vue.js App" submsg="comment"/>
        </div>
        <div class="card">
          <div class="card-header">Lunch Menu (Example)</div>

          <div class="card-body">
            <div>{{ name }}</div>

            <table class="table">
              <thead class="text-center">
                <tr>
                  <td style="color: maloon;">日</td>
                  <td>月</td>
                  <td>火</td>
                  <td>水</td>
                  <td>木</td>
                  <td>金</td>
                  <td style="color: bule;">土</td>
                </tr>
              </thead>
              <tbody>
                <tr v-for="week in calendar" :key="week">
                  <td v-for="day in week" :key="day">
                    {{ day | shortdate }}
                    <div>
                      <a :href="day|imagesrc">
                        <img
                          class="img-fluid img-thumbnail"
                          :src="day|imagesrc"
                          @error="replaceByDefault"
                        />
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
  </div>
</template>

<script>
import HelloWorld from "../components/HelloWorld";

export default {
  async mounted() {
    console.log("Component mounted.");
    const ret = await window.axios.get("/api/sample");
    console.log(ret.data);
    this.name = ret.data.name;
    this.calendar = ret.data.calendar;
  },
  methods: {
    replaceByDefault(e) {
      return (e.target.src = "/assets/images/fallback.png");
    },
  },
  data() {
    return {
      name: "",
      calendar: [],
      imgobj: { fallbacksrc: "/assets/images/fallback.jpg" },
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
    HelloWorld,
  },
};
</script>
