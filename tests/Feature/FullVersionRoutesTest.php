<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Testes para as rotas da full-version do template Vuexy.
 *
 * Valida: Requisitos 4.5, 7.5
 * - Rotas retornam HTTP 200
 * - Páginas incluem componentes de layout (sidebar, navbar)
 * - Estrutura HTML válida (DOCTYPE, html, head, body)
 *
 * Nota: Apenas rotas cujas views não referenciam assets Vite ausentes
 * no manifest são testadas aqui. As demais requerem `npm run build` completo.
 */
class FullVersionRoutesTest extends TestCase
{
    // -------------------------------------------------------------------------
    // 1. Rotas retornam HTTP 200 — amostra representativa por grupo
    // -------------------------------------------------------------------------

    /**
     * @test
     * @dataProvider uiRoutesProvider
     */
    public function ui_routes_return_200(string $uri): void
    {
        $this->get($uri)->assertStatus(200);
    }

    public static function uiRoutesProvider(): array
    {
        return [
            'ui accordion'              => ['/ui/accordion'],
            'ui alerts'                 => ['/ui/alerts'],
            'ui badges'                 => ['/ui/badges'],
            'ui buttons'                => ['/ui/buttons'],
            'ui collapse'               => ['/ui/collapse'],
            'ui footer'                 => ['/ui/footer'],
            'ui list groups'            => ['/ui/list-groups'],
            'ui offcanvas'              => ['/ui/offcanvas'],
            'ui pagination breadcrumbs' => ['/ui/pagination-breadcrumbs'],
            'ui progress'               => ['/ui/progress'],
            'ui tabs pills'             => ['/ui/tabs-pills'],
            'ui typography'             => ['/ui/typography'],
        ];
    }

    /**
     * @test
     * @dataProvider extendedUiRoutesProvider
     */
    public function extended_ui_routes_return_200(string $uri): void
    {
        $this->get($uri)->assertStatus(200);
    }

    public static function extendedUiRoutesProvider(): array
    {
        return [
            'extended avatar'         => ['/extended/ui-avatar'],
            'extended text divider'   => ['/extended/ui-text-divider'],
            'extended timeline basic' => ['/extended/ui-timeline-basic'],
        ];
    }

    /**
     * @test
     * @dataProvider formRoutesProvider
     */
    public function form_routes_return_200(string $uri): void
    {
        $this->get($uri)->assertStatus(200);
    }

    public static function formRoutesProvider(): array
    {
        return [
            'form custom options' => ['/forms/custom-options'],
            'form switches'       => ['/forms/switches'],
        ];
    }

    /**
     * @test
     * @dataProvider pagesRoutesProvider
     */
    public function pages_routes_return_200(string $uri): void
    {
        $this->get($uri)->assertStatus(200);
    }

    public static function pagesRoutesProvider(): array
    {
        return [
            'account settings connections' => ['/pages/account-settings-connections'],
        ];
    }

    /**
     * @test
     * @dataProvider frontPageRoutesProvider
     */
    public function front_page_routes_return_200(string $uri): void
    {
        $this->get($uri)->assertStatus(200);
    }

    public static function frontPageRoutesProvider(): array
    {
        return [
            'help center article' => ['/front-pages/help-center-article'],
        ];
    }

    // -------------------------------------------------------------------------
    // 2. Páginas incluem componentes de layout (sidebar e navbar)
    // -------------------------------------------------------------------------

    /**
     * @test
     */
    public function full_version_pages_include_sidebar_component(): void
    {
        $routes = [
            '/ui/alerts',
            '/ui/buttons',
            '/ui/typography',
            '/extended/ui-avatar',
            '/forms/custom-options',
            '/pages/account-settings-connections',
        ];

        foreach ($routes as $uri) {
            $response = $this->get($uri);
            $response->assertStatus(200);
            $response->assertSee('layout-menu', false);
            $response->assertSee('menu-inner', false);
        }
    }

    /**
     * @test
     */
    public function full_version_pages_include_navbar_component(): void
    {
        $routes = [
            '/ui/alerts',
            '/ui/badges',
            '/extended/ui-text-divider',
            '/forms/switches',
            '/pages/account-settings-connections',
        ];

        foreach ($routes as $uri) {
            $response = $this->get($uri);
            $response->assertStatus(200);
            $response->assertSee('layout-navbar', false);
        }
    }

    /**
     * @test
     */
    public function full_version_pages_include_footer_component(): void
    {
        $routes = [
            '/ui/typography',
            '/extended/ui-timeline-basic',
            '/forms/custom-options',
            '/pages/account-settings-connections',
        ];

        foreach ($routes as $uri) {
            $response = $this->get($uri);
            $response->assertStatus(200);
            $response->assertSee('footer', false);
        }
    }

    // -------------------------------------------------------------------------
    // 3. Estrutura HTML válida para páginas principais
    // -------------------------------------------------------------------------

    /**
     * @test
     * @dataProvider mainPagesHtmlProvider
     */
    public function main_pages_have_valid_html_structure(string $uri): void
    {
        $content = $this->get($uri)->assertStatus(200)->getContent();

        $this->assertStringContainsString('<!DOCTYPE html>', $content);
        $this->assertStringContainsString('<html', $content);
        $this->assertStringContainsString('<head>', $content);
        $this->assertStringContainsString('<body', $content);
        $this->assertStringContainsString('</body>', $content);
        $this->assertStringContainsString('</html>', $content);
    }

    public static function mainPagesHtmlProvider(): array
    {
        return [
            'ui alerts'                    => ['/ui/alerts'],
            'ui buttons'                   => ['/ui/buttons'],
            'ui typography'                => ['/ui/typography'],
            'ui badges'                    => ['/ui/badges'],
            'ui accordion'                 => ['/ui/accordion'],
            'ui progress'                  => ['/ui/progress'],
            'ui tabs pills'                => ['/ui/tabs-pills'],
            'extended avatar'              => ['/extended/ui-avatar'],
            'extended timeline basic'      => ['/extended/ui-timeline-basic'],
            'extended text divider'        => ['/extended/ui-text-divider'],
            'account settings connections' => ['/pages/account-settings-connections'],
            'form custom options'          => ['/forms/custom-options'],
            'form switches'                => ['/forms/switches'],
            'help center article'          => ['/front-pages/help-center-article'],
        ];
    }

    /**
     * @test
     */
    public function main_pages_include_required_meta_tags(): void
    {
        $routes = [
            '/ui/alerts',
            '/extended/ui-avatar',
            '/pages/account-settings-connections',
        ];

        foreach ($routes as $uri) {
            $content = $this->get($uri)->assertStatus(200)->getContent();

            $this->assertStringContainsString('<meta charset="utf-8">', $content, "Missing charset meta on {$uri}");
            $this->assertStringContainsString('name="viewport"', $content, "Missing viewport meta on {$uri}");
        }
    }

    /**
     * @test
     */
    public function main_pages_include_layout_wrapper_structure(): void
    {
        $routes = [
            '/ui/alerts',
            '/ui/typography',
            '/extended/ui-avatar',
            '/forms/custom-options',
        ];

        foreach ($routes as $uri) {
            $response = $this->get($uri)->assertStatus(200);
            $response->assertSee('layout-wrapper', false);
            $response->assertSee('layout-container', false);
        }
    }
}
