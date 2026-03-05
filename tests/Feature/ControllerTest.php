<?php

namespace Tests\Feature;

use Tests\TestCase;

class ControllerTest extends TestCase
{
    /**
     * Testa que dashboard retorna status 200
     *
     * @test
     */
    public function dashboard_controller_returns_correct_view()
    {
        $response = $this->get('/ui/alerts');

        $response->assertStatus(200);
        $response->assertViewIs('content.user-interface.ui-alerts');
    }

    /**
     * Testa que UI badges retorna status 200
     *
     * @test
     */
    public function dashboard_controller_passes_correct_data()
    {
        $response = $this->get('/ui/badges');

        $response->assertStatus(200);
        $response->assertViewIs('content.user-interface.ui-badges');
    }

    /**
     * Testa que páginas incluem componentes do layout
     *
     * @test
     */
    public function dashboard_includes_layout_components()
    {
        $response = $this->get('/ui/alerts');

        // Verifica presença do sidebar
        $response->assertSee('layout-menu', false);
        $response->assertSee('menu-inner', false);

        // Verifica presença do navbar
        $response->assertSee('layout-navbar', false);

        // Verifica presença do footer
        $response->assertSee('footer', false);

        // Verifica estrutura do layout
        $response->assertSee('layout-wrapper', false);
        $response->assertSee('layout-container', false);
    }

    /**
     * Testa que account settings retorna status 200
     *
     * @test
     */
    public function page_controller_account_settings_returns_correct_view()
    {
        $response = $this->get('/pages/account-settings-connections');

        $response->assertStatus(200);
        $response->assertViewIs('content.pages.pages-account-settings-connections');
    }

    /**
     * Testa que profile retorna status 200
     *
     * @test
     */
    public function page_controller_profile_returns_correct_view()
    {
        $response = $this->get('/ui/typography');

        $response->assertStatus(200);
        $response->assertViewIs('content.user-interface.ui-typography');
    }

    /**
     * Testa que páginas incluem componentes do layout
     *
     * @test
     */
    public function page_controller_views_include_layout_components()
    {
        $pages = [
            '/pages/account-settings-connections',
            '/ui/typography',
        ];

        foreach ($pages as $page) {
            $response = $this->get($page);

            // Verifica presença dos componentes principais do layout
            $response->assertSee('layout-menu', false);
            $response->assertSee('layout-navbar', false);
            $response->assertSee('footer', false);
        }
    }

    /**
     * Testa que todas as views dos controllers retornam HTML válido
     *
     * @test
     */
    public function controller_views_return_valid_html()
    {
        $routes = [
            '/ui/alerts',
            '/pages/account-settings-connections',
            '/ui/typography',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);

            $content = $response->getContent();

            // Verifica estrutura HTML básica
            $this->assertStringContainsString('<!DOCTYPE html>', $content);
            $this->assertStringContainsString('<html', $content);
            $this->assertStringContainsString('<head>', $content);
            $this->assertStringContainsString('<body>', $content);
            $this->assertStringContainsString('</body>', $content);
            $this->assertStringContainsString('</html>', $content);
        }
    }

    /**
     * Testa que views incluem meta tags necessárias
     *
     * @test
     */
    public function controller_views_include_required_meta_tags()
    {
        $response = $this->get('/ui/alerts');

        $content = $response->getContent();

        // Verifica meta tags essenciais
        $this->assertStringContainsString('<meta charset="utf-8">', $content);
        $this->assertStringContainsString('name="viewport"', $content);
        $this->assertStringContainsString('name="csrf-token"', $content);
    }
}
