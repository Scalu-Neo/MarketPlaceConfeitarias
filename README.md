# 🍰 Confeitarias App

Projeto web para cadastro, exibição e gerenciamento de produtos de confeitarias. Utiliza **Laravel**, **Vue 3**, **Inertia.js** e **PostgreSQL**, com integração de mapa via **Leaflet** e localização usando **Geoapify API**.

---

## 🚀 Tecnologias Utilizadas

- [Laravel 12.x](https://laravel.com/)
- [Vue 3](https://vuejs.org/)
- [Inertia.js](https://inertiajs.com/)
- [PostgreSQL](https://www.postgresql.org/) ou SQLite
- [Leaflet](https://leafletjs.com/)
- [Geoapify Geocoding API](https://www.geoapify.com/)

---

## 🧰 Pré-requisitos

- PHP >= 8.2
- Node.js >= 18.x
- Composer
- PostgreSQL ou SQLite
- Chave da API do [Geoapify](https://www.geoapify.com/)

---

## ⚙️ Instalação do Projeto

### 1. Clone o repositório

```bash
git clone https://github.com/Scalu-Neo/MarketPlaceConfeitarias.git
cd nome-do-repositorio

## ⚙️ Instalação do Projeto

### 2. Instale as dependências

```bash
composer install
npm install

### 3. Copie o `.env.example` e configure as variáveis

```bash
cp .env.example .env

GEOCODE_API_KEY=coloque-sua-chave-aqui

### 4. Gere a chave da aplicação

php artisan key:generate

### 5. Configure o banco de dados
No arquivo .env, atualize os dados de acesso ao seu banco de dados PostgreSQL

```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha

### 6. Rode as migrations

```bash
php artisan migrate

###7. Inicie os servidores de desenvolvimento

```bash
npm run dev

```bash
php artisan serve