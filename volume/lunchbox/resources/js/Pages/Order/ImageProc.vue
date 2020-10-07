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
            横<input type="text" v-model="divHorizontal" /> x 縦<input
              type="text"
              v-model="divVertical"
            />
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
            <div v-for="im in cropImages" :key="im.uid">
              <div class="imageContainer">
                <img :src="im.src" class="mt-3" alt="Cropped Image" />
                <input class="ml-3 mt-6 pt-3" type="text" :id="im.uid" placeholder="日付 (mmdd)" />
              </div>
            </div>
            <a href="#" role="button" @click.prevent="updateOrderPlan">
              Upload Plan data
            </a>
          </div>
        </section>
      </div>
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
    data() {
      return {
        imgSrc: '/assets/images/fallback.png',
        cropImg: '',
        cropImages: [],
        divHorizontal: 5,
        divVertical: 5,
        data: null,
      };
    },
    mounted() {
      // this.$refs.cropper('aspectRatioo', NaN)
    },
    methods: {
      cropImage() {
        // get image data for post processing, e.g. upload or setting image src
        this.cropImg = this.$refs.cropper.getCroppedCanvas().toDataURL();
        this.cropImages = [];
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
      updateOrderPlan() {
        alert('under construction');
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
      zoom(percent) {
        this.$refs.cropper.relativeZoom(percent);
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
    max-width: 100%;
  }
  .imageContainer {
    display: flex;
    align-items: flex-start;
  }
  .imageContainer input {
    height: 1.5rem;
    border-radius: 3px;
  }
</style>
