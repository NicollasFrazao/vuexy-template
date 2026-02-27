# Docker Setup - Vuexy Laravel Bootstrap Template

Este documento descreve como usar Docker para rodar a aplicação Laravel com todos os serviços necessários.

## Pré-requisitos

- Docker (versão 20.10 ou superior)
- Docker Compose (versão 1.29 ou superior)
- Make (geralmente já instalado em Linux/Mac)

## Serviços Incluídos

- **app**: Aplicação Laravel (PHP 8.1-FPM)
- **nginx**: Servidor web Nginx
- **mysql**: Banco de dados MySQL 8.0
- **redis**: Cache Redis
- **node**: Node.js 18 para compilar assets com Vite

## Portas Expostas

- **8000**: Aplicação web (Nginx)
- **3306**: MySQL
- **6379**: Redis
- **5173**: Vite dev server (hot-reload)

## Quick Start

### Setup completo (primeira vez)

```bash
make install
```

Este comando irá:
1. Criar arquivo `.env` (se não existir)
2. Construir imagens Docker
3. Iniciar containers
4. Instalar dependências (Composer e NPM)
5. Gerar chave da aplicação
6. Executar migrations
7. Compilar assets
8. Configurar permissões

### Ver todos os comandos disponíveis

```bash
make help
```

## Comandos Principais

### Gerenciamento de Containers

```bash
make up              # Inicia containers
make down            # Para containers
make restart         # Reinicia containers
make logs            # Ver logs de todos os containers
make logs-app        # Ver logs do container app
make ps              # Lista containers em execução
```

### Acesso aos Containers

```bash
make shell           # Acessa shell do container app
make shell-node      # Acessa shell do container node
make mysql-cli       # Acessa MySQL CLI
```

### Composer

```bash
make composer-install                    # Instala dependências
make composer-update                     # Atualiza dependências
make composer-require PACKAGE=vendor/pkg # Instala pacote específico
make composer-dump                       # Regenera autoload
```

### NPM e Assets

```bash
make npm-install     # Instala dependências NPM
make npm-build       # Compila assets (produção)
make npm-dev         # Compila assets (desenvolvimento)
make npm-watch       # Observa mudanças nos assets
```

### Laravel Artisan

```bash
make artisan CMD="route:list"  # Executa comando artisan
make migrate                   # Executa migrations
make migrate-fresh             # Reseta banco e executa migrations
make seed                      # Executa seeders
make fresh                     # Reseta banco, migrations e seeders
make tinker                    # Abre Laravel Tinker
```

### Cache

```bash
make cache-clear      # Limpa cache da aplicação
make config-clear     # Limpa cache de configuração
make route-clear      # Limpa cache de rotas
make view-clear       # Limpa cache de views
make clear-all        # Limpa todos os caches
make cache-optimize   # Otimiza cache para produção
```

### Testes

```bash
make test                          # Executa todos os testes
make test-filter FILTER=Dashboard  # Executa testes filtrados
make test-coverage                 # Executa com cobertura
make test-parallel                 # Executa em paralelo
```

### Limpeza

```bash
make clean           # Remove containers, volumes e imagens
make clean-build     # Remove e reconstrói tudo
make prune           # Remove recursos Docker não utilizados
```

### Informações

```bash
make info            # Exibe informações da aplicação
make status          # Verifica status dos containers
```

### Atalhos Úteis

```bash
make quick-start     # Alias para make install
make rebuild         # Reconstrói e reinicia tudo
make reset           # Reset completo (limpa e reinstala)
make dev             # Inicia ambiente de desenvolvimento
```

## Desenvolvimento com Hot-Reload

O serviço `node` está configurado para rodar `npm run dev` automaticamente, fornecendo hot-reload para os assets.

Para acessar:
- Aplicação: http://localhost:8000
- Vite HMR: http://localhost:5173

Para ver logs do Vite:
```bash
make logs-node
```

## Estrutura de Arquivos Docker

```
.
├── Makefile                    # Comandos Make
├── docker-compose.yml          # Configuração dos serviços
├── Dockerfile                  # Imagem da aplicação PHP
├── .dockerignore              # Arquivos ignorados no build
└── docker/
    ├── nginx/
    │   └── conf.d/
    │       └── default.conf   # Configuração do Nginx
    ├── php/
    │   └── local.ini          # Configuração do PHP
    └── mysql/
        └── my.cnf             # Configuração do MySQL
```

## Workflows Comuns

### Iniciar desenvolvimento

```bash
make up
make dev  # Inicia Vite com hot-reload
```

### Adicionar nova dependência

```bash
# PHP
make composer-require PACKAGE=vendor/package

# JavaScript
make shell-node
npm install package-name
```

### Executar migrations

```bash
make migrate
```

### Resetar banco de dados

```bash
make fresh  # Reseta, executa migrations e seeders
```

### Ver logs de erro

```bash
make logs-app
# ou
make logs-nginx
```

## Troubleshooting

### Permissões de arquivo

```bash
make permissions
```

### Limpar tudo e recomeçar

```bash
make reset
```

### Banco de dados não conecta

Verifique se o MySQL está pronto:

```bash
make logs-mysql
```

Aguarde até ver a mensagem: `ready for connections`

### Assets não compilam

```bash
make shell-node
rm -rf node_modules package-lock.json
npm install
npm run build
```

### Containers não iniciam

```bash
make down
make clean-build
```

## Produção

Para build de produção:

```bash
make prod-build
```

O estágio de produção:
- Instala apenas dependências de produção
- Otimiza autoloader do Composer
- Faz cache de configurações, rotas e views do Laravel
- Remove arquivos desnecessários

## Volumes Persistentes

- **mysql-data**: Dados do MySQL (persistente entre restarts)
- **./**: Código da aplicação (montado como volume para desenvolvimento)

## Rede

Todos os serviços estão na rede `vuexy-network`, permitindo comunicação entre containers usando nomes de serviço.

## Segurança

⚠️ **IMPORTANTE**: As credenciais padrão são para desenvolvimento. Em produção:

1. Altere todas as senhas no `.env`
2. Use secrets do Docker para credenciais sensíveis
3. Configure SSL/TLS no Nginx
4. Restrinja portas expostas
5. Use imagens oficiais e atualizadas

## Exemplos de Uso

### Desenvolvimento diário

```bash
# Manhã - iniciar trabalho
make up

# Durante o dia - ver logs
make logs-app

# Executar testes
make test

# Fim do dia - parar containers
make down
```

### Adicionar nova feature

```bash
# Criar migration
make artisan CMD="make:migration create_posts_table"

# Executar migration
make migrate

# Criar model
make artisan CMD="make:model Post"

# Executar testes
make test
```

### Deploy

```bash
# Build de produção
make prod-build

# Otimizar cache
make cache-optimize

# Executar testes
make test
```
