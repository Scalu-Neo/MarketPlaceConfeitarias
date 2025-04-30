<template>
  <section id="contato" class="map-section">
    <div class="map-description">
      <h2>Encontre as Melhores Confeitarias</h2>
      <p>
        Descubra as confeitarias mais renomadas da sua região e aproveite as delícias que elas oferecem.
        Navegue pelo mapa abaixo para localizar cada uma delas.
      </p>
    </div>
    <div id="map" class="leaflet-map"></div>
  </section>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const map = ref(null);

onMounted(async () => {
  
  map.value = L.map('map').setView([-7.1195, -34.8450], 13); // Setando em João Pesso como ponto inicial

  
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
  }).addTo(map.value);

  try {
    const response = await axios.get('/mapa-confeitarias');
    const confeitarias = response.data;

    confeitarias.forEach((confeitaria) => {
      const { latitude, longitude, nome, telefone, rua, numero, bairro } = confeitaria;

      if (latitude && longitude) {
        const marker = L.marker([latitude, longitude]).addTo(map.value);

        const popupContent = `
          <strong>${nome}</strong><br>
          Tel: ${telefone}<br>
          ${rua}, ${numero}<br>
          Bairro: ${bairro}
        `;

        marker.bindPopup(popupContent);
      }
    });
  } catch (error) {
    console.error('Erro ao carregar confeitarias:', error);
  }
});
</script>

<style scoped>
.map-section {
  padding: 20px;
  background-color: black;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.map-description {
  margin-bottom: 20px;
  text-align: center;
}


@keyframes fadeSlideIn {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.map-description h2 {
  font-size: 1.8rem;
  color: white;
  animation: fadeSlideIn 0.8s ease-out forwards;
  animation-delay: 0.9s;
  opacity: 0; 
}

.map-description p {
  font-size: 1rem;
  color: white;
  animation: fadeSlideIn 0.8s ease-out forwards;
  animation-delay: 0.9s;
  opacity: 0;
}

.leaflet-map {
  height: 400px;
  margin-bottom: 20px;
  border-radius: 6px;
}
</style>

