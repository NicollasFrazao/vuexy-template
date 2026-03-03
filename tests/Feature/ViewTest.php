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
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Testa que dashboard inclui título correto
     *
     * @test
     */
    public function dashboard_includes_correct_title()
    {
        $response = $this->get('/');

        // Verifica título na tag <title>
        $response->assertSee('<title>Dashboard</title>', false);

        // Verifica que o título é passado para a view
        $response->assertViewHas('pageTitle', 'Dashboard');
    }

    /**
     * Testa que dashboard inclui componentes visuais esperados
     *
     * @test
     */
    public function dashboard_includes_expected_visual_components()
    {
        $response = $this->get('/');

        // Verifica cards de estatísticas
        $response->assertSee('Total Users', false);
        $response->assertSee('Total Revenue', false);
        $response->assertSee('Total Orders', false);

        // Verifica seção de atividade recente
        $response->assertSee('Recent Activity', false);

        // Verifica seção de estatísticas rápidas
        $response->assertSee('Quick Stats', false);
        $response->assertSee('Active Sessions', false);
        $response->assertSee('Pending Orders', false);
        $response->assertSee('Support Tickets', false);

        // Verifica estrutura de cards Bootstrap
        $response->assertSee('class="card"', false);
        $response->assertSee('class="card-body"', false);
        $response->assertSee('class="card-header"', false);
    }

    /**
     * Testa que dashboard inclui elementos de timeline
     *
     * @test
     */
    public function dashboard_includes_timeline_elements()
    {
        $response = $this->get('/');

        // Verifica estrutura de timeline
        $response->assertSee('class="timeline', false);
        $response->assertSee('timeline-item', false);
        $response->assertSee('timeline-point', false);
        $response->assertSee('timeline-event', false);
    }

    /**
     * Testa que view de profile carrega com status 200
     *
     * @test
     */
    public function profile_view_loads_with_status_200()
    {
        $response = $this->get('/pages/profile');

        $response->assertStatus(200);
    }

    /**
     * Testa que view de profile inclui título correto
     *
     * @test
     */
    public function profile_view_includes_correct_title()
    {
        $response = $this->get('/pages/profile');

        // Verifica título na tag <title>
        $response->assertSee('<title>User Profile</title>', false);
    }

    /**
     * Testa que view de profile inclui componentes visuais esperados
     *
     * @test
     */
    public function profile_view_includes_expected_visual_components()
    {
        $response = $this->get('/pages/profile');

        // Verifica header do perfil
        $response->assertSee('user-profile-header', false);
        $response->assertSee('user-profile-img', false);

        // Verifica informações do usuário
        $response->assertSee('John Doe', false);
        $response->assertSee('UX Designer', false);

        // Verifica seção About
        $response->assertSee('About', false);
        $response->assertSee('Full Name:', false);
        $response->assertSee('Status:', false);
        $response->assertSee('Role:', false);

        // Verifica seção Contacts
        $response->assertSee('Contacts', false);
        $response->assertSee('Contact:', false);
        $response->assertSee('Email:', false);

        // Verifica seção Teams
        $response->assertSee('Teams', false);

        // Verifica seção Social Links
        $response->assertSee('Social Links', false);
        $response->assertSee('Twitter:', false);
        $response->assertSee('Facebook:', false);
        $response->assertSee('LinkedIn:', false);
        $response->assertSee('GitHub:', false);
    }

    /**
     * Testa que view de profile inclui timeline de atividades
     *
     * @test
     */
    public function profile_view_includes_activity_timeline()
    {
        $response = $this->get('/pages/profile');

        // Verifica seção de timeline
        $response->assertSee('Activity Timeline', false);
        $response->assertSee('class="timeline', false);
        $response->assertSee('timeline-item', false);
    }

    /**
     * Testa que view de profile inclui seção de projetos
     *
     * @test
     */
    public function profile_view_includes_projects_section()
    {
        $response = $this->get('/pages/profile');

        // Verifica seção de projetos
        $response->assertSee('Projects', false);
        $response->assertSee('React Project', false);
        $response->assertSee('Vue Project', false);
        $response->assertSee('Angular Project', false);
        $response->assertSee('Laravel Project', false);
    }

    /**
     * Testa que view de account settings carrega com status 200
     *
     * @test
     */
    public function account_settings_view_loads_with_status_200()
    {
        $response = $this->get('/pages/account-settings');

        $response->assertStatus(200);
    }

    /**
     * Testa que view de account settings inclui título correto
     *
     * @test
     */
    public function account_settings_view_includes_correct_title()
    {
        $response = $this->get('/pages/account-settings');

        // Verifica título na tag <title>
        $response->assertSee('<title>Account Settings</title>', false);
    }

    /**
     * Testa que view de account settings inclui componentes visuais esperados
     *
     * @test
     */
    public function account_settings_view_includes_expected_visual_components()
    {
        $response = $this->get('/pages/account-settings');

        // Verifica seção de detalhes da conta
        $response->assertSee('Account Details', false);
        $response->assertSee('Upload new photo', false);

        // Verifica campos do formulário
        $response->assertSee('First Name', false);
        $response->assertSee('Last Name', false);
        $response->assertSee('E-mail', false);
        $response->assertSee('Organization', false);
        $response->assertSee('Phone Number', false);
        $response->assertSee('Address', false);
        $response->assertSee('State', false);
        $response->assertSee('Zip Code', false);
        $response->assertSee('Country', false);
        $response->assertSee('Language', false);
        $response->assertSee('Timezone', false);
        $response->assertSee('Currency', false);

        // Verifica botões de ação
        $response->assertSee('Save changes', false);
        $response->assertSee('Cancel', false);
    }

    /**
     * Testa que view de account settings inclui seção de mudança de senha
     *
     * @test
     */
    public function account_settings_view_includes_change_password_section()
    {
        $response = $this->get('/pages/account-settings');

        // Verifica seção de mudança de senha
        $response->assertSee('Change Password', false);
        $response->assertSee('Current Password', false);
        $response->assertSee('New Password', false);
        $response->assertSee('Confirm New Password', false);
        $response->assertSee('Password Requirements:', false);
    }

    /**
     * Testa que view de account settings inclui seção de exclusão de conta
     *
     * @test
     */
    public function account_settings_view_includes_delete_account_section()
    {
        $response = $this->get('/pages/account-settings');

        // Verifica seção de exclusão de conta
        $response->assertSee('Delete Account', false);
        $response->assertSee('Are you sure you want to delete your account?', false);
        $response->assertSee('I confirm my account deactivation', false);
        $response->assertSee('Deactivate Account', false);
    }

    /**
     * Testa que view de account settings inclui formulários com CSRF
     *
     * @test
     */
    public function account_settings_view_includes_csrf_tokens()
    {
        $response = $this->get('/pages/account-settings');

        // Verifica presença de tokens CSRF nos formulários
        $response->assertSee('name="_token"', false);
    }

    /**
     * Testa que todas as views incluem estrutura Bootstrap correta
     *
     * @test
     */
    public function all_views_include_bootstrap_structure()
    {
        $routes = [
            '/',
            '/pages/profile',
            '/pages/account-settings',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);

            // Verifica classes Bootstrap comuns
            $response->assertSee('class="row"', false);
            $response->assertSee('class="col-', false);
            $response->assertSee('class="card"', false);

            // Verifica que usa sistema de grid Bootstrap
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
            '/',
            '/pages/profile',
            '/pages/account-settings',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);

            // Verifica componentes do layout
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
            '/',
            '/pages/profile',
            '/pages/account-settings',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);

            $content = $response->getContent();

            // Verifica classes responsivas do Bootstrap
            // col-lg, col-md, col-sm indicam responsividade
            $this->assertMatchesRegularExpression('/class="[^"]*col-(lg|md|sm|xs)-/', $content);

            // Verifica meta viewport para responsividade
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
            '/',
            '/pages/profile',
            '/pages/account-settings',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);

            $content = $response->getContent();

            // Verifica presença de ícones (Tabler Icons - ti ti-)
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
        $response = $this->get('/');

        // Verifica badges
        $response->assertSee('class="badge', false);

        // Verifica cards
        $response->assertSee('class="card', false);
        $response->assertSee('class="card-body', false);
        $response->assertSee('class="card-header', false);
    }

    /**
     * Testa que profile view inclui badges
     *
     * @test
     */
    public function profile_view_includes_badges()
    {
        $response = $this->get('/pages/profile');

        // Verifica badges nos projetos
        $response->assertSee('class="badge bg-label-primary"', false);
        $response->assertSee('class="badge bg-label-success"', false);
        $response->assertSee('class="badge bg-label-info"', false);
        $response->assertSee('class="badge bg-label-warning"', false);
    }

    /**
     * Testa que account settings view inclui alertas
     *
     * @test
     */
    public function account_settings_view_includes_alerts()
    {
        $response = $this->get('/pages/account-settings');

        // Verifica alertas Bootstrap
        $response->assertSee('class="alert alert-warning"', false);
        $response->assertSee('alert-heading', false);
    }
}
