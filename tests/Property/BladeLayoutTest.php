<?php

namespace Tests\Property;

use Eris\TestTrait;
use Tests\TestCase;
use Eris\Generator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class BladeLayoutTest extends TestCase
{
    use TestTrait;
    
    /**
     * Feature: laravel-bootstrap-templates, Property 5: Layouts Blade Usam Seções Dinâmicas
     *
     * **Validates: Requirement 6.3**
     *
     * Para qualquer arquivo de layout Blade (arquivos em resources/views/layouts/),
     * o conteúdo deve incluir pelo menos uma diretiva @yield ou @section para permitir
     * conteúdo dinâmico de views filhas.
     *
     * @test
     */
    public function any_blade_layout_uses_dynamic_sections()
    {
        // Obter todos os arquivos de layout Blade
        $layoutsPath = resource_path('views/layouts');
        
        $this->assertDirectoryExists(
            $layoutsPath,
            "Layouts directory should exist at resources/views/layouts/"
        );
        
        $layoutFiles = File::glob($layoutsPath . '/*.blade.php');
        
        $this->assertNotEmpty(
            $layoutFiles,
            "At least one layout file should exist in resources/views/layouts/"
        );
        
        // Testar cada arquivo de layout
        $this->forAll(
            Generator\elements($layoutFiles)
        )
        ->then(function ($layoutFile) {
            $layoutContent = file_get_contents($layoutFile);
            $layoutName = basename($layoutFile);
            
            // Verificar que o arquivo não está vazio
            $this->assertNotEmpty(
                $layoutContent,
                "Layout file {$layoutName} should not be empty"
            );
            
            // Verificar presença de @yield ou @section
            $hasYield = preg_match('/@yield\s*\(\s*[\'"][^\'"]+[\'"]\s*/', $layoutContent);
            $hasSection = preg_match('/@section\s*\(\s*[\'"][^\'"]+[\'"]\s*\)/', $layoutContent);
            
            $this->assertTrue(
                $hasYield || $hasSection,
                "Layout file {$layoutName} should contain at least one @yield or @section directive for dynamic content"
            );
            
            // Se encontrou @yield, validar que está bem formado
            if ($hasYield) {
                preg_match_all('/@yield\s*\(\s*[\'"]([^\'"]+)[\'"]\s*(?:,\s*[^\)]+)?\)/', $layoutContent, $yieldMatches);
                
                $this->assertNotEmpty(
                    $yieldMatches[1],
                    "Layout file {$layoutName} should have valid @yield directives with section names"
                );
                
                // Verificar que os nomes das seções não estão vazios
                foreach ($yieldMatches[1] as $sectionName) {
                    $this->assertNotEmpty(
                        trim($sectionName),
                        "Layout file {$layoutName} should have non-empty section names in @yield directives"
                    );
                }
            }
            
            // Se encontrou @section, validar que está bem formado
            if ($hasSection) {
                preg_match_all('/@section\s*\(\s*[\'"]([^\'"]+)[\'"]\s*\)/', $layoutContent, $sectionMatches);
                
                $this->assertNotEmpty(
                    $sectionMatches[1],
                    "Layout file {$layoutName} should have valid @section directives with section names"
                );
                
                // Verificar que os nomes das seções não estão vazios
                foreach ($sectionMatches[1] as $sectionName) {
                    $this->assertNotEmpty(
                        trim($sectionName),
                        "Layout file {$layoutName} should have non-empty section names in @section directives"
                    );
                }
            }
            
            // Verificar que o layout também pode usar @stack para conteúdo adicional
            // (não é obrigatório, mas é uma boa prática)
            $hasStack = preg_match('/@stack\s*\(\s*[\'"][^\'"]+[\'"]\s*\)/', $layoutContent);
            
            // Se tem @stack, validar que está bem formado
            if ($hasStack) {
                preg_match_all('/@stack\s*\(\s*[\'"]([^\'"]+)[\'"]\s*\)/', $layoutContent, $stackMatches);
                
                foreach ($stackMatches[1] as $stackName) {
                    $this->assertNotEmpty(
                        trim($stackName),
                        "Layout file {$layoutName} should have non-empty stack names in @stack directives"
                    );
                }
            }
        });
    }
    
    /**
     * Feature: laravel-bootstrap-templates, Property 5: Layouts Blade Usam Seções Dinâmicas
     *
     * **Validates: Requirement 6.3**
     *
     * Verifica que layouts comuns têm seções específicas esperadas para conteúdo dinâmico.
     *
     * @test
     */
    public function main_layout_has_essential_dynamic_sections()
    {
        $mainLayoutPath = resource_path('views/layouts/app.blade.php');
        
        $this->assertFileExists(
            $mainLayoutPath,
            "Main layout file should exist at resources/views/layouts/app.blade.php"
        );
        
        $layoutContent = file_get_contents($mainLayoutPath);
        
        // Verificar seções essenciais que um layout principal deve ter
        $essentialSections = ['content', 'title'];
        
        $this->forAll(
            Generator\elements($essentialSections)
        )
        ->then(function ($sectionName) use ($layoutContent) {
            // Verificar que a seção existe como @yield
            $pattern = '/@yield\s*\(\s*[\'"]' . preg_quote($sectionName, '/') . '[\'"]/';
            
            $this->assertMatchesRegularExpression(
                $pattern,
                $layoutContent,
                "Main layout should have @yield('{$sectionName}') for dynamic {$sectionName}"
            );
        });
    }
    
    /**
     * Feature: laravel-bootstrap-templates, Property 6: Views Herdam Componentes do Layout
     *
     * **Validates: Requirements 3.4, 6.5**
     *
     * Para qualquer view Blade que estende um layout (usando @extends), quando renderizada,
     * o HTML resultante deve incluir todos os componentes visuais do layout (sidebar, navbar, footer)
     * além do conteúdo específico da view.
     *
     * @test
     */
    public function any_view_extending_layout_inherits_all_components()
    {
        // Obter todas as rotas GET que renderizam views
        $routesWithViews = [];
        
        foreach (Route::getRoutes() as $route) {
            if (in_array('GET', $route->methods()) &&
                !str_contains($route->uri(), '{') &&
                $route->getName() !== null &&
                !str_starts_with($route->uri(), 'api/') &&
                !str_starts_with($route->uri(), 'sanctum/')) {
                $routesWithViews[] = [
                    'name' => $route->getName(),
                    'uri' => $route->uri()
                ];
            }
        }
        
        $this->assertNotEmpty(
            $routesWithViews,
            "At least one GET route should exist to test view inheritance"
        );
        
        // Testar cada rota
        $this->forAll(
            Generator\elements($routesWithViews)
        )
        ->then(function ($routeData) {
            $routeName = $routeData['name'];
            $uri = $routeData['uri'];
            
            // Fazer requisição para a rota
            $response = $this->get($uri);
            
            // Verificar que a resposta é bem-sucedida
            $this->assertEquals(
                200,
                $response->status(),
                "Route {$routeName} should return 200 status"
            );
            
            $renderedHtml = $response->getContent();
            
            // Verificar que o HTML renderizado não está vazio
            $this->assertNotEmpty(
                $renderedHtml,
                "Rendered HTML for route {$routeName} should not be empty"
            );
            
            // Verificar presença de componentes do layout
            
            // 1. Verificar presença do sidebar
            $hasSidebar = preg_match('/id\s*=\s*[\'"]layout-menu[\'"]/', $renderedHtml);
            
            $this->assertGreaterThan(
                0,
                $hasSidebar,
                "Route {$routeName} should include sidebar component from layout (id='layout-menu')"
            );
            
            // 2. Verificar presença do navbar
            $hasNavbar = preg_match('/id\s*=\s*[\'"]layout-navbar[\'"]/', $renderedHtml) ||
                        preg_match('/class\s*=\s*[\'"][^\'"]*(layout-navbar)[^\'"]*[\'"]/', $renderedHtml);
            
            $this->assertGreaterThan(
                0,
                $hasNavbar,
                "Route {$routeName} should include navbar component from layout"
            );
            
            // 3. Verificar presença do footer
            $hasFooter = preg_match('/class\s*=\s*[\'"][^\'"]*(content-footer|footer bg-footer-theme)[^\'"]*[\'"]/', $renderedHtml);
            
            $this->assertGreaterThan(
                0,
                $hasFooter,
                "Route {$routeName} should include footer component from layout"
            );
            
            // 4. Verificar estrutura básica do layout
            $hasLayoutWrapper = preg_match('/class\s*=\s*[\'"][^\'"]*(layout-wrapper)[^\'"]*[\'"]/', $renderedHtml);
            
            $this->assertGreaterThan(
                0,
                $hasLayoutWrapper,
                "Route {$routeName} should include layout wrapper structure"
            );
            
            // 5. Verificar que o conteúdo específico da view também está presente
            $hasContentWrapper = preg_match('/class\s*=\s*[\'"][^\'"]*(content-wrapper)[^\'"]*[\'"]/', $renderedHtml);
            
            $this->assertGreaterThan(
                0,
                $hasContentWrapper,
                "Route {$routeName} should include content wrapper for view-specific content"
            );
        });
    }
    
    /**
     * Feature: laravel-bootstrap-templates, Property 6: Views Herdam Componentes do Layout
     *
     * **Validates: Requirements 3.4, 6.5**
     *
     * Verifica que rotas específicas renderizam páginas com todos os componentes do layout.
     *
     * @test
     */
    public function specific_routes_render_with_all_layout_components()
    {
        // Obter todas as rotas GET definidas
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            return in_array('GET', $route->methods()) &&
                   !str_contains($route->uri(), '{') && // Pular rotas com parâmetros
                   $route->getName() !== null; // Apenas rotas nomeadas
        })->map(function ($route) {
            return [
                'name' => $route->getName(),
                'uri' => $route->uri()
            ];
        })->values()->toArray();
        
        if (empty($routes)) {
            $this->markTestSkipped("No named GET routes found to test");
            return;
        }
        
        $this->forAll(
            Generator\elements($routes)
        )
        ->then(function ($routeData) {
            $routeName = $routeData['name'];
            
            // Fazer requisição para a rota
            $response = $this->get(route($routeName));
            
            // Verificar que a resposta é bem-sucedida
            $this->assertEquals(
                200,
                $response->status(),
                "Route {$routeName} should return 200 status"
            );
            
            $renderedHtml = $response->getContent();
            
            // Verificar que o HTML não está vazio
            $this->assertNotEmpty(
                $renderedHtml,
                "Rendered HTML for route {$routeName} should not be empty"
            );
            
            // Verificar componentes essenciais do layout
            
            // Sidebar
            $this->assertMatchesRegularExpression(
                '/id\s*=\s*[\'"]layout-menu[\'"]/',
                $renderedHtml,
                "Route {$routeName} should render sidebar component (layout-menu)"
            );
            
            // Layout structure
            $this->assertMatchesRegularExpression(
                '/class\s*=\s*[\'"][^\'"]*(layout-wrapper|layout-container)[^\'"]*[\'"]/',
                $renderedHtml,
                "Route {$routeName} should render layout wrapper structure"
            );
            
            // Content area
            $this->assertMatchesRegularExpression(
                '/class\s*=\s*[\'"][^\'"]*(content-wrapper|container-xxl)[^\'"]*[\'"]/',
                $renderedHtml,
                "Route {$routeName} should render content wrapper"
            );
        });
    }
}
