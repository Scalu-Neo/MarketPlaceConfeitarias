<script setup>
import BackgroundLayout from '../Components/backgroundLayout.vue';
import Navbar from '../Components/navbar.vue';
import { router } from '@inertiajs/vue3'
import { ref } from 'vue';

defineProps({
  confeitarias: Array,
  message: String
});

const cardsVisiveis = ref(4) 
const verMais = () => {
  cardsVisiveis.value += 4 
}
const editar = (id) => {
  router.get(route('confeitariaCadastroGet', id));
}

const deletar = (id) => {
  if (confirm('Tem certeza que deseja excluir esta confeitaria?')) {
    router.delete(route('excluirConfeitaria', id));
  }
}
const exibirProdutos = (id)=>{
  router.get(route('ProdutosPorConfeitaria', id)); //--> Criar uma rota para exibir produtos.
}

</script>


<template>
<BackgroundLayout>
    <Navbar></Navbar>
  <h1>Lista de confeitarias</h1>
  <p v-if="message" class="mensagem-sucesso">{{ message }}</p>
  <div class="container">
    <div class="card-grid">
      <div v-for="(confeitaria, index) in confeitarias.slice(0, cardsVisiveis)":key="confeitaria.id"class="card">
        <h2>{{ confeitaria.nome }}</h2>
        <p><strong>Telefone:</strong> {{ confeitaria.telefone }}</p>
        <p><strong>Endereço:</strong> {{ confeitaria.rua }}, Nº {{ confeitaria.numero }}</p>
        <p><strong>Bairro:</strong> {{ confeitaria.bairro }}</p>
        <p><strong>Cidade:</strong> {{ confeitaria.cidade }} - {{ confeitaria.estado }}</p>

        <div class="button-group">
          <button @click="editar(confeitaria.id)">Alterar</button>
          <button @click="deletar(confeitaria.id)">Excluir</button>
          <button @click="exibirProdutos(confeitaria.id)">Produtos</button>
        </div>
      </div>
    </div>
  </div>
    <div v-if="cardsVisiveis < confeitarias.length" class="ver-mais">
        <button @click="verMais">Ver mais</button>
    </div>
</BackgroundLayout>

</template>

<style scoped>
.container {
  display: flex;
  justify-content: center;
  align-items: center; 
  max-width: 1200px; 
  margin: 0 auto; 
}

.card-grid {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  gap: 20px;
 
}

.card {
  background: black;
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 20px;
  width: calc(33.333% - 20px);
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.6s;
}

.card:hover {
  transform: translateY(-10px);
}

.card h2 {
  margin-top: 0;
}
h1{
  display: flex;
  justify-content: center;
  color:white;
  font-size: 35px;
}
p {
  color: white;
}
h2{
  color: white;
}
.button-group {
  display:flex;
  justify-content: space-between;
  margin-top: 15px;
}

.button-group button {
  margin-right: 10px;
  padding: 8px 12px;
  border: none;
  background-color: #3490dc;
  color: white;
  border-radius: 4px;
  cursor: pointer;
  transition: background 0.3s;
}

.button-group button:hover {
  background-color: #2779bd;
}

.ver-mais {
  display: flex;
  justify-content: center;
  margin-top: 30px;
  text-align: center;
}

.ver-mais button {
  background-color: #555;
  border: none;
  color: white;
  padding: 10px 20px;
  font-size: 18px;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s;
}

.ver-mais button:hover {
  background-color: #765e3f;
}
.mensagem-sucesso {
  background-color: #d4edda;
  color: #155724;
  padding: 12px;
  border-radius: 8px;
  margin-bottom: 16px;
  text-align: center;
  font-size: 20px;
}
</style>