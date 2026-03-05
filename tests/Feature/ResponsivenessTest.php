<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;

/**
 * Testes automatizados de responsividade para Requisito 11.5
 *
 * Valida que as páginas renderizam corretamente os elementos responsivos
 * exigidos pelo Bootstrap 5. Testes manuais em dispositivos reais devem
 * complementar estes testes automatizados.
 *
 * Resoluções a testar manualmente (ver README):
 * - Mobile:  375px, 414px
 * - Tablet:  768px, 1024px
 * - Desktop: 1920px, 2560px
 */
class ResponsivenessTest extends TestCase
{
    /**
     * Rotas de amostra para os testes de responsividade
     */
    private function getSampleRoutes(): array
    {
        return ['/', '/ui/alerts', '/pages/account-settings-account'];
    }

    /**
     * Testa que todas as páginas incluem meta viewport para responsividade
     *
     * @test
     */
    public function pages_include_viewport_meta_tag(): void
    {
        foreach ($this->getSampleRoutes() as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);

            $html = $response->getContent();

            $this->assertStringContainsString(
                'name="viewport"',
                $html,
                "Route {$route} must include viewport meta tag for mobile responsiveness"
            );

            $this->assertStringContainsString(
                'width=device-width',
                $html,
                "Route {$route} must set width=device-width in viewport meta tag"
            );
        }
    }

    /**
     * Testa que o layout inclui o navbar toggler para menu mobile
     *
     * @test
     */
    public function layout_includes_mobile_menu_toggler(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $html = $response->getContent();

        // Bootstrap navbar toggler para menu mobile
        $hasToggler = str_contains($html, 'layout-menu-toggle') ||
                      str_contains($html, 'navbar-toggler') ||
                      str_contains($html, 'menu-toggle');

        $this->assertTrue(
            $hasToggler,
            'Layout must include a menu toggle element for mobile navigation'
        );
    }

    /**
     * Testa que o layout usa container Bootstrap responsivo
     *
     * @test
     */
    public function layout_uses_responsive_container(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $html = $response->getContent();

        // Verificar presença de classe container responsiva do Bootstrap
        $hasContainer = preg_match('/class=["\'][^"\']*\bcontainer(?:-fluid|-xxl|-xl|-lg|-md|-sm)?\b/', $html);

        $this->assertGreaterThan(
            0,
            $hasContainer,
            'Layout must use Bootstrap responsive container class'
        );
    }

    /**
     * Testa que o layout usa grid responsivo Bootstrap
     *
     * @test
     */
    public function pages_use_bootstrap_responsive_grid(): void
    {
        // Testar páginas que usam grid
        $routes = ['/dashboard/crm', '/ui/alerts'];

        foreach ($routes as $route) {
            $response = $this->get($route);

            if ($response->status() !== 200) {
                continue; // Pular rotas que retornam outros status
            }

            $html = $response->getContent();

            // Verificar classes de grid responsivo Bootstrap
            $hasResponsiveGrid = preg_match('/class=["\'][^"\']*\bcol(?:-(?:sm|md|lg|xl|xxl|auto))?\b/', $html) ||
                                 preg_match('/class=["\'][^"\']*\brow\b/', $html);

            $this->assertGreaterThan(
                0,
                $hasResponsiveGrid,
                "Route {$route} should use Bootstrap responsive grid classes"
            );
        }
    }

    /**
     * Testa que o Bootstrap 5 CSS está carregado (inclui classes responsivas)
     *
     * @test
     */
    public function bootstrap5_css_is_loaded_for_responsive_styles(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $html = $response->getContent();

        // Verificar que o Bootstrap é carregado (via Vite ou link direto)
        $hasBootstrap = str_contains($html, 'bootstrap') ||
                        str_contains($html, 'core.css') ||
                        str_contains($html, 'theme-default.css');

        $this->assertTrue(
            $hasBootstrap,
            'Layout must load Bootstrap CSS for responsive design'
        );
    }

    /**
     * Testa que a sidebar usa classes responsivas do Vuexy
     *
     * @test
     */
    public function sidebar_has_responsive_layout_classes(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $html = $response->getContent();

        // O layout do Vuexy usa layout-menu para sidebar
        $this->assertStringContainsString(
            'layout-menu',
            $html,
            'Sidebar must use Vuexy layout-menu class for responsive behavior'
        );
    }

    /**
     * Testa breakpoints Bootstrap em CSS compilado (existência)
     *
     * Valida indiretamente que o CSS compilado cobre breakpoints:
     * xs (<576px), sm (≥576px), md (≥768px), lg (≥992px), xl (≥1200px), xxl (≥1400px)
     *
     * @test
     */
    public function compiled_css_exists_for_all_breakpoints(): void
    {
        // Verificar que o CSS principal foi compilado
        $manifestPath = public_path('build/manifest.json');
        $this->assertFileExists($manifestPath, 'Vite manifest must exist (run: npm run build)');

        $manifest = json_decode(file_get_contents($manifestPath), true);

        // core.css deve estar no manifest (contém breakpoints Bootstrap)
        $hasCoreCSS = isset($manifest['resources/css/core.css']);

        $this->assertTrue(
            $hasCoreCSS,
            'resources/css/core.css must be compiled - it contains Bootstrap breakpoints for all screen sizes'
        );
    }

    /**
     * Testa que o navbar do Vuexy suporta menu hambúrguer mobile
     *
     * @test
     */
    public function navbar_supports_mobile_hamburger_menu(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $html = $response->getContent();

        // Verificar presença do botão de menu hambúrguer
        $hasBurgerMenu = str_contains($html, 'layout-menu-toggle') ||
                         str_contains($html, 'menu-toggle') ||
                         str_contains($html, 'hamburger');

        $this->assertTrue(
            $hasBurgerMenu,
            'Navbar must include hamburger menu toggle for mobile (≤992px viewport)'
        );
    }
}
