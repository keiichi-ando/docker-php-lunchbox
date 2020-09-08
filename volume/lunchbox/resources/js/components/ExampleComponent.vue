<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component. 
                         <div>{{ name }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  props: { test: String, },
  async mounted() {
    console.log("Component mounted.");
    const ret = await window.axios.get("/api/sample")
    console.log(ret.data)
    this.name = ret.data.name;
  },
  data() {
    return {
      name: ""
    };
  }
};
</script>
