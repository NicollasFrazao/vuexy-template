<?php

namespace Tests\Feature;

use Tests\TestCase;

class ErrorPageTest extends TestCase
{
    /**
     * Testa que uma rota inexistente retorna status 404
     *
     * @test
     */
    public function nonexistent_route_returns_404()
    {
        $response = $this->get('/this-route-does-not-exist');

        $response->assertStatus(404);
    }

    /**
     * Testa que a página 404 usa o layout do template (extends layouts.app)
     *
     * @test
     */
    public function error_404_page_uses_template_layout()
    {
        $response = $this->get('/this-route-does-not-exist');

        $response->assertStatus(404);

        $content = $response->getContent();

        // Verifica estrutura HTML do layout principal
        $this->assertStringContainsString('<!DOCTYPE html>', $content);
        $this->assertStringContainsString('<html', $content);
        $this->assertStringContainsString('<head>', $content);
        $this->assertStringContainsString('<body>', $content);

        // Verifica componentes do layout Vuexy
        $this->assertStringContainsString('layout-wrapper', $content);
        $this->assertStringContainsString('layout-container', $content);
    }

    /**
     * Testa que a página 404 exibe mensagem de erro adequada
     *
     * @test
     */
    public function error_404_page_displays_error_message()
    {
        $response = $this->get('/another-missing-page');

        $response->assertStatus(404);
        $response->assertSee('Page Not Found', false);
    }

    /**
     * Testa que a página 404 inclui link de retorno à home
     *
     * @test
     */
    public function error_404_page_includes_home_link()
    {
        $response = $this->get('/missing-page');

        $response->assertStatus(404);
        $response->assertSee(url('/'), false);
    }
}
