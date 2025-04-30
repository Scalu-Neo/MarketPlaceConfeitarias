🍰 Confeitarias App
Projeto web para cadastro, exibição e gerenciamento de produtos de confeitarias. Utiliza Laravel, Vue 3, Inertia.js e PostgreSQL com integração de mapa via Leaflet e localização usando Geoapify API.

🚀 Tecnologias Utilizadas
Laravel 12.x

Vue 3

Inertia.js

PostgreSQL

Leaflet

Geoapify Geocoding API

🧰 Pré-requisitos
PHP >= 8.2

Node.js >= 18.x

Composer

PostgreSQL ou SQLite

Geoapify API Key

⚙️ Instalação do Projeto
Clone o repositório:

bash
Copiar
Editar
git clone https://github.com/seu-usuario/nome-do-repositorio.git
cd nome-do-repositorio
Instale as dependências do Laravel e do Vue:

bash
Copiar
Editar
composer install
npm install
Copie o arquivo de exemplo .env e configure as variáveis:

bash
Copiar
Editar
cp .env.example .env
Edite o .env e configure sua chave:

ini
Copiar
Editar
GEOCODE_API_KEY=coloque-sua-chave-aqui
Gere a chave da aplicação:

bash
Copiar
Editar
php artisan key:generate
Configure o banco de dados (no .env):

env
Copiar
Editar
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
Rode as migrations:

bash
Copiar
Editar
php artisan migrate
Inicie os servidores:

bash
Copiar
Editar
npm run dev
php artisan serve
Alternativamente, rode tudo com:

bash
Copiar
Editar
composer run dev
🌍 Funcionalidades
Cadastro, listagem e exclusão de produtos

Upload de múltiplas imagens por produto

Visualização de confeitarias no mapa com Leaflet

Localização geográfica baseada em endereço via Geoapify

Interface dinâmica com Vue + Inertia.js