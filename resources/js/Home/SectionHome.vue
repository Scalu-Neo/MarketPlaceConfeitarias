<script setup>

const scrollToContato = () => {
  const contatoSection = document.getElementById('contato');
  if (contatoSection) {
    contatoSection.scrollIntoView({ behavior: 'smooth' });
  }
};
</script>
<template>
    <section id="box-text">
        <h1 class="animation text-main">As melhores<br/> confeitarias reunidas<br/> em um só lugar!</h1>
        <p class="animation subtext"><i>Localize a confeitaria mais<br/> próxima da sua região no mapa.</i></p>
        <button class="animation button" @click="scrollToContato">Saiba mais</button>
    </section>
</template>

<style scoped>

#box-text {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
  padding-top: 100px;
  padding-left: 95px;
  color: #d9d9d9;
}


h1 {
  font-size: 60px;
  margin-bottom: 10px;
}

p {
  font-size: 23px;
  margin: 0;
}


button {
  margin-top: 30px;
  padding: 12px 24px;
  font-size: 18px;
  font-weight: 600;
  color: #ffffff;
  background-color: black;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  transition: all 0.3s ease;
  margin-left: 95px;
}

button:hover {
  background-color: #65615f;
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}

.animation {
  opacity: 0;
  transform: translateY(30px);
  animation: fadeInUp 1s ease-out forwards;
}

.text-main {
  animation-delay: 0.3s;
}

.subtext {
  animation-delay: 0.8s;
}

.button {
  animation-delay: 1.3s;
}

@keyframes fadeInUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>