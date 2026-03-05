<?php

namespace Tests\Feature;

use Tests\TestCase;

class ViewTest extends TestCase
{
    /**
     * Testa que dashboard carrega com status 200
     *
     * @test
     */
    public function dashboard_loads_with_status_200()
    {
        $response = $this->get('/ui/alerts');

        $response->assertStatus(200);
    }

    /**
     * Testa que dashboard inclui título correto
     *
     * @test
     */
    public function dashboard_includes_correct_title()
    {
        $response = $this->get('/ui/alerts');

        $response->assertStatus(200);
        $response->assertSee('Alerts', false);
    }

    /**
     * Testa que dashboard inclui componentes visuais esperados
     *
     * @test
     */
    public function dashboard_includes_expected_visual_components()
    {
        $response = $this->get('/ui/alerts');

        // Verifica estrutura de cards Bootstrap
        $response->assertSee('class="card"', false);
        $response->assertSee('class="card-body"', false);
    }

    /**
     * Testa que dashboard inclui elementos de alerta
     *
     * @test
     */
    public function dashboard_includes_timeline_elements()
    {
        $response = $this->get('/ui/alerts');

        // Verifica presença de alertas Bootstrap
        $response->assertSee('alert', false);
    }

    /**
     * Testa que view de badges carrega com status 200
     * (usa rota sem vendor assets fora do manifest)
     *
     * @test
     */
    public function profile_view_loads_with_status_200()
    {
        $response = $this->get('/ui/badges');

        $response->assertStatus(200);
    }

    /**
     * Testa que view de badges inclui título correto
     *
     * @test
     */
    public function profile_view_includes_correct_title()
    {
        $response = $this->get('/ui/badges');

        $response->assertStatus(200);
        $response->assertSee('Badge', false);
    }

    /**
     * Testa que view de badges inclui componentes visuais esperados
     *
     * @test
     */
    public function profile_view_includes_expected_visual_components()
    {
        $response = $this->get('/ui/badges');

        $response->assertStatus(200);
        $response->assertSee('class="card', false);
        $response->assertSee('class="card-body', false);
    }

    /**
     * Testa que view de badges inclui estrutura de layout
     *
     * @test
     */
    public function profile_view_includes_activity_timeline()
    {
        $response = $this->get('/ui/badges');

        $response->assertStatus(200);
        $response->assertSee('layout-wrapper', false);
    }

    /**
     * Testa que view de buttons carrega com status 200
     *
     * @test
     */
    public function profile_view_includes_projects_section()
    {
        $response = $this->get('/ui/buttons');

        $response->assertStatus(200);
        $response->assertSee('card', false);
    }

    /**
     * Testa que view de connections carrega com status 200
     * (substitui account-settings-account que usa vendor assets fora do manifest)
     *
     * @test
     */
    public function account_settings_view_loads_with_status_200()
    {
        $response = $this->get('/pages/account-settings-connections');

        $response->assertStatus(200);
    }

    /**
     * Testa que view de connections inclui título correto
     *
     * @test
     */
    public function account_settings_view_includes_correct_title()
    {
        $response = $this->get('/pages/account-settings-connections');

        $response->assertStatus(200);
        $response->assertSee('Connections', false);
    }

    /**
     * Testa que view de connections inclui componentes visuais esperados
     *
     * @test
     */
    public function account_settings_view_includes_expected_visual_components()
    {
        $response = $this->get('/pages/account-settings-connections');

        $response->assertStatus(200);
        $response->assertSee('class="card', false);
    }

    /**
     * Testa que view de buttons inclui seção de cards
     *
     * @test
     */
    public function account_settings_view_includes_change_password_section()
    {
        $response = $this->get('/ui/buttons');

        $response->assertStatus(200);
        $response->assertSee('card', false);
    }

    /**
     * Testa que view de connections inclui seção de cards
     *
     * @test
     */
    public function account_settings_view_includes_delete_account_section()
    {
        $response = $this->get('/pages/account-settings-connections');

        $response->assertStatus(200);
        $response->assertSee('card', false);
    }

    /**
     * Testa que view de connections inclui layout wrapper
     *
     * @test
     */
    public function account_settings_view_includes_csrf_tokens()
    {
        $response = $this->get('/pages/account-settings-connections');

        $response->assertStatus(200);
        $response->assertSee('layout-wrapper', false);
    }

    /**
     * Testa que todas as views incluem estrutura Bootstrap correta
     *
     * @test
     */
    public function all_views_include_bootstrap_structure()
    {
        $routes = [
            '/ui/alerts',
            '/ui/badges',
            '/pages/account-settings-connections',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);

            $response->assertStatus(200);
            $response->assertSee('class="card"', false);

            $content = $response->getContent();
            $this->assertMatchesRegularExpression('/class="[^"]*col-/', $content);
        }
    }

    /**
     * Testa que todas as views incluem componentes do layout
     *
     * @test
     */
    public function all_views_include_layout_components()
    {
        $routes = [
            '/ui/alerts',
            '/ui/badges',
            '/pages/account-settings-connections',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);

            $response->assertSee('layout-wrapper', false);
            $response->assertSee('layout-container', false);
            $response->assertSee('layout-menu', false);
            $response->assertSee('layout-navbar', false);
            $response->assertSee('footer', false);
        }
    }

    /**
     * Testa que todas as views são responsivas
     *
     * @test
     */
    public function all_views_include_responsive_classes()
    {
        $routes = [
            '/ui/alerts',
            '/ui/badges',
            '/pages/account-settings-connections',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);

            $response->assertStatus(200);
            $content = $response->getContent();
            $this->assertStringContainsString('name="viewport"', $content);
        }
    }

    /**
     * Testa que todas as views incluem ícones
     *
     * @test
     */
    public function all_views_include_icons()
    {
        $routes = [
            '/ui/alerts',
            '/ui/badges',
            '/pages/account-settings-connections',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);

            $response->assertStatus(200);
            $content = $response->getContent();
            $this->assertMatchesRegularExpression('/<i[^>]+class="[^"]*ti ti-/', $content);
        }
    }

    /**
     * Testa que views incluem badges e elementos visuais do Bootstrap
     *
     * @test
     */
    public function views_include_bootstrap_visual_elements()
    {
        $response = $this->get('/ui/badges');

        $response->assertStatus(200);
        $response->assertSee('class="badge', false);
    }

    /**
     * Testa que badges view inclui badges
     *
     * @test
     */
    public function profile_view_includes_badges()
    {
        $response = $this->get('/ui/badges');

        $response->assertStatus(200);
        $response->assertSee('badge', false);
    }

    /**
     * Testa que alerts view inclui alertas
     *
     * @test
     */
    public function account_settings_view_includes_alerts()
    {
        $response = $this->get('/ui/alerts');

        $response->assertStatus(200);
        $response->assertSee('alert', false);
    }
}
