<script setup>
import BackgroundLayout from '../Components/backgroundLayout.vue';
import Navbar from '../Components/navbar.vue';
import { router } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';


const props = defineProps({ //->Recebendo os dados do Laravel
  produtos: Array,
  imagemProdutos: Array,
  message: String
});

const cardsVisiveis = ref(4); //->Setando o número de cards exibidos
const verMais = () => {
  cardsVisiveis.value += 4;
};

const editar = (id) => { //->Invocando a rota de edição no Laravel
  router.get(route('alterarProduto', id));
};

const deletar = (id) => { //-> Invocando a rota de remoção no laravel
  if (confirm('Tem certeza que deseja excluir este produto?')) {
    router.delete(route('deletarProduto', id), {
      onSuccess: () => {
        props.produtos = props.produtos.filter(produto => produto.id !== id);
      }
    });
  }
};

const imagensPorProduto = computed(() => { //-> Agrupando imagens por produto
  const agrupadas = {};
  props.imagemProdutos.forEach(img => {
    if (!agrupadas[img.produto_id]) {
      agrupadas[img.produto_id] = [];
    }
    agrupadas[img.produto_id].push(img.url_imagem);
  });
  return agrupadas;
});

const indicesImagem = ref({}); //->Índices do carrossel por produto

const imagemAtual = (produtoId) => { //->Exibe a imagem atual
  const imagens = imagensPorProduto.value[produtoId] || [];
  return imagens[indicesImagem.value[produtoId] || 0];
};

const proximaImagem = (produtoId) => { //-> Avança para a próxima imagem
  const imagens = imagensPorProduto.value[produtoId] || [];
  if (!imagens.length) return;
  indicesImagem.value[produtoId] = (indicesImagem.value[produtoId] + 1) % imagens.length;
};

const imagemAnterior = (produtoId) => { //-> Retrocede para outra imagem
  const imagens = imagensPorProduto.value[produtoId] || [];
  if (!imagens.length) return;
  indicesImagem.value[produtoId] =
    (indicesImagem.value[produtoId] - 1 + imagens.length) % imagens.length;
};

onMounted(() => { //-> Setar primeira imagem a ser exibida
  props.produtos.forEach(produto => {
    if (!(produto.id in indicesImagem.value)) {
      indicesImagem.value[produto.id] = 0;
    }
  });
});
</script>

<template>
    <BackgroundLayout>
      <Navbar />
      <h1>Produtos da confeitaria</h1>
      <p v-if="message" class="mensagem-sucesso">{{ message }}</p>

      <!-- Exibe os cards se houver produtos -->
      <div class="container">
        <div v-if="produtos && produtos.length > 0" class="card-grid">
          <div
            v-for="produto in produtos.slice(0, cardsVisiveis)"
            :key="produto.id"
            class="card"
          >
            <h2>{{ produto.nome }}</h2>
  
            <!-- Carrossel de imagens em cards -->
            <div class="card-imagens">
              
            <!-- Botão para retroceder a imagem anterior -->
              <button
                class="nav-button left"
                @click="imagemAnterior(produto.id)"
                v-if="(imagensPorProduto[produto.id]?.length || 0) > 1"
              >
              </button>
  
              <img
                v-if="imagemAtual(produto.id)"
                :src="`/storage/${imagemAtual(produto.id)}`"
                alt="Imagem do produto"
                class="produto-img"
              />
              <!-- Botão para avançar para a imagem posterior -->
              <button
                class="nav-button right"
                @click="proximaImagem(produto.id)"
                v-if="(imagensPorProduto[produto.id]?.length || 0) > 1"
              >
              </button>
            </div>

            <!-- Exibindo as propriedades do produto no card -->
            <div class="card-content">
              <p><strong>Preço:</strong> {{ produto.valor }}</p>
              <p><strong>Descrição:</strong> {{ produto.descricao }}</p>
            </div>

            <!-- Botões para editar ou deletar o produto -->
            <div class="button-group">
              <button @click="editar(produto.id)">Alterar</button>
              <button @click="deletar(produto.id)">Excluir</button>
            </div>
          </div>
        </div>
        <p v-else class="mensagem-vazia">Nenhum produto disponível! Cadastre um produto.</p>
      </div>
  
      <div v-if="produtos && cardsVisiveis < produtos.length" class="ver-mais">
        <button @click="verMais">Ver mais</button>
      </div>
    </BackgroundLayout>
  </template>
  
  
  <style scoped>
  .container {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
  }
  
  .card-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
    justify-content: center;
    width: 100%;
  }
  
  .card {
    background: #1e1e1e;
    border-radius: 8px;
    border: 1px solid white;
    padding: 20px;
    width: 300px;
    min-height: 350px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.6s;
  }
  
  .card:hover {
    transform: translateY(-10px);
  }
  
  .card h2 {
    margin: 0 0 10px;
    font-size: 22px;
    color: #fff;
  }
  
  .card p {
    margin: 5px 0;
    color: #ccc;
  }
  
  h1 {
    text-align: center;
    color: white;
    font-size: 35px;
    margin-top: 30px;
  }
  
  .button-group {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
  }
  
  .button-group button {
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
    margin: 40px 0;
  }
  
  .ver-mais button {
    background-color: #555;
    border: none;
    color: white;
    padding: 12px 24px;
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
    margin: 20px auto;
    text-align: center;
    font-size: 20px;
    width: 80%;
  }
  .map-section {
    padding: 20px;
    background-color: #f4f4f4;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  
  .map-description {
    margin-bottom: 20px;
    text-align: center;
  }
  
  .map-description h2 {
    font-size: 1.8rem;
    color: #333;
  }
  
  .map-description p {
    font-size: 1rem;
    color: #666;
  }
  
  .leaflet-map {
    height: 400px;
    margin-bottom: 20px;
  }
  
  .map-footer {
    text-align: center;
    font-size: 0.9rem;
    color: #999;
  }
  
  .card-imagens {
    position: relative;
    text-align: center;
    margin-bottom: 15px;
  }
  
  .produto-img {
    max-width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 6px;
  }
  .nav-button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: white;
    color: white;
    border: none;
    padding: 8px;
    cursor: pointer;
    font-size: 18px;
    z-index: 2;
  }
  
  .nav-button.left {
    left: 10px;
  }
  
  .nav-button.right {
    right: 10px;
  }
  
  .nav-button:hover {
    background-color: white;
  }
  .mensagem-vazia {
    text-align: center;
    color: white;
    font-size: 35px;
    margin: 2rem 0;
    font-style: italic;
  }
  </style>