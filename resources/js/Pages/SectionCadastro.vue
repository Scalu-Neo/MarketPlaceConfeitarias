<script setup>
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import navbar from '../Components/navbar.vue';
import backgroundLayout from '../Components/backgroundLayout.vue';

const form = useForm({//->Criando um objeto form e setando ''
    nome: '',
    telefone: '',
    cep: '',
    rua: '',
    numero: '',
    bairro: '',
    cidade: '',
    estado: '',
    latitude: '',
    longitude: '',
});

const formatarCep = (cep) => {//->Formatando o padrão do cep
    cep = cep.replace(/\D/g, '');

    if (cep.length === 8) {
        return cep.replace(/^(\d{5})(\d{3})$/, '$1-$2'); 
    }else {
        alert('CEP inválido. Por favor, insira um CEP válido com 8 dígitos.');
        return null;
    }
};

    const formatarTelefone = (telefone) => { //->formatando padrão do telefone
        try{
            telefone = telefone.replace(/\D/g, ''); 
            if (telefone.length === 11) {
            form.telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3'); 
            } else if (telefone.length === 10) {
            form.telefone = telefone.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3');
            }else {
            alert('Insira um formato válido (xx)xxxxx-xxxx ou (xx)xxxx-xxxx');
            }
        }catch(error){
            alert('O formato inválido do telefone.');
        }
    };

const enderecoCompleto = async () => {//->Requisição a API do ViaCep e preenchimento das propriedades do objeto form
    const validarCep = formatarCep(form.cep);

    if (validarCep) {
        try {
            const resposta = await axios.get(`https://viacep.com.br/ws/${validarCep}/json/`);
            const dados = resposta.data;

            if (!dados.erro) {
                form.rua = dados.logradouro;
                form.bairro = dados.bairro;
                form.cidade = dados.localidade;
                form.estado = dados.uf;
            } else {
                alert('CEP não encontrado.');
            }
        } catch (error) {
            alert('Erro ao buscar o CEP.');
        }
    }
};

const buscarCoordenadas = async () => {//->Requisição a API GeoApify no Laravel e preenchimento das propriedades de form
  const enderecoCompleto = `${form.endereco}, ${form.bairro}, ${form.cidade}, ${form.estado}, Brasil`;

  try {
    const resposta = await axios.get(`/api/geocode`, {
      params: {
        endereco: enderecoCompleto
      }
    });

    form.latitude = resposta.data.latitude;
    form.longitude = resposta.data.longitude;

    console.log('Coordenadas:', form.latitude, form.longitude);
    return true;

  } catch (error) {
    alert('Erro ao buscar coordenadas: ' + error.response.data.error);
    return false;
  }
};

const validarEnviarFormulario = async () => {//->Requisição post a rota no Laravel para criar uma confeitaria
    
    let coordenadasValidas = await buscarCoordenadas();
    
    if (coordenadasValidas) {
        form.post('/cadastro/confeitaria', {
            onSuccess: () => {
                form.reset();
                alert('Cadastro realizado com sucesso!');
            },
            onError: (errors) => {
                console.error('Erro de validação', errors);
            }
        });
    } else {
        alert('Erro ao obter as coordenadas relativas ao endereço.');
    }
};
</script>

<template>
    <backgroundLayout>
    <navbar></navbar>
    <section class="section-cadastro">
    <div class="formulario-Container">
        <h2>Cadastre sua confeitaria!</h2>
        <form @submit.prevent="validarEnviarFormulario">

            <div class="formulario-grupo">
                <label for="nome">Nome</label>
                <input v-model="form.nome" type="text" id="nome" required>
            </div>

            <!-- Agrupar telefone e cep -->
            <div class="grupo-telefone-cep-numero-endereco">
                <div class="formulario-grupo-item">
                    <label for="telefone">Telefone</label>
                    <input v-model="form.telefone" type="text" id="telefone" @blur="formatarTelefone(form.telefone)" required>
                </div>
                <div class="formulario-grupo-item">
                    <label for="cep">Cep</label>
                    <input v-model="form.cep" type="text" id="cep" @blur="enderecoCompleto" maxlength="8" required>
                </div>
            </div>

            <!-- Agrupar endereço e número -->
            <div class="grupo-telefone-cep-numero-endereco">
                <div class="formulario-grupo-item">
                    <label for="rua">Endereço</label>
                    <input v-model="form.rua" type="text" id="rua" required disabled>
                </div>
                <div class="formulario-grupo-item">
                    <label for="numero">Número</label>
                    <input v-model="form.numero" type="text" id="numero" required >
                </div>
            </div>
            
            <div class="formulario-grupo">
                <label for="bairro">Bairro</label>
                <input v-model="form.bairro" type="text" id="bairro" required disabled>
            </div>
            <div class="formulario-grupo">
                <label for="cidade">Cidade</label>
                <input v-model="form.cidade" type="text" id="cidade" required disabled>
            </div>
            <div class="formulario-grupo">
                <label for="estado">Estado</label>
                <input v-model="form.estado" type="text" id="estado" required disabled>
            </div>

            <button type="submit" >Salvar</button>
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

.formulario-Container {
  max-height: 80vh;
  width: 450px;
  padding: 20px;
  border-radius: 12px;
  background-color: rgba(255, 255, 255, 0.95);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

h2 {
  text-align: center;
}

.formulario-grupo {
  margin-bottom: 10px;
  display: flex;
  flex-direction: column;
}
.formulario-grupo-item {
    display: flex;
    flex-direction: column;
    margin-right: 10px;
}

.grupo-telefone-cep-numero-endereco {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
}
label {
  margin-bottom: 5px;
  font-weight: 600;
}

input {
  padding: 10px;
  font-size: 15px;
  border-radius: 8px;
  border: 1px solid #ccc;
  outline: none;
}

button {
  width: 100%;
  padding: 10px;
  background-color: #333;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #555;
}
</style>
