.PHONY: help build up down restart logs shell composer artisan npm test clean install migrate seed fresh

# Variáveis
DOCKER_COMPOSE = docker-compose
APP_CONTAINER = app
NODE_CONTAINER = node
MYSQL_CONTAINER = mysql

# Cores para output
GREEN = \033[0;32m
YELLOW = \033[0;33m
RED = \033[0;31m
NC = \033[0m # No Color

##@ Ajuda

help: ## Exibe esta mensagem de ajuda
	@echo "$(GREEN)Vuexy Laravel Bootstrap Template - Docker Commands$(NC)"
	@echo ""
	@awk 'BEGIN {FS = ":.*##"; printf "Usage: make $(YELLOW)<target>$(NC)\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  $(YELLOW)%-15s$(NC) %s\n", $$1, $$2 } /^##@/ { printf "\n$(GREEN)%s$(NC)\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

##@ Setup Inicial

install: ## Setup completo da aplicação (primeira vez)
	@echo "$(GREEN)🐳 Iniciando setup do Vuexy Laravel...$(NC)"
	@make env-check
	@make build
	@make up
	@echo "$(YELLOW)⏳ Aguardando containers iniciarem...$(NC)"
	@sleep 10
	@make composer-install
	@make key-generate
	@make migrate
	@make npm-install
	@make npm-build
	@make permissions
	@echo "$(GREEN)✅ Setup concluído com sucesso!$(NC)"
	@make info

env-check: ## Verifica e cria arquivo .env se necessário
	@if [ ! -f .env ]; then \
		echo "$(YELLOW)📝 Criando arquivo .env...$(NC)"; \
		cp .env.example .env; \
		echo "$(GREEN)✅ Arquivo .env criado$(NC)"; \
	else \
		echo "$(GREEN)✅ Arquivo .env já existe$(NC)"; \
	fi

##@ Docker - Gerenciamento de Containers

build: ## Constrói as imagens Docker
	@echo "$(YELLOW)🏗️  Construindo imagens Docker...$(NC)"
	@$(DOCKER_COMPOSE) build

up: ## Inicia os containers
	@echo "$(YELLOW)🚀 Iniciando containers...$(NC)"
	@$(DOCKER_COMPOSE) up -d
	@echo "$(GREEN)✅ Containers iniciados$(NC)"

down: ## Para os containers
	@echo "$(YELLOW)🛑 Parando containers...$(NC)"
	@$(DOCKER_COMPOSE) down
	@echo "$(GREEN)✅ Containers parados$(NC)"

restart: ## Reinicia os containers
	@echo "$(YELLOW)🔄 Reiniciando containers...$(NC)"
	@make down
	@make up

logs: ## Exibe logs de todos os containers
	@$(DOCKER_COMPOSE) logs -f

logs-app: ## Exibe logs do container app
	@$(DOCKER_COMPOSE) logs -f $(APP_CONTAINER)

logs-nginx: ## Exibe logs do container nginx
	@$(DOCKER_COMPOSE) logs -f nginx

logs-mysql: ## Exibe logs do container mysql
	@$(DOCKER_COMPOSE) logs -f $(MYSQL_CONTAINER)

ps: ## Lista containers em execução
	@$(DOCKER_COMPOSE) ps

##@ Shell - Acesso aos Containers

shell: ## Acessa shell do container app
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) bash

shell-node: ## Acessa shell do container node
	@$(DOCKER_COMPOSE) exec $(NODE_CONTAINER) sh

shell-mysql: ## Acessa shell do container mysql
	@$(DOCKER_COMPOSE) exec $(MYSQL_CONTAINER) bash

mysql-cli: ## Acessa MySQL CLI
	@$(DOCKER_COMPOSE) exec $(MYSQL_CONTAINER) mysql -u vuexy -psecret vuexy_laravel

##@ Composer - Gerenciamento de Dependências PHP

composer-install: ## Instala dependências do Composer
	@echo "$(YELLOW)📦 Instalando dependências do Composer...$(NC)"
	@$(DOCKER_COMPOSE) exec -T $(APP_CONTAINER) composer install --no-interaction
	@echo "$(GREEN)✅ Dependências instaladas$(NC)"

composer-update: ## Atualiza dependências do Composer
	@echo "$(YELLOW)📦 Atualizando dependências do Composer...$(NC)"
	@$(DOCKER_COMPOSE) exec -T $(APP_CONTAINER) composer update --no-interaction
	@echo "$(GREEN)✅ Dependências atualizadas$(NC)"

composer-require: ## Instala um pacote (uso: make composer-require PACKAGE=vendor/package)
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) composer require $(PACKAGE)

composer-dump: ## Regenera autoload do Composer
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) composer dump-autoload

##@ NPM - Gerenciamento de Assets

npm-install: ## Instala dependências NPM
	@echo "$(YELLOW)📦 Instalando dependências NPM...$(NC)"
	@$(DOCKER_COMPOSE) exec -T $(NODE_CONTAINER) npm install
	@echo "$(GREEN)✅ Dependências NPM instaladas$(NC)"

npm-update: ## Atualiza dependências NPM
	@$(DOCKER_COMPOSE) exec $(NODE_CONTAINER) npm update

npm-dev: ## Compila assets para desenvolvimento (hot-reload)
	@echo "$(YELLOW)🎨 Compilando assets (dev)...$(NC)"
	@$(DOCKER_COMPOSE) exec $(NODE_CONTAINER) npm run dev

npm-build: ## Compila assets para produção
	@echo "$(YELLOW)🎨 Compilando assets (produção)...$(NC)"
	@$(DOCKER_COMPOSE) exec -T $(NODE_CONTAINER) npm run build
	@echo "$(GREEN)✅ Assets compilados$(NC)"

npm-watch: ## Observa mudanças nos assets
	@$(DOCKER_COMPOSE) exec $(NODE_CONTAINER) npm run watch

##@ Laravel - Comandos Artisan

artisan: ## Executa comando artisan (uso: make artisan CMD="route:list")
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan $(CMD)

key-generate: ## Gera chave da aplicação
	@echo "$(YELLOW)🔑 Gerando chave da aplicação...$(NC)"
	@$(DOCKER_COMPOSE) exec -T $(APP_CONTAINER) php artisan key:generate
	@echo "$(GREEN)✅ Chave gerada$(NC)"

migrate: ## Executa migrations
	@echo "$(YELLOW)🗄️  Executando migrations...$(NC)"
	@$(DOCKER_COMPOSE) exec -T $(APP_CONTAINER) php artisan migrate --force
	@echo "$(GREEN)✅ Migrations executadas$(NC)"

migrate-fresh: ## Reseta banco e executa migrations
	@echo "$(YELLOW)🗄️  Resetando banco e executando migrations...$(NC)"
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan migrate:fresh --force
	@echo "$(GREEN)✅ Banco resetado$(NC)"

migrate-rollback: ## Reverte última migration
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan migrate:rollback

seed: ## Executa seeders
	@echo "$(YELLOW)🌱 Executando seeders...$(NC)"
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan db:seed
	@echo "$(GREEN)✅ Seeders executados$(NC)"

fresh: ## Reseta banco, executa migrations e seeders
	@make migrate-fresh
	@make seed

tinker: ## Abre Laravel Tinker
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan tinker

##@ Cache - Gerenciamento de Cache

cache-clear: ## Limpa cache da aplicação
	@echo "$(YELLOW)🧹 Limpando cache...$(NC)"
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan cache:clear
	@echo "$(GREEN)✅ Cache limpo$(NC)"

config-clear: ## Limpa cache de configuração
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan config:clear

route-clear: ## Limpa cache de rotas
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan route:clear

view-clear: ## Limpa cache de views
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan view:clear

clear-all: ## Limpa todos os caches
	@echo "$(YELLOW)🧹 Limpando todos os caches...$(NC)"
	@make cache-clear
	@make config-clear
	@make route-clear
	@make view-clear
	@echo "$(GREEN)✅ Todos os caches limpos$(NC)"

cache-optimize: ## Otimiza cache para produção
	@echo "$(YELLOW)⚡ Otimizando cache...$(NC)"
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan config:cache
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan route:cache
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan view:cache
	@echo "$(GREEN)✅ Cache otimizado$(NC)"

##@ Testes

test: ## Executa todos os testes
	@echo "$(YELLOW)🧪 Executando testes...$(NC)"
	@$(DOCKER_COMPOSE) exec -T $(APP_CONTAINER) php artisan test

test-filter: ## Executa testes filtrados (uso: make test-filter FILTER=DashboardTest)
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan test --filter=$(FILTER)

test-coverage: ## Executa testes com cobertura
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan test --coverage

test-parallel: ## Executa testes em paralelo
	@$(DOCKER_COMPOSE) exec $(APP_CONTAINER) php artisan test --parallel

##@ Permissões

permissions: ## Configura permissões corretas
	@echo "$(YELLOW)🔐 Configurando permissões...$(NC)"
	@$(DOCKER_COMPOSE) exec -T $(APP_CONTAINER) chown -R www-data:www-data /var/www/storage
	@$(DOCKER_COMPOSE) exec -T $(APP_CONTAINER) chown -R www-data:www-data /var/www/bootstrap/cache
	@$(DOCKER_COMPOSE) exec -T $(APP_CONTAINER) chmod -R 775 /var/www/storage
	@$(DOCKER_COMPOSE) exec -T $(APP_CONTAINER) chmod -R 775 /var/www/bootstrap/cache
	@echo "$(GREEN)✅ Permissões configuradas$(NC)"

##@ Limpeza

clean: ## Remove containers, volumes e imagens
	@echo "$(RED)⚠️  Removendo containers, volumes e imagens...$(NC)"
	@$(DOCKER_COMPOSE) down -v --rmi all
	@echo "$(GREEN)✅ Limpeza concluída$(NC)"

clean-build: ## Remove containers e reconstrói
	@make clean
	@make build
	@make up

prune: ## Remove recursos Docker não utilizados
	@echo "$(YELLOW)🧹 Removendo recursos Docker não utilizados...$(NC)"
	@docker system prune -af --volumes
	@echo "$(GREEN)✅ Prune concluído$(NC)"

##@ Informações

info: ## Exibe informações da aplicação
	@echo ""
	@echo "$(GREEN)╔════════════════════════════════════════════════════════╗$(NC)"
	@echo "$(GREEN)║  Vuexy Laravel Bootstrap Template - Docker Setup      ║$(NC)"
	@echo "$(GREEN)╚════════════════════════════════════════════════════════╝$(NC)"
	@echo ""
	@echo "$(YELLOW)🌐 URLs:$(NC)"
	@echo "   Aplicação:  http://localhost:8000"
	@echo "   Vite HMR:   http://localhost:5173"
	@echo ""
	@echo "$(YELLOW)🗄️  Banco de Dados:$(NC)"
	@echo "   Host:       localhost"
	@echo "   Port:       3306"
	@echo "   Database:   vuexy_laravel"
	@echo "   Username:   vuexy"
	@echo "   Password:   secret"
	@echo ""
	@echo "$(YELLOW)🔴 Redis:$(NC)"
	@echo "   Host:       localhost"
	@echo "   Port:       6379"
	@echo ""
	@echo "$(YELLOW)📚 Comandos úteis:$(NC)"
	@echo "   make help           - Exibe todos os comandos"
	@echo "   make logs           - Ver logs dos containers"
	@echo "   make shell          - Acessar shell do container"
	@echo "   make test           - Executar testes"
	@echo ""

status: ## Verifica status dos containers
	@echo "$(YELLOW)📊 Status dos containers:$(NC)"
	@$(DOCKER_COMPOSE) ps
	@echo ""
	@echo "$(YELLOW)💾 Uso de volumes:$(NC)"
	@docker volume ls | grep vuexy || echo "Nenhum volume encontrado"

##@ Desenvolvimento

dev: ## Inicia ambiente de desenvolvimento completo
	@make up
	@echo "$(YELLOW)🎨 Iniciando Vite dev server...$(NC)"
	@$(DOCKER_COMPOSE) logs -f node

prod-build: ## Build para produção
	@echo "$(YELLOW)🏗️  Construindo para produção...$(NC)"
	@docker build --target production -t vuexy-laravel:prod .
	@echo "$(GREEN)✅ Build de produção concluído$(NC)"

##@ Git

git-status: ## Exibe status do Git
	@git status

git-commit: ## Commit com mensagem (uso: make git-commit MSG="mensagem")
	@git add .
	@git commit -m "$(MSG)"

git-push: ## Push para repositório remoto
	@git push

##@ Atalhos Rápidos

quick-start: install ## Alias para install

rebuild: ## Reconstrói e reinicia tudo
	@make down
	@make build
	@make up
	@make composer-install
	@make npm-install
	@make migrate
	@make permissions

reset: ## Reset completo (limpa tudo e reinstala)
	@make clean
	@make install
