
<script setup>
 import backgroundLayout from '../Components/backgroundLayout.vue';
</script>

<template>
    <backgroundLayout>
        <section id="confeitarias">
        <div id="title-section">Confeitarias</div>
        </section>
    </backgroundLayout>
</template>

<style scoped>
#title-section{
    display: flex;
    justify-content: center;
    width: 100%;
    padding-top: 20px;
    padding-bottom: 20px;
    font-size: 45px;
    color: white;
    
    background: linear-gradient(to left, black, #65615f);
}
#confeitarias{
    background-color: black;
    width: 100%;
    height: 100vh;
}
</style>