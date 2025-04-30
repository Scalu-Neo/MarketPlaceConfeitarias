<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import navbar from '../Components/navbar.vue';
import backgroundLayout from '../Components/backgroundLayout.vue';

const props = defineProps({//->Recebendo dadoso do Laravel
  confeitaria: Object,
  produto: Object,
  imagensProduto: Array,
  message: String,
});


const imagensAtuais = ref([...props.imagensProduto]);//-> Cópia reativa das imagens atuais (porque props são imutáveis)
const previews = ref([]);
const isSubmitting = ref(false);
const id = props.produto?.id;


const form = useForm({//->Atribuindo valores do objeto produto as propriedades do objeto form
  nome: props.produto?.nome || '',
  valor: props.produto?.valor || '',
  descricao: props.produto?.descricao || '',
  confeitaria_id: props.produto?.confeitaria_id || '',
  imagens: []
});

const viewImage = (event) => {//->Exibir pré-visualização das imagens e armazenar no formulário
  const files = event.target.files;
  form.imagens = Array.from(files);

  previews.value = [];
  for (const file of form.imagens) {
    const reader = new FileReader();
    reader.onload = (e) => previews.value.push(e.target.result);
    reader.readAsDataURL(file);
  }
};

const enviarFormulario = () => {//->Enviando os dados do formulário e setando as propriedades de form
  const formData = new FormData();
  formData.append('nome', form.nome);
  formData.append('descricao', form.descricao);
  formData.append('valor', form.valor);
  formData.append('confeitaria_id', form.confeitaria_id);

  form.imagens.forEach((file) => {
    formData.append('imagens[]', file);
  });

 
  try {
    isSubmitting.value = true;

    router.post(`/alterar/produto/${id}`, formData, {
      onSuccess: () => {
        alert('Produto atualizado com sucesso!');
        imagensAtuais.value = '';
        form.nome = '';
        form.descricao = '';
        form.valor = '';
        previews.value = [];
        form.imagens = [];
        previews.value = [];
      },
      onError: (errors) => {
        console.error(errors);
        alert('Erro ao atualizar produto.');
      }
    });
  } catch (error) {
    console.error(error);
    alert('Erro inesperado.');
  } finally {
    isSubmitting.value = false;
  }
};

const removerImagem = (id) => {//-> Invocando rota no Laravel para remover a imagem de um produto
  if (!confirm('Deseja realmente remover esta imagem?')) return;

  router.delete(route('removerImagem', id), {
    onSuccess: () => {
      imagensAtuais.value = imagensAtuais.value.filter(img => img.id !== id);
    },
    onError: (err) => {
      alert('Erro ao remover imagem.');
      console.error(err);
    }
  });
};

const removerImagemPreview = (index) => {
  previews.value.splice(index, 1);
  form.imagens.splice(index, 1); // Remove também o arquivo correspondente
};
</script>

<template>
<backgroundLayout>
    <navbar></navbar>
    <p v-if="message" class="mensagem-sucesso">{{ message }}</p>
    <section class="section-cadastro">
        <div class="formulario-container">
            <h2>Altere seu produto</h2>
            <form @submit.prevent="enviarFormulario" enctype="multipart/form-data">
                <div class="formulario-grupo">
                    <div class="formulario-grupo">
                      <div v-if="props.confeitaria" class="formulario-grupo">
                          <label for="confeitaria_id">Confeitaria</label>
                          <input type="text" :value="props.confeitaria.nome" disabled />
                      </div>
                    </div> 
                </div>
                <div class="grupo-nome-preco">
                    <div class="formulario-grupo">
                        <label for="nome">Nome do produto</label>
                        <input type="text" id="nome" v-model="form.nome" required/>
                    </div>
                    <div class="formulario-grupo">
                        <label for="valor">Preço</label>
                        <input type="number" id="valor" v-model="form.valor" step="0.01" min="0.00" required/>
                    </div>
                </div>
                <div class="formulario-grupo">
                    <label for="descricao">Descrição</label>
                    <textarea type="textarea" id="descricao" v-model="form.descricao" required></textarea>
                </div>
                <div class="formulario-grupo-button">
                    <label for="imagens">Imagens</label>
                    <input type="file" id="imagens" @change="viewImage" multiple accept="image/*" style="display: none;"/>
                    <label for="imagens" class="custom-file-upload">Adicionar imagens</label>
                </div>
                
                <div class="preview-container" v-if="imagensAtuais.length">
                    <div class="preview-imagens">
                        <div v-for="(img, index) in imagensAtuais" :key="'existente-' + index" class="imagem-container">
                            <img :src="'/storage/' + img.url_imagem" alt="Imagem atual" />
                            <button type="button" class="btn-remover" @click="removerImagem(img.id)">Remover</button>
                        </div>
                    </div>
                </div>
                
                <!-- Pré-visualização de novas imagens -->
                <div class="preview-container" v-if="previews.length">
                 
                    <div class="preview-imagens">
                        <div v-for="(img, index) in previews" :key="'preview-' + index" class="imagem-container">
                            <img :src="img" alt="Pré-visualização da imagem" />
                            <button type="button" class="btn-remover" @click="removerImagemPreview(index)">Remover</button>
                        </div>
                    </div>
                </div>

                <button type="submit" :disabled="isSubmitting">Salvar produto</button>
            </form>
        </div>
    </section>
</backgroundLayout>
</template>

<style scoped>
.section-cadastro {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 50px;
  box-sizing: border-box;
}

.formulario-container{
  max-height: 100vh;
  width: 450px;
  padding: 20px;
  border-radius: 12px;
  background-color: rgba(255, 255, 255, 0.95);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
h2{
    text-align: center;
    margin-bottom: 10px;
    
}
.formulario-grupo{
    margin-bottom: 5px;
    display: flex;
    flex-direction: column;
}
.formulario-grupo-button{
    display: flex;
    justify-content: space-between;
}
.grupo-nome-preco{
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
}
label{
    margin-bottom: 2px;
    font-weight: 600;
    
}
input,textarea,select, option {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 15px;
}
textarea{
    resize: vertical;
    max-height: 55px;
}
button{
    width: 100%;
    padding: 14px;
    background-color: black;
    color: white;
    font-weight: bold;
    border: none;
    border-radius: 10px;
    cursor: pointer;
}
button:hover{
    background-color: #555;
}
.preview-container{
  margin: 1rem 0;
  overflow-x: auto;
  white-space: nowrap;
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 10px;
  background-color: #f9f9f9;
  max-width: 100%;
  box-sizing: border-box;
}
.preview-imagens{
  display: inline-flex;
  gap: 10px;
}
.preview-imagens img {
    width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 6px;
  border: 1px solid #ddd;
  flex-shrink: 0;
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
.imagem-container {
  position: relative;
  
}
.btn-remover {
  position: absolute;
  top: 4px;
  right: 4px;
  background-color: red;
  color: white;
  border: none;
  padding: 4px 6px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 12px;
}
.custom-file-upload {
  top: 4px;
  right: 4px;
  background-color: black;
  color: white;
  border: none;
  padding: 4px 6px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 12px;
}

.custom-file-upload:hover {
  background-color: #444;
}
</style>