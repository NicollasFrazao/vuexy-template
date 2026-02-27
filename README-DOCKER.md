# Vuexy Laravel Bootstrap Template - Quick Start

## 🚀 Setup Rápido com Docker

### Pré-requisitos
- Docker
- Docker Compose
- Make

### Instalação (1 comando)

```bash
make install
```

Isso irá configurar tudo automaticamente! ✨

### Acessar a aplicação

🌐 **Aplicação**: http://localhost:8000

### Comandos mais usados

```bash
make help           # Ver todos os comandos
make up             # Iniciar containers
make down           # Parar containers
make logs           # Ver logs
make shell          # Acessar container
make test           # Executar testes
make migrate        # Executar migrations
```

### Documentação completa

📚 Veja [DOCKER.md](DOCKER.md) para documentação detalhada.

---

## 📋 Comandos Rápidos por Categoria

### Containers
```bash
make up              # Iniciar
make down            # Parar
make restart         # Reiniciar
make logs            # Ver logs
```

### Desenvolvimento
```bash
make shell           # Acessar shell
make npm-dev         # Compilar assets (dev)
make npm-build       # Compilar assets (prod)
make artisan CMD="route:list"  # Artisan
```

### Banco de Dados
```bash
make migrate         # Executar migrations
make fresh           # Reset + migrations + seeders
make mysql-cli       # Acessar MySQL
```

### Testes
```bash
make test            # Todos os testes
make test-filter FILTER=Dashboard  # Filtrado
```

### Limpeza
```bash
make clear-all       # Limpar caches
make clean           # Remover tudo
make reset           # Reset completo
```

---

## 🎯 Workflows Comuns

### Primeiro uso
```bash
make install
```

### Desenvolvimento diário
```bash
make up              # Manhã
make logs-app        # Ver logs
make test            # Testar
make down            # Fim do dia
```

### Adicionar dependência
```bash
make composer-require PACKAGE=vendor/package
# ou
make shell-node
npm install package-name
```

### Problemas?
```bash
make reset           # Reset completo
```

---

## 📊 Informações

### Portas
- **8000**: Aplicação
- **3306**: MySQL
- **6379**: Redis
- **5173**: Vite HMR

### Credenciais (desenvolvimento)
- **DB**: vuexy_laravel
- **User**: vuexy
- **Pass**: secret

---

**Dica**: Execute `make help` para ver todos os comandos disponíveis!
