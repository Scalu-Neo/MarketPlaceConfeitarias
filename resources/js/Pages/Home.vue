<script setup>
import backgroundLayout from '../Components/backgroundLayout.vue';
import navbar from '../Components/navbar.vue';
import SectionHome from '../Home/SectionHome.vue';
import SectionCadastro from './SectionCadastro.vue';
import MapaConfeitaria from '../Components/MapaConfeitaria.vue';
import Footer from '../Components/Footer.vue';

const props = defineProps({
  confeitarias: Array
})
</script>

<template>
  <background-layout>
    <navbar></navbar>
    <section-home></section-home>
  </background-layout>
  <background-layout>
    <mapa-confeitaria></mapa-confeitaria>
  </background-layout>
  <Footer></Footer>
  
</template>



<style>
html {
  scroll-behavior: smooth;
}

body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

</style>
