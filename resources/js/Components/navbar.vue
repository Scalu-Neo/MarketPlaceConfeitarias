<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template> 
  <header class="navbar">
    <nav class="container">
      <ul class="nav-list">
        <li><Link :href="route('home')">Home</Link></li>
        <li class="has-submenu">
          <span>Confeitarias</span>
          <ul class="submenu">
            <li><Link :href="route('confeitariaCadastroGet')">Cadastrar Confeitaria</Link></li>
            <li><Link :href="route('ListarConfeitarias')">Listar Confeitarias</Link></li>
          </ul>
        </li>
        <li class="has-submenu">
          <span>Produtos</span>
          <ul class="submenu">
            <li><Link :href="route('cadastrarProduto')">Cadastrar Produto</Link></li>
            <li><Link :href="route('listarProdutos')">Listar Produtos</Link></li>
          </ul>
        </li>
        <li><a href="#contato">Contato</a></li>
      </ul>
    </nav>
  </header>
</template>

  
  <style scoped>
  .navbar {
    padding-top: 30px;
   
  }
  .container {
    width: 100%;
    max-width: 1200px;
    margin-left: 0;
    padding-left: 40px;
    display: flex;
    justify-content: flex-start;
  }
  .nav-list {
    display: flex;
    justify-content:flex-start;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 25px;
  }
  .nav-list li {
    margin-right: 55px;
  }
  .nav-list li a {
    text-decoration: none;
    color: #e8e8e8;
    font-weight: 500;
  }
  .nav-list li a:hover {
    color: black;
  }
  /* Submenu escondido por padrão */
.has-submenu {
  position: relative;
  
}
span {
  color: white;
  text-decoration: none;
}
span:hover {
  color: #ccc;
}
.submenu {
  display:none;
  position: absolute;
  min-width: 20px;
  width: 150px;
  top: 100%;
  background-color: black;
  padding: 5px 0;
  border-radius: 10px;
  list-style: none;
}

/* Mostrar submenu ao passar o mouse */
.has-submenu:hover .submenu {
  display: block;
}

/* Estilo dos links dentro do submenu */
.submenu li {
  padding: 10px 10px;
}

.submenu li a {
  color: #e8e8e8;
  text-decoration: none;
  font-size: 22px;
  display: block;
  transition: background 0.2s;
}

.submenu li a:hover {
  width: 130px;
  background-color: #555;
  color: white;
}

</style>
  
