# Plano de Implementação: Laravel Bootstrap Templates

## Visão Geral

Este plano detalha as tarefas de implementação para criar dois templates Laravel integrados com Bootstrap 5 no repositório Vuexy. O projeto será implementado em duas branches Git independentes (starter-kit e full-version), cada uma contendo um projeto Laravel completo e funcional.

### Versões de Software

- **Laravel**: 11.x (última versão estável)
- **PHP**: 8.2+
- **MySQL**: 9.1
- **Node.js**: 22.x LTS
- **Bootstrap**: 5.x
- **Vite**: 5.x

## Tarefas

- [x] 1. Configurar estrutura de branches Git e projeto Laravel base
  - Criar branch "template/laravel/bootstrap/starter" a partir da branch principal
  - Instalar Laravel 11.x (última versão estável) usando Composer
  - Gerar arquivo .env a partir do .env.example
  - Gerar APP_KEY usando `php artisan key:generate`
  - Instalar dependências NPM padrão do Laravel
  - Verificar que todos os diretórios essenciais do Laravel existem (app/, config/, database/, public/, resources/, routes/, storage/, tests/)
  - _Requisitos: 1.1, 1.3, 2.1, 2.2, 2.3, 2.4, 2.5, 10.1_

- [x] 1.1 Escrever teste de propriedade para estrutura Laravel completa
  - **Property 1: Estrutura Laravel Completa**
  - **Valida: Requisitos 1.3, 2.2, 2.3, 10.1**
  - Instalar biblioteca Eris para testes baseados em propriedades
  - Criar teste que verifica existência de diretórios e arquivos essenciais
  - Configurar mínimo de 100 iterações

- [x] 2. Configurar sistema de build Vite
  - [x] 2.1 Criar arquivo vite.config.js com configuração personalizada
    - Definir entry points para CSS (app.css, core.css)
    - Definir entry points para JavaScript (app.js, template.js)
    - Configurar aliases para paths (@, @css, @img)
    - Habilitar refresh automático
    - _Requisitos: 5.1, 5.2, 5.3_

  - [x] 2.2 Organizar estrutura de diretórios de assets
    - Criar diretório resources/css/ para estilos
    - Criar diretório resources/js/ para scripts
    - Criar diretório resources/images/ para imagens
    - Criar subdiretórios resources/css/vendors/ e resources/js/vendors/
    - _Requisitos: 3.2, 5.3_

  - [x] 2.3 Escrever teste de propriedade para processamento de assets
    - **Property 2: Configuração de Build Processa Assets**
    - **Valida: Requisitos 5.1, 5.2, 5.3**
    - Criar teste que verifica regras de processamento no vite.config.js
    - Validar que cada tipo de asset tem configuração apropriada

  - [x] 2.4 Configurar scripts NPM no package.json
    - Adicionar script "dev" para desenvolvimento com hot-reload
    - Adicionar script "build" para build de produção
    - Adicionar script "preview" para preview do build
    - _Requisitos: 5.5, 12.2_

- [x] 3. Checkpoint - Verificar configuração base
  - Executar `npm run build` e verificar que assets são gerados em public/build/
  - Verificar que manifest.json é criado
  - Executar `php artisan serve` e confirmar que servidor inicia sem erros
  - Garantir que todos os testes passam, perguntar ao usuário se há dúvidas

- [x] 4. Integrar assets do template Vuexy starter-kit
  - [x] 4.1 Copiar assets CSS do template starter-kit
    - Copiar arquivos CSS da pasta /var/www/vuexy-template/html-laravel-version/Bootstrap5/starter-kit/assets/css/ para resources/css/
    - Organizar arquivos core.css, theme-default.css e vendors
    - Criar resources/css/app.css para customizações
    - _Requisitos: 3.1, 3.2_

  - [x] 4.2 Copiar assets JavaScript do template starter-kit
    - Copiar arquivos JS da pasta starter-kit/assets/js/ para resources/js/
    - Organizar arquivos template.js, menu.js e vendors
    - Criar resources/js/app.js como entry point principal
    - _Requisitos: 3.1, 3.2_

  - [x] 4.3 Copiar imagens e fontes do template starter-kit
    - Copiar imagens da pasta starter-kit/assets/img/ para resources/images/
    - Copiar fontes para resources/fonts/ (se existirem)
    - _Requisitos: 3.1, 3.2, 5.3_

  - [x] 4.4 Atualizar imports nos arquivos CSS e JS
    - Ajustar paths de imports para refletir nova estrutura
    - Usar aliases configurados no Vite (@, @css, @img)
    - Testar que não há erros de módulos não encontrados
    - _Requisitos: 3.3_

- [x] 4.5 Escrever testes de integração para assets
  - Criar teste que verifica existência de manifest.json após build
  - Criar teste que valida entry points no manifest
  - _Requisitos: 5.4_

- [x] 5. Criar estrutura de layouts e componentes Blade
  - [x] 5.1 Criar layout principal app.blade.php
    - Criar resources/views/layouts/app.blade.php
    - Implementar estrutura HTML5 com meta tags apropriadas
    - Adicionar diretivas @vite para carregar assets
    - Implementar seções @yield para title e content
    - Adicionar @stack para styles e scripts adicionais
    - Incluir estrutura de layout do Vuexy (layout-wrapper, layout-container)
    - _Requisitos: 6.1, 6.3, 11.1, 11.2_

  - [x] 5.2 Criar componente Blade para sidebar
    - Criar resources/views/components/sidebar.blade.php
    - Implementar menu lateral com estrutura do Vuexy
    - Adicionar itens de menu de exemplo
    - Implementar lógica para marcar item ativo baseado na rota
    - _Requisitos: 6.2_

  - [x] 5.3 Criar componente Blade para navbar
    - Criar resources/views/components/navbar.blade.php
    - Implementar barra de navegação superior
    - Adicionar toggle para menu mobile
    - Adicionar área de notificações e perfil (placeholder)
    - _Requisitos: 6.2_

  - [x] 5.4 Criar componente Blade para footer
    - Criar resources/views/components/footer.blade.php
    - Adicionar informações de copyright
    - Adicionar links úteis (placeholder)
    - _Requisitos: 6.2_

  - [x] 5.5 Escrever teste de propriedade para layouts Blade
    - **Property 5: Layouts Blade Usam Seções Dinâmicas**
    - **Valida: Requisito 6.3**
    - Criar teste que verifica presença de @yield ou @section em layouts
    - Validar que layouts permitem conteúdo dinâmico

  - [x] 5.6 Escrever teste de propriedade para herança de componentes
    - **Property 6: Views Herdam Componentes do Layout**
    - **Valida: Requisitos 3.4, 6.5**
    - Criar teste que verifica se views que estendem layouts incluem todos os componentes
    - Validar presença de sidebar, navbar e footer no HTML renderizado

- [x] 6. Checkpoint - Verificar layouts e componentes
  - Executar `npm run build` para compilar assets atualizados
  - Criar view de teste temporária que estende o layout
  - Verificar que todos os componentes são renderizados corretamente
  - Garantir que todos os testes passam, perguntar ao usuário se há dúvidas

- [x] 7. Implementar rotas e controllers de exemplo
  - [x] 7.1 Criar DashboardController
    - Criar app/Http/Controllers/DashboardController.php
    - Implementar método index() que retorna view dashboard
    - Adicionar método privado getDashboardStats() com dados de exemplo
    - _Requisitos: 7.2_

  - [x] 7.2 Criar PageController
    - Criar app/Http/Controllers/PageController.php
    - Implementar métodos accountSettings() e profile()
    - Cada método deve retornar sua respectiva view
    - _Requisitos: 7.2_

  - [x] 7.3 Definir rotas no web.php
    - Adicionar rota principal '/' apontando para DashboardController@index
    - Adicionar grupo de rotas 'pages' com prefix e name
    - Adicionar rotas para account-settings e profile
    - _Requisitos: 7.1, 7.3_

  - [x] 7.4 Escrever teste de propriedade para renderização de rotas
    - **Property 4: Rotas Renderizam Páginas Válidas**
    - **Valida: Requisitos 7.3, 7.4**
    - Criar teste que verifica todas as rotas GET definidas
    - Validar status 200 e estrutura HTML válida para cada rota

  - [x] 7.5 Escrever testes unitários para controllers
    - Testar DashboardController::index retorna view correta
    - Testar que dashboard inclui componentes do layout
    - Testar PageController retorna views corretas
    - _Requisitos: 7.4_

- [x] 8. Criar views para páginas de exemplo
  - [x] 8.1 Criar view dashboard.blade.php
    - Criar resources/views/dashboard.blade.php
    - Estender layout principal usando @extends
    - Implementar seção @section('content') com conteúdo do dashboard
    - Adicionar cards de estatísticas usando Bootstrap 5
    - Usar estrutura e classes do template Vuexy
    - _Requisitos: 3.4, 3.5, 6.4_

  - [x] 8.2 Criar views para páginas adicionais
    - Criar resources/views/pages/account-settings.blade.php
    - Criar resources/views/pages/profile.blade.php
    - Cada view deve estender o layout principal
    - Implementar conteúdo de exemplo usando componentes Bootstrap 5
    - _Requisitos: 6.4, 7.3_

- [x] 8.3 Escrever testes de feature para views
  - Testar que dashboard carrega com status 200
  - Testar que views incluem título correto
  - Testar que componentes visuais estão presentes
  - _Requisitos: 6.5_

- [x] 9. Configurar banco de dados e models
  - [x] 9.1 Atualizar arquivo .env.example com configurações de banco
    - Adicionar variáveis DB_CONNECTION, DB_HOST, DB_PORT
    - Adicionar DB_DATABASE, DB_USERNAME, DB_PASSWORD
    - Documentar valores padrão recomendados
    - _Requisitos: 8.1, 12.1_

  - [x] 9.2 Criar migration para adicionar campos ao model User
    - Criar migration add_profile_fields_to_users_table
    - Adicionar campos avatar (string, nullable) e role (string, default 'user')
    - Implementar métodos up() e down()
    - _Requisitos: 8.2_

  - [x] 9.3 Atualizar model User
    - Adicionar campos 'avatar' e 'role' ao array $fillable
    - Manter configuração de $hidden e $casts
    - _Requisitos: 8.3_

  - [x] 9.4 Escrever testes unitários para model User
    - Testar que campos fillable estão configurados corretamente
    - Testar que campos hidden não aparecem em JSON
    - Testar casting de password
    - _Requisitos: 8.3_

- [x] 9.5 Atualizar para Laravel 11.x e versões mais recentes
  - [x] 9.5.1 Atualizar dependências do Composer
    - Atualizar composer.json para Laravel 11.x
    - Executar `composer update` para atualizar todas as dependências
    - Resolver conflitos de dependências se houver
    - _Requisitos: 1.3, 2.1_

  - [x] 9.5.2 Atualizar configurações do Laravel 11
    - Revisar e atualizar arquivos de configuração para Laravel 11
    - Verificar mudanças em config/app.php, config/database.php
    - Atualizar service providers se necessário
    - Verificar compatibilidade de middleware
    - _Requisitos: 2.2, 8.1_

  - [x] 9.5.3 Reconstruir containers Docker com novas versões
    - Executar `make clean` para remover containers antigos
    - Executar `make build` para reconstruir com PHP 8.2, MySQL 9.1, Node 22
    - Verificar que todos os containers iniciam sem erros
    - Testar conectividade entre serviços
    - _Requisitos: 12.1_

  - [x] 9.5.4 Executar testes após atualização
    - Executar suite completa de testes
    - Corrigir testes quebrados devido a mudanças no Laravel 11
    - Verificar que migrations funcionam com MySQL 9.1
    - Validar que assets compilam com Node 22
    - _Requisitos: 5.5, 12.2_

  - [x] 9.5.5 Atualizar documentação com novas versões
    - Atualizar README.md com requisitos de versão atualizados
    - Documentar mudanças específicas do Laravel 11
    - Adicionar notas sobre compatibilidade
    - Atualizar comandos de instalação se necessário
    - _Requisitos: 9.1, 12.5_

- [x] 10. Implementar tratamento de erros e páginas de erro customizadas
  - [x] 10.1 Criar view de erro 404
    - Criar resources/views/errors/404.blade.php
    - Estender layout principal
    - Implementar design de página não encontrada usando template Vuexy
    - _Requisitos: 11.5_

  - [x] 10.2 Configurar logging apropriado
    - Verificar configuração em config/logging.php
    - Garantir que canal 'daily' está configurado
    - Definir retenção de logs para 14 dias
    - _Requisitos: 12.3_

  - [x] 10.3 Escrever testes para páginas de erro
    - Testar que rota inexistente retorna 404
    - Testar que página 404 usa layout do template
    - _Requisitos: 11.5_

- [x] 11. Validar compatibilidade e responsividade de assets
  - [x] 11.1 Escrever teste de propriedade para existência de assets
    - **Property 3: Assets Referenciados Existem**
    - **Valida: Requisitos 3.2, 11.1, 11.2, 11.3, 11.4**
    - Criar teste que extrai referências de assets do HTML renderizado
    - Validar que cada asset referenciado existe no sistema de arquivos

  - [x] 11.2 Criar testes de integração para assets
    - Testar que CSS é carregado sem erros 404
    - Testar que JavaScript é carregado sem erros 404
    - Testar que imagens principais são carregadas
    - _Requisitos: 11.1, 11.2, 11.3_

- [x] 12. Checkpoint - Verificar funcionalidade completa do starter-kit
  - Executar `php artisan migrate` e verificar que migrations funcionam
  - Executar `npm run build` e verificar build sem erros
  - Iniciar servidor e navegar por todas as rotas criadas
  - Verificar responsividade em diferentes resoluções (inspecionar manualmente)
  - Garantir que todos os testes passam, perguntar ao usuário se há dúvidas

- [x] 13. Criar documentação README.md
  - [x] 13.1 Escrever seção de requisitos do sistema
    - Listar versões necessárias: PHP 8.2+, Composer 2.x, Node 22.x, NPM 10.x
    - Listar extensões PHP necessárias (PDO, Mbstring, OpenSSL, etc)
    - Especificar MySQL 9.1 ou compatível
    - _Requisitos: 9.1, 12.5_

  - [x] 13.2 Escrever instruções de instalação
    - Documentar passo a passo: clone, composer install, npm install
    - Documentar configuração do .env
    - Documentar geração de APP_KEY
    - Documentar configuração de banco de dados
    - Documentar execução de migrations
    - _Requisitos: 9.2, 12.4_

  - [x] 13.3 Escrever instruções de desenvolvimento
    - Documentar comando para servidor de desenvolvimento
    - Documentar comando para compilar assets (dev e build)
    - Documentar comando para executar testes
    - _Requisitos: 9.3, 9.4_

  - [x] 13.4 Documentar estrutura do projeto
    - Criar diagrama ou lista da estrutura de diretórios
    - Explicar propósito de cada diretório principal
    - Documentar onde adicionar novos componentes
    - _Requisitos: 9.5_

  - [x] 13.5 Documentar como criar novas páginas
    - Fornecer exemplo de criação de nova rota
    - Fornecer exemplo de criação de novo controller
    - Fornecer exemplo de criação de nova view usando layout
    - _Requisitos: 9.6_

- [x] 14. Validar conformidade com PSR-12 e boas práticas
  - [x] 14.1 Escrever teste de propriedade para namespaces PSR-4
    - **Property 7: Namespaces Seguem PSR-4**
    - **Valida: Requisito 10.2**
    - Criar teste que verifica correspondência entre namespaces e estrutura de diretórios
    - Validar todas as classes PHP no projeto

  - [x] 14.2 Executar análise estática de código
    - Instalar PHP_CodeSniffer ou Laravel Pint
    - Executar análise e corrigir problemas de estilo
    - _Requisitos: 10.6_

  - [x] 14.3 Adicionar comentários em código complexo
    - Revisar todos os arquivos criados
    - Adicionar docblocks em métodos públicos
    - Adicionar comentários inline onde lógica não é óbvia
    - _Requisitos: 10.5_

- [x] 15. Checkpoint final - Validação completa do starter-kit
  - Executar suite completa de testes (unitários e de propriedades)
  - Executar build de produção e verificar otimização de assets
  - Revisar documentação para garantir clareza e completude
  - Testar instalação do zero seguindo o README
  - Garantir que todos os testes passam, perguntar ao usuário se há dúvidas

- [ ] 16. Criar branch full-version e adicionar conteúdo adicional
  - [x] 16.1 Criar nova branch a partir do starter-kit
    - Criar branch "template/laravel/bootstrap/full" a partir da branch starter
    - Verificar que todo o conteúdo do starter está presente
    - _Requisitos: 1.2, 1.4_

  - [ ] 16.2 Integrar assets adicionais do template full-version
    - Copiar assets CSS adicionais da pasta full-version para resources/css/
    - Copiar assets JavaScript adicionais para resources/js/
    - Copiar imagens e recursos adicionais para resources/images/
    - Atualizar vite.config.js se necessário para novos entry points
    - _Requisitos: 4.1, 4.2, 4.3_

  - [ ] 16.3 Criar componentes Blade adicionais para full-version
    - Analisar páginas do template full-version
    - Criar componentes reutilizáveis para elementos comuns (cards, modals, etc)
    - Organizar componentes em resources/views/components/
    - _Requisitos: 4.2, 6.2_

  - [ ] 16.4 Criar rotas e controllers para todas as páginas do template
    - Mapear todas as páginas HTML do template full-version
    - Criar controllers apropriados para cada seção
    - Definir rotas organizadas por grupos (ui, pages, forms, tables, etc)
    - _Requisitos: 4.2, 7.5_

  - [ ] 16.5 Criar views Blade para todas as páginas do template
    - Converter páginas HTML do full-version para Blade
    - Garantir que todas estendem o layout principal
    - Substituir conteúdo estático por seções dinâmicas onde apropriado
    - Manter fidelidade visual ao template original
    - _Requisitos: 4.4, 4.5_

  - [ ] 16.6 Escrever testes para páginas adicionais
    - Testar que todas as rotas da full-version retornam 200
    - Testar que páginas incluem componentes corretos
    - Validar estrutura HTML de páginas principais
    - _Requisitos: 4.5, 7.5_

- [ ] 17. Checkpoint - Validação da full-version
  - Executar build e verificar que todos os assets são compilados
  - Navegar por todas as páginas criadas
  - Verificar que não há erros 404 de assets
  - Executar suite de testes
  - Garantir que todos os testes passam, perguntar ao usuário se há dúvidas

- [ ] 18. Atualizar documentação para full-version
  - [ ] 18.1 Atualizar README.md com informações específicas
    - Documentar diferenças entre starter e full-version
    - Listar todas as páginas disponíveis na full-version
    - Atualizar estrutura de diretórios se houver mudanças
    - _Requisitos: 9.1, 9.5_

  - [ ] 18.2 Criar documentação de componentes
    - Documentar componentes Blade disponíveis
    - Fornecer exemplos de uso de cada componente
    - Documentar props e slots aceitos
    - _Requisitos: 9.6_

- [ ] 19. Validação final e testes de aceitação
  - [ ] 19.1 Executar suite completa de testes em ambas as branches
    - Checkout na branch starter e executar todos os testes
    - Checkout na branch full e executar todos os testes
    - Verificar cobertura de testes
    - _Requisitos: todos_

  - [ ] 19.2 Realizar testes manuais de responsividade
    - Testar páginas principais em resoluções mobile (375px, 414px)
    - Testar em resoluções tablet (768px, 1024px)
    - Testar em resoluções desktop (1920px, 2560px)
    - Verificar que menu mobile funciona corretamente
    - _Requisitos: 11.5_

  - [ ] 19.3 Validar compatibilidade de navegadores
    - Testar em Chrome (última versão)
    - Testar em Firefox (última versão)
    - Testar em Safari (se disponível)
    - Testar em Edge (última versão)
    - _Requisitos: 11.1, 11.2, 11.3, 11.4_

- [ ] 20. Checkpoint final - Entrega
  - Revisar checklist completo de requisitos
  - Garantir que ambas as branches estão funcionais e documentadas
  - Verificar que não há código comentado ou arquivos temporários
  - Confirmar que .gitignore está configurado corretamente
  - Garantir que todos os testes passam, perguntar ao usuário se há dúvidas

## Notas

- Tarefas marcadas com `*` são opcionais e podem ser puladas para um MVP mais rápido
- Cada tarefa referencia requisitos específicos para rastreabilidade
- Checkpoints garantem validação incremental do progresso
- Testes de propriedades validam propriedades universais de correção
- Testes unitários validam exemplos específicos e casos extremos
- A implementação deve ser feita primeiro na branch starter-kit, depois adaptada para full-version
- Todos os comandos devem ser executados a partir do diretório base do projeto Laravel
- Durante desenvolvimento, use `npm run dev` para hot-reload de assets
- Para produção, sempre execute `npm run build` antes de deploy
