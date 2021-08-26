<template>
<div class="wrapper">
    <splide
      :options="primaryOptions"
      ref="primary"
    >
      <splide-slide v-for="slide in slides" :key="slide.src">
      <img :src="slide">
    </splide-slide>
    </splide>

    <splide
      :options="secondaryOptions"
      ref="secondary"
    >
      <splide-slide v-for="slide in slides" :key="slide.src">
      <img :src="slide">
    </splide-slide>
    </splide>
  </div>
</template>

<script>

  import '@splidejs/splide/dist/css/themes/splide-default.min.css';
  import { Splide, SplideSlide } from '@splidejs/vue-splide';
  import { createSlides } from '@splidejs/splide';


  export default {
      components: {
            Splide,
            SplideSlide,
        },
    props:['datos'],
    data() {
      return {
        slides: this.datos,
        primaryOptions: {
            rewind      : true,
            type       : 'fade',
            heightRatio: 0.5,
            pagination : false,
            arrows     : true,
            cover      : true,
                },
        secondaryOptions: {
            rewind      : true,
            arrows     : false,
            fixedWidth  : 100,
            fixedHeight : 64,
            isNavigation: true,
            gap         : 10,
            focus       : 'center',
            pagination  : false,
            cover       : true,
            breakpoints : {
                '600': {
                    fixedWidth  : 66,
                    fixedHeight : 40,
                }
            }
        },
      };
    },
    mounted(){
        //console.log(this.datos);
        this.$refs.primary.sync( this.$refs.secondary.splide );
    }
  }
</script>
