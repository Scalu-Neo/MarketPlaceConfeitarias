<template>
    <section class="baseLayout">
      <slot></slot>
    </section>
</template>

<style scoped>
.baseLayout {
  width: 100%;
  min-height: 100vh;
  background-image: url('/images/main.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed;
}
</style>