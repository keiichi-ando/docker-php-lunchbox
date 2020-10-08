<template>
  <app-layout>
    <template #header>
      <div class="header">
        <h2>Vue CropperJS</h2>
        <a href="https://github.com/Agontuk/vue-cropperjs">Github</a>
      </div>
    </template>

    <input ref="input" type="file" name="image" accept="image/*" @change="setImage" />
    <div class="py-12 content">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <section class="cropper-area">
          <div class="img-cropper">
            <span class="btn btn-primary mb-3" @click.prevent="showFileChooser">
              Upload Image
            </span>
            <vue-cropper
              ref="cropper"
              :src="imgSrc"
              :view-mode="2"
              :auto-crop-area="0.6"
              drag-mode="move"
            />
          </div>

          <div class="actions">
            <span>横</span>
            <input type="text" v-model="divHorizontal" />
            <span> x 縦</span>
            <input type="text" v-model="divVertical" />
            <a href="#" role="button" @click.prevent="cropImage"> Crop </a>
            <!-- <a href="#" role="button" @click.prevent="getData"> Get Data </a>
            <a href="#" role="button" @click.prevent="setData"> Set Data </a>
            <a href="#" role="button" @click.prevent="getCropBoxData">
              Get CropBox Data
            </a>
            <a href="#" role="button" @click.prevent="setCropBoxData">
              Set CropBox Data
            </a> -->
            <!-- <textarea v-model="data" /> -->
          </div>
        </section>
        <section class="preview-area">
          <p>Cropped Image</p>
          <div class="cropped-image">
            <img
              id="cropped-img"
              v-if="cropImg"
              :src="cropImg"
              @load="splitImages"
              alt="Cropped Image"
            />
            <div v-else class="crop-placeholder" />
            <div v-for="(im, index) in cropImages" :key="im.uid">
              <div class="imageContainer">
                <img
                  :src="im.src"
                  class="regist-target-img mt-3"
                  :id="registId('rgi-', index)"
                  alt="Cropped Image"
                />
                <input
                  class="regist-target ml-3 mt-6 pt-3"
                  type="text"
                  :id="registId('rg-', index)"
                  placeholder="日付 (mmdd)"
                />
              </div>
            </div>
            <div class="actions upload">
              <select v-model="selectedPlan">
                <option disabled value="">メニューを選択</option>
                <option v-for="(plan) in plans" :key="plan.id" :value="plan.id">{{ plan.name }}</option>
              </select>
              <a href="#" role="button" @click.prevent="updateOrderPlan">
                Upload Plan data
              </a>
            </div>
          </div>
        </section>
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
  </app-layout>
</template>

<script>
  import AppLayout from '../../Layouts/AppLayout';
  import VueCropper from 'vue-cropperjs';
  import 'cropperjs/dist/cropper.css';

  export default {
    components: {
      AppLayout,
      VueCropper,
    },
    props: {
      user_name: {
        type: String,
      },
      plans: {
        type: Array,
      },
    },
    data() {
      return {
        imgSrc: '/assets/images/fallback.png',
        cropImg: '',
        cropImages: [],
        divHorizontal: 5,
        divVertical: 5,
        messages: { info: [], err: [] },
        selectedPlan: null,
        data: null,
      };
    },
    mounted() {
      // this.$refs.cropper('aspectRatioo', NaN)
    },
    methods: {
      setErrMessages(msg) {
        this.messages.err.push(msg);
      },
      setMessages(msg) {
        this.messages.info.push(msg);
      },
      clearMessages() {
        this.messages = { info: [], err: [] };
      },
      cropImage() {
        // get image data for post processing, e.g. upload or setting image src
        this.cropImg = this.$refs.cropper.getCroppedCanvas().toDataURL();
        this.cropImages = [];
        this.selectedPlan = null;
      },
      splitImages() {
        if (!this.cropImg) return;

        var img = new Image();
        img.src = this.cropImg;

        var drawW = Math.floor(img.width / this.divHorizontal);
        var drawH = Math.floor(img.height / this.divVertical);
        var uid = 0;

        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');

        canvas.width = drawW;
        canvas.height = drawH;

        for (var y = 0; y < this.divVertical; y++) {
          for (var x = 0; x < this.divHorizontal; x++) {
            context.clearRect(0, 0, drawW, drawH);
            context.drawImage(img, drawW * x, drawH * y, drawW, drawH, 0, 0, drawW, drawH);
            this.cropImages.splice(uid, 1, {
              id: uid,
              src: canvas.toDataURL(),
            });
            uid++;
          }
        }
      },
      registId(pre, v) {
        return pre + v;
      },
      async updateOrderPlan() {
        if (this.selectedPlan == null) {
          alert('メニューを選択してください');
          return;
        }
        const headers = { headers: { 'Content-Type': 'application/json' } };
        const elems = document.getElementsByClassName('regist-target');
        var imgelm = null;
        var postVal = { planid: this.selectedPlan, img: [] };
        console.log(this.selectedPlan, this.selectedPlan.value)

        var targets = [];
        var cnt = 0;
        for (var i = 0; i < elems.length; i++) {
          if (elems[i].value != '') {
            targets.splice(cnt, 1, { id: elems[i].id, value: elems[i].value });
            var imgelem = document.getElementById(elems[i].id.replace('rg-', 'rgi-'));
            postVal.img[cnt] = { id: elems[i].value, src: imgelem.src };
            cnt++;
          }
        }
        if (targets.length == 0) {
          alert('登録対象がありません');
          return;
        }
        await window.axios
          .post('/api/order', JSON.stringify(postVal), headers)
          .then(res => {
            // console.log(res.data);
            if ('error' in res.data) {
              this.setErrMessages(res.error);
              return;
            }
            alert('post success');
          })
          .catch(err => {
            console.log(err);
            this.setErrMessages(err.message);
          });

        return;
        alert('under construction !!' + this.selectedPlan);
      },
      getCropBoxData() {
        this.data = JSON.stringify(this.$refs.cropper.getCropBoxData(), null, 4);
      },
      getData() {
        this.data = JSON.stringify(this.$refs.cropper.getData(), null, 4);
      },
      reset() {
        this.$refs.cropper.reset();
      },
      setCropBoxData() {
        if (!this.data) return;
        this.$refs.cropper.setCropBoxData(JSON.parse(this.data));
      },
      setData() {
        if (!this.data) return;
        this.$refs.cropper.setData(JSON.parse(this.data));
      },
      setImage(e) {
        const file = e.target.files[0];
        if (file.type.indexOf('image/') === -1) {
          alert('Please select an image file');
          return;
        }
        if (typeof FileReader === 'function') {
          const reader = new FileReader();
          reader.onload = event => {
            this.imgSrc = event.target.result;
            // rebuild cropperjs with the updated source
            this.$refs.cropper.replace(event.target.result);
          };
          reader.readAsDataURL(file);
        } else {
          alert('Sorry, FileReader API not supported');
        }
      },
      showFileChooser() {
        this.$refs.input.click();
      },
    },
  };
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
  body {
    font-family: Arial, Helvetica, sans-serif;
    width: 1024px;
    margin: 0 auto;
  }
  input[type='file'] {
    display: none;
  }
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0 5px 0;
  }
  .header h2 {
    margin: 0;
  }
  .header a {
    text-decoration: none;
    color: black;
  }
  .content {
    display: flex;
    justify-content: space-between;
  }
  .cropper-area {
    width: 614px;
  }
  .actions {
    margin-top: 1rem;
  }
  .actions a {
    display: inline-block;
    padding: 5px 15px;
    background: #0062cc;
    color: white;
    text-decoration: none;
    border-radius: 3px;
    margin-right: 1rem;
    margin-bottom: 1rem;
  }
  .actions input {
    height: 1.5rem;
    /* border-radius: 3px; */
    margin: 1rem;
    width: 5rem;
    text-align: center;
    border-bottom: 2px solid brown;
  }
  textarea {
    width: 100%;
    height: 100px;
  }
  /* .preview-area {
  width: 307px;
}
.preview-area p {
  font-size: 1.25rem;
  margin: 0;
  margin-bottom: 1rem;
}
.preview-area p:last-of-type {
  margin-top: 1rem;
}
.preview {
  width: 100%;
  height: calc(372px * (9 / 16));
  overflow: hidden;
  border: 1px dotted darkgoldenrod;
} */
  .crop-placeholder {
    width: 100%;
    height: 200px;
    background: #ccc;
  }
  .cropped-image img {
    max-width: 80%;
  }
  .imageContainer {
    display: flex;
    align-items: flex-start;
  }
  .imageContainer input {
    height: 1.7rem;
    border-radius: 3px;
  }
</style>
