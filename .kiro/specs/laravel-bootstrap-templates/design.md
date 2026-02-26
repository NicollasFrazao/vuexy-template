# Documento de Design Técnico

## Visão Geral

Este documento detalha o design técnico para a criação de dois templates Laravel integrados com Bootstrap 5 no repositório Vuexy. O sistema será implementado como duas branches Git independentes, cada uma contendo um projeto Laravel completo e funcional.

### Objetivos do Design

- Criar uma estrutura de branches Git que permita manutenção independente de duas versões do template
- Integrar templates HTML/CSS/JS existentes do Vuexy com a arquitetura Laravel
- Fornecer um sistema de build moderno usando Vite para compilação de assets
- Implementar layouts Blade reutilizáveis seguindo as melhores práticas do Laravel
- Garantir compatibilidade total com Bootstrap 5 e responsividade
- Fornecer documentação clara e exemplos práticos para desenvolvedores

### Decisões de Design Principais

1. **Vite vs Laravel Mix**: Optamos por Vite como sistema de build, pois é o padrão oficial do Laravel 9+ e oferece hot-reload mais rápido e melhor experiência de desenvolvimento.

2. **Estrutura de Branches**: Cada branch será completamente independente com seu próprio projeto Laravel, permitindo evolução separada sem conflitos de merge.

3. **Organização de Assets**: Assets do template serão organizados em `resources/` para processamento pelo Vite, com output em `public/build/`.

4. **Componentes Blade**: Utilizaremos componentes Blade modernos (class-based) em vez de includes tradicionais para melhor reutilização e manutenibilidade.

## Arquitetura

### Estrutura de Branches Git

```
repositório-vuexy/
├── template/laravel/bootstrap/starter    (Branch_Starter)
│   └── [Projeto Laravel completo - versão starter]
└── template/laravel/bootstrap/full       (Branch_Full)
    └── [Projeto Laravel completo - versão full]
```

Cada branch conterá:
- Instalação completa do Laravel (última versão estável)
- Assets do template Vuexy integrados
- Configuração Vite personalizada
- Layouts e componentes Blade
- Rotas e controllers de exemplo
- Migrations e models de exemplo
- Documentação completa

### Arquitetura de Camadas

```
┌─────────────────────────────────────────┐
│         Camada de Apresentação          │
│  (Blade Templates + Bootstrap 5 UI)     │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│         Camada de Aplicação             │
│  (Controllers + Form Requests)          │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│         Camada de Domínio               │
│  (Models + Business Logic)              │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│         Camada de Dados                 │
│  (Eloquent ORM + Migrations)            │
└─────────────────────────────────────────┘
```

### Fluxo de Build de Assets

```
Template Vuexy (HTML/CSS/JS)
         ↓
resources/css/ e resources/js/
         ↓
    Vite Build
         ↓
public/build/ (assets compilados)
         ↓
Blade Templates (@vite directive)
         ↓
    Navegador
```

## Componentes e Interfaces

### 1. Sistema de Build (Vite)

**Arquivo**: `vite.config.js`

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/core.css',
                'resources/js/app.js',
                'resources/js/template.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            '@css': '/resources/css',
            '@img': '/resources/images',
        }
    }
});
```

**Responsabilidades**:
- Compilar arquivos CSS do Bootstrap 5 e customizações do Vuexy
- Processar arquivos JavaScript e suas dependências
- Otimizar imagens e fontes
- Fornecer hot-reload durante desenvolvimento
- Gerar hashes de cache para assets em produção

### 2. Estrutura de Layouts Blade

**Layout Principal**: `resources/views/layouts/app.blade.php`

```php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    
    @vite(['resources/css/app.css', 'resources/css/core.css'])
    @stack('styles')
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Sidebar -->
            <x-sidebar />
            
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <x-navbar />
                
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    
                    <!-- Footer -->
                    <x-footer />
                    
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    
    @vite(['resources/js/app.js', 'resources/js/template.js'])
    @stack('scripts')
</body>
</html>
```

**Componentes Blade**:

1. **Sidebar Component**: `resources/views/components/sidebar.blade.php`
   - Renderiza menu lateral com itens de navegação
   - Suporta menu hierárquico (itens com sub-itens)
   - Marca item ativo baseado na rota atual

2. **Navbar Component**: `resources/views/components/navbar.blade.php`
   - Barra de navegação superior
   - Área de notificações e perfil do usuário
   - Toggle para menu mobile

3. **Footer Component**: `resources/views/components/footer.blade.php`
   - Rodapé com informações de copyright
   - Links úteis

### 3. Sistema de Rotas

**Arquivo**: `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;

// Rota principal
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Rotas de exemplo
Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/account-settings', [PageController::class, 'accountSettings'])
        ->name('account-settings');
    Route::get('/profile', [PageController::class, 'profile'])
        ->name('profile');
});

// Para full-version: rotas adicionais para todas as páginas do template
```

### 4. Controllers

**DashboardController**: `app/Http/Controllers/DashboardController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard principal
     */
    public function index(): View
    {
        return view('dashboard', [
            'pageTitle' => 'Dashboard',
            'stats' => $this->getDashboardStats(),
        ]);
    }
    
    /**
     * Obtém estatísticas para o dashboard
     */
    private function getDashboardStats(): array
    {
        return [
            'users' => 1234,
            'revenue' => 45678,
            'orders' => 890,
        ];
    }
}
```

**PageController**: `app/Http/Controllers/PageController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function accountSettings(): View
    {
        return view('pages.account-settings');
    }
    
    public function profile(): View
    {
        return view('pages.profile');
    }
}
```

### 5. Organização de Assets

**Estrutura de Diretórios**:

```
resources/
├── css/
│   ├── app.css                 # Estilos customizados da aplicação
│   ├── core.css                # Estilos principais do Vuexy
│   ├── theme-default.css       # Tema padrão
│   └── vendors/                # CSS de bibliotecas terceiras
├── js/
│   ├── app.js                  # JavaScript principal da aplicação
│   ├── template.js             # Scripts do template Vuexy
│   ├── menu.js                 # Lógica do menu
│   └── vendors/                # JS de bibliotecas terceiras
├── images/
│   ├── logo.png
│   ├── avatars/
│   └── illustrations/
└── views/
    ├── layouts/
    ├── components/
    ├── pages/
    └── dashboard.blade.php
```

### 6. Sistema de Configuração

**Variáveis de Ambiente** (`.env.example`):

```env
APP_NAME="Vuexy Laravel"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vuexy_laravel
DB_USERNAME=root
DB_PASSWORD=

VITE_APP_NAME="${APP_NAME}"
```

## Modelos de Dados

### 1. Model de Exemplo: User

**Arquivo**: `app/Models/User.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
```

### 2. Migration de Exemplo

**Arquivo**: `database/migrations/2024_01_01_000000_add_profile_fields_to_users_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email');
            $table->string('role')->default('user')->after('avatar');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'role']);
        });
    }
};
```

### 3. Relacionamentos de Dados

Para a versão full, podemos ter models adicionais:

- **User**: Usuário do sistema
- **Post**: Postagens/artigos (exemplo)
- **Category**: Categorias para organização
- **Setting**: Configurações da aplicação

**Diagrama de Relacionamentos**:

```
User (1) ──── (N) Post
              │
              │
Category (1) ─┘
```


## Correctness Properties

*Uma propriedade é uma característica ou comportamento que deve ser verdadeiro em todas as execuções válidas de um sistema - essencialmente, uma declaração formal sobre o que o sistema deve fazer. As propriedades servem como ponte entre especificações legíveis por humanos e garantias de correção verificáveis por máquina.*

### Property 1: Estrutura Laravel Completa

*Para qualquer* branch criada (starter ou full), o projeto deve conter todos os diretórios essenciais do Laravel (app/, config/, database/, public/, resources/, routes/, storage/, tests/), arquivo composer.json com dependências padrão do Laravel, e arquivo package.json com dependências frontend padrão.

**Valida: Requisitos 1.3, 2.2, 2.3, 10.1**

### Property 2: Configuração de Build Processa Assets

*Para qualquer* tipo de asset (CSS, JavaScript, imagens, fontes), a configuração do Vite deve incluir regras de processamento que transformem os arquivos de entrada em resources/ para arquivos otimizados em public/build/.

**Valida: Requisitos 5.1, 5.2, 5.3**

### Property 3: Assets Referenciados Existem

*Para qualquer* página renderizada, todos os assets referenciados (arquivos CSS via tags link, arquivos JavaScript via tags script, imagens via tags img, fontes via @font-face) devem existir no sistema de arquivos e ser acessíveis via HTTP.

**Valida: Requisitos 3.2, 11.1, 11.2, 11.3, 11.4**

### Property 4: Rotas Renderizam Páginas Válidas

*Para qualquer* rota definida em routes/web.php, fazer uma requisição HTTP GET deve retornar status 200 e HTML válido contendo as estruturas do template (DOCTYPE, html, head, body).

**Valida: Requisitos 7.3, 7.4**

### Property 5: Layouts Blade Usam Seções Dinâmicas

*Para qualquer* arquivo de layout Blade (arquivos em resources/views/layouts/), o conteúdo deve incluir pelo menos uma diretiva @yield ou @section para permitir conteúdo dinâmico de views filhas.

**Valida: Requisito 6.3**

### Property 6: Views Herdam Componentes do Layout

*Para qualquer* view Blade que estende um layout (usando @extends), quando renderizada, o HTML resultante deve incluir todos os componentes visuais do layout (sidebar, navbar, footer) além do conteúdo específico da view.

**Valida: Requisitos 3.4, 6.5**

### Property 7: Namespaces Seguem PSR-4

*Para qualquer* classe PHP no projeto (controllers, models, middlewares), o namespace declarado deve corresponder exatamente à estrutura de diretórios relativa ao diretório app/, seguindo o padrão PSR-4 (ex: App\Http\Controllers para app/Http/Controllers/).

**Valida: Requisito 10.2**

## Tratamento de Erros

### Estratégias de Tratamento de Erros

1. **Erros de Build (Vite)**
   - **Cenário**: Falha ao compilar assets (sintaxe CSS/JS inválida, arquivo não encontrado)
   - **Tratamento**: Vite deve exibir mensagem de erro clara no terminal e no navegador (overlay de erro), indicando arquivo e linha do problema
   - **Recuperação**: Hot-reload automático quando o erro for corrigido

2. **Erros de Rota (404)**
   - **Cenário**: Usuário acessa rota não definida
   - **Tratamento**: Laravel deve renderizar página 404 customizada usando o layout do template
   - **Implementação**: Criar `resources/views/errors/404.blade.php` estendendo o layout principal

3. **Erros de View (Blade)**
   - **Cenário**: Sintaxe Blade inválida, variável não definida, componente não encontrado
   - **Tratamento**: Em desenvolvimento (APP_DEBUG=true), exibir página de erro detalhada do Laravel com stack trace
   - **Produção**: Renderizar página de erro genérica sem expor detalhes internos

4. **Erros de Banco de Dados**
   - **Cenário**: Conexão falha, query inválida, constraint violation
   - **Tratamento**: Capturar exceções de banco de dados e logar detalhes
   - **Usuário**: Exibir mensagem amigável sem expor estrutura do banco
   - **Implementação**: Usar try-catch em controllers e retornar respostas apropriadas

5. **Erros de Assets Faltantes**
   - **Cenário**: Imagem, CSS ou JS referenciado não existe
   - **Tratamento**: 
     - Navegador exibirá erro 404 no console
     - Implementar fallback para imagens (placeholder padrão)
     - Validar existência de assets críticos durante build

6. **Erros de Configuração**
   - **Cenário**: Variável de ambiente faltando, configuração inválida
   - **Tratamento**: 
     - Validar variáveis essenciais no bootstrap da aplicação
     - Fornecer valores padrão seguros quando possível
     - Falhar rapidamente com mensagem clara se configuração crítica estiver faltando

### Logging

```php
// Configuração de logging em config/logging.php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'daily'],
    ],
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'days' => 14,
    ],
],
```

### Validação de Entrada

Para formulários futuros, usar Form Requests:

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.unique' => 'Este email já está em uso.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
        ];
    }
}
```

## Estratégia de Testes

### Abordagem Dual de Testes

Este projeto utilizará uma combinação de testes unitários e testes baseados em propriedades para garantir cobertura abrangente:

- **Testes Unitários**: Verificam exemplos específicos, casos extremos e condições de erro
- **Testes de Propriedades**: Verificam propriedades universais através de múltiplas entradas geradas
- Ambos são complementares e necessários para cobertura completa

### Framework de Testes

**PHPUnit**: Framework padrão do Laravel para testes unitários e de feature

```bash
# Executar todos os testes
php artisan test

# Executar com cobertura
php artisan test --coverage
```

### Testes Unitários

Os testes unitários devem focar em:

1. **Exemplos Específicos**: Casos concretos que demonstram comportamento correto
2. **Casos Extremos**: Entradas vazias, valores nulos, limites
3. **Condições de Erro**: Validação de tratamento de erros
4. **Pontos de Integração**: Interação entre componentes

**Exemplo de Teste Unitário**:

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    /** @test */
    public function dashboard_page_loads_successfully()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        $response->assertSee('Dashboard');
    }
    
    /** @test */
    public function dashboard_includes_sidebar_component()
    {
        $response = $this->get('/');
        
        $response->assertSee('layout-menu');
        $response->assertSee('menu-inner');
    }
}
```

### Testes Baseados em Propriedades

Para testes de propriedades em PHP, utilizaremos a biblioteca **Eris** (port do QuickCheck para PHP).

**Instalação**:
```bash
composer require --dev giorgiosironi/eris
```

**Configuração**: Cada teste de propriedade deve executar no mínimo 100 iterações para garantir cobertura adequada através de randomização.

**Formato de Tag**: Cada teste deve referenciar a propriedade do documento de design:
```php
/**
 * Feature: laravel-bootstrap-templates, Property 1: Estrutura Laravel Completa
 */
```

**Exemplo de Teste de Propriedade**:

```php
<?php

namespace Tests\Property;

use Eris\TestTrait;
use Tests\TestCase;

class LaravelStructureTest extends TestCase
{
    use TestTrait;
    
    /**
     * Feature: laravel-bootstrap-templates, Property 1: Estrutura Laravel Completa
     * 
     * @test
     */
    public function any_branch_contains_complete_laravel_structure()
    {
        $this->forAll(
            Generator\elements(['starter', 'full'])
        )->then(function ($branchType) {
            // Verificar diretórios essenciais
            $requiredDirs = [
                'app', 'config', 'database', 'public', 
                'resources', 'routes', 'storage', 'tests'
            ];
            
            foreach ($requiredDirs as $dir) {
                $this->assertDirectoryExists(base_path($dir));
            }
            
            // Verificar arquivos essenciais
            $this->assertFileExists(base_path('composer.json'));
            $this->assertFileExists(base_path('package.json'));
            $this->assertFileExists(base_path('artisan'));
            
            // Verificar dependências no composer.json
            $composer = json_decode(
                file_get_contents(base_path('composer.json')), 
                true
            );
            $this->assertArrayHasKey('laravel/framework', $composer['require']);
        });
        
        $this->minimum(100); // Mínimo 100 iterações
    }
    
    /**
     * Feature: laravel-bootstrap-templates, Property 4: Rotas Renderizam Páginas Válidas
     * 
     * @test
     */
    public function any_defined_route_renders_valid_html()
    {
        $routes = \Route::getRoutes();
        $getRoutes = array_filter($routes->getRoutes(), function($route) {
            return in_array('GET', $route->methods());
        });
        
        $this->forAll(
            Generator\elements(array_values($getRoutes))
        )->then(function ($route) {
            $response = $this->get($route->uri());
            
            // Deve retornar 200
            $this->assertEquals(200, $response->status());
            
            // Deve conter estrutura HTML válida
            $content = $response->getContent();
            $this->assertStringContainsString('<!DOCTYPE', $content);
            $this->assertStringContainsString('<html', $content);
            $this->assertStringContainsString('<head>', $content);
            $this->assertStringContainsString('<body>', $content);
        });
        
        $this->minimum(100);
    }
}
```

### Testes de Integração

Verificar integração entre componentes:

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class AssetIntegrationTest extends TestCase
{
    /** @test */
    public function vite_manifest_contains_all_entry_points()
    {
        $this->artisan('vite:build')->assertSuccessful();
        
        $manifest = json_decode(
            file_get_contents(public_path('build/manifest.json')),
            true
        );
        
        $this->assertArrayHasKey('resources/css/app.css', $manifest);
        $this->assertArrayHasKey('resources/js/app.js', $manifest);
    }
    
    /** @test */
    public function blade_layout_references_compiled_assets()
    {
        $layoutContent = file_get_contents(
            resource_path('views/layouts/app.blade.php')
        );
        
        $this->assertStringContainsString('@vite', $layoutContent);
    }
}
```

### Testes de Build

Verificar que o sistema de build funciona corretamente:

```bash
# Script de teste de build (tests/build-test.sh)
#!/bin/bash

echo "Testing Vite build..."
npm run build

if [ $? -eq 0 ]; then
    echo "✓ Build successful"
else
    echo "✗ Build failed"
    exit 1
fi

# Verificar se arquivos foram gerados
if [ -f "public/build/manifest.json" ]; then
    echo "✓ Manifest generated"
else
    echo "✗ Manifest not found"
    exit 1
fi
```

### Cobertura de Testes

**Metas de Cobertura**:
- Controllers: 80%+
- Models: 90%+
- Helpers: 95%+
- Views: Testes de renderização para todas as páginas principais

**Ferramentas**:
- PHPUnit com Xdebug para cobertura de código
- Laravel Dusk para testes E2E (opcional, para versão full)

### Estrutura de Diretórios de Testes

```
tests/
├── Feature/              # Testes de features (HTTP, integração)
│   ├── DashboardTest.php
│   ├── PageTest.php
│   └── AssetIntegrationTest.php
├── Property/             # Testes baseados em propriedades
│   ├── LaravelStructureTest.php
│   ├── RouteRenderingTest.php
│   └── AssetExistenceTest.php
├── Unit/                 # Testes unitários puros
│   ├── HelperTest.php
│   └── ServiceTest.php
└── TestCase.php          # Classe base para testes
```

### Automação de Testes

**GitHub Actions** (`.github/workflows/tests.yml`):

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          extensions: mbstring, pdo, pdo_mysql
          
      - name: Install Dependencies
        run: |
          composer install --no-interaction
          npm install
          
      - name: Run Tests
        run: php artisan test --coverage
        
      - name: Build Assets
        run: npm run build
```

### Testes Manuais

Para aspectos que não podem ser testados automaticamente:

1. **Responsividade**: Testar manualmente em diferentes resoluções (mobile, tablet, desktop)
2. **Compatibilidade de Navegadores**: Testar em Chrome, Firefox, Safari, Edge
3. **Acessibilidade**: Usar ferramentas como Lighthouse, axe DevTools
4. **Performance**: Medir tempo de carregamento, tamanho de assets

