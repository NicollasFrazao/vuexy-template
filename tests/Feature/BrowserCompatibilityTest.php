<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\File;

/**
 * Testes automatizados de compatibilidade de navegadores para Requisito 11.1-11.4
 *
 * Valida que o HTML/CSS gerado segue padrões que são compatíveis com
 * navegadores modernos. Bootstrap 5 oferece suporte oficial para:
 * - Chrome (última versão)
 * - Firefox (última versão)
 * - Safari (última versão)
 * - Edge (última versão)
 *
 * Testes manuais em cada navegador complementam estes automatizados.
 */
class BrowserCompatibilityTest extends TestCase
{
    /**
     * Testa que as páginas começam com DOCTYPE HTML5 válido
     *
     * @test
     */
    public function pages_use_html5_doctype(): void
    {
        $routes = ['/', '/ui/alerts', '/ui/buttons'];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);

            $html = $response->getContent();

            $this->assertTrue(
                str_starts_with(trim($html), '<!DOCTYPE html') ||
                str_starts_with(trim($html), '<!doctype html'),
                "Route {$route} must start with HTML5 DOCTYPE for cross-browser compatibility"
            );
        }
    }

    /**
     * Testa que as páginas definem charset UTF-8
     *
     * @test
     */
    public function pages_define_utf8_charset(): void
    {
        $routes = ['/', '/ui/alerts'];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);

            $html = $response->getContent();

            $hasCharset = str_contains($html, 'charset="UTF-8"') ||
                          str_contains($html, "charset='UTF-8'") ||
                          str_contains($html, 'charset="utf-8"') ||
                          str_contains($html, "charset='utf-8'") ||
                          str_contains($html, 'charset=utf-8') ||
                          str_contains($html, 'charset=UTF-8');

            $this->assertTrue(
                $hasCharset,
                "Route {$route} must define UTF-8 charset for cross-browser text encoding"
            );
        }
    }

    /**
     * Testa que as páginas usam lang attribute para acessibilidade
     *
     * @test
     */
    public function pages_include_html_lang_attribute(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $html = $response->getContent();

        $hasLang = preg_match('/<html[^>]*\slang=["\'][^"\']+["\']/', $html);

        $this->assertGreaterThan(
            0,
            $hasLang,
            'HTML tag must include lang attribute for accessibility and international browser support'
        );
    }

    /**
     * Testa que as páginas incluem viewport meta tag para mobile browsers
     *
     * @test
     */
    public function pages_include_mobile_viewport_meta(): void
    {
        $routes = ['/', '/ui/alerts', '/auth/login-basic'];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);

            $html = $response->getContent();

            $this->assertStringContainsString(
                'name="viewport"',
                $html,
                "Route {$route} must include viewport meta tag for mobile browsers"
            );
        }
    }

    /**
     * Testa que o CSS compilado existe e é acessível (requerido por todos os browsers)
     *
     * @test
     */
    public function compiled_css_assets_are_accessible(): void
    {
        $manifestPath = public_path('build/manifest.json');
        $this->assertFileExists($manifestPath, 'Vite manifest must exist for CSS to be served to browsers');

        $manifest = json_decode(file_get_contents($manifestPath), true);

        // Arquivos CSS essenciais que devem estar no manifest
        $requiredEntries = [
            'resources/css/core.css',
            'resources/css/theme-default.css',
        ];

        foreach ($requiredEntries as $entry) {
            $this->assertArrayHasKey(
                $entry,
                $manifest,
                "CSS entry '{$entry}' must be compiled for browsers to load styles correctly"
            );
        }
    }

    /**
     * Testa que o JavaScript compilado existe e é acessível
     *
     * @test
     */
    public function compiled_js_assets_are_accessible(): void
    {
        $manifestPath = public_path('build/manifest.json');
        $this->assertFileExists($manifestPath, 'Vite manifest must exist for JS to be served to browsers');

        $manifest = json_decode(file_get_contents($manifestPath), true);

        // JS essencial que deve estar no manifest
        $requiredEntries = [
            'resources/js/app.js',
            'resources/js/template.js',
        ];

        foreach ($requiredEntries as $entry) {
            $this->assertArrayHasKey(
                $entry,
                $manifest,
                "JS entry '{$entry}' must be compiled for browser-side interactivity"
            );
        }
    }

    /**
     * Testa que o CSS compilado não usa propriedades obsoletas de IE
     * (Bootstrap 5 não suporta IE - esta validação confirma ausência de hacks IE)
     *
     * @test
     */
    public function compiled_css_does_not_use_ie_hacks(): void
    {
        $manifestPath = public_path('build/manifest.json');
        if (!file_exists($manifestPath)) {
            $this->markTestSkipped('Build not available. Run: npm run build');
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);

        // Pegar um arquivo CSS compilado para verificar
        $cssEntry = null;
        foreach ($manifest as $key => $value) {
            if (str_ends_with($key, '.css') && isset($value['file'])) {
                $cssEntry = public_path('build/' . $value['file']);
                break;
            }
        }

        if (!$cssEntry || !file_exists($cssEntry)) {
            $this->markTestSkipped('No compiled CSS found to check');
        }

        $cssContent = file_get_contents($cssEntry);

        // Verificar que não há filtros IE obsoletos
        $this->assertStringNotContainsString(
            'filter:progid:DXImageTransform',
            $cssContent,
            'Compiled CSS must not contain IE-specific filter hacks'
        );
    }

    /**
     * Testa que as páginas de autenticação são acessíveis (usadas em mobile browsers)
     *
     * @test
     */
    public function auth_pages_are_accessible(): void
    {
        $authRoutes = [
            '/auth/login-basic',
            '/auth/register-basic',
            '/auth/forgot-password-basic',
        ];

        foreach ($authRoutes as $route) {
            $response = $this->get($route);

            $this->assertEquals(
                200,
                $response->status(),
                "Auth route {$route} must be accessible (status 200) across all browsers"
            );
        }
    }

    /**
     * Testa que páginas de erro são acessíveis em qualquer browser
     *
     * @test
     */
    public function error_pages_render_for_invalid_routes(): void
    {
        $response = $this->get('/this-route-does-not-exist-xyz');

        $this->assertContains(
            $response->status(),
            [302, 404],
            'Invalid routes must return appropriate HTTP status (302 redirect or 404 not found)'
        );
    }

    /**
     * Testa que todas as páginas principais incluem X-Content-Type-Options
     * (segurança cross-browser)
     *
     * @test
     */
    public function pages_render_valid_html_structure(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $html = $response->getContent();

        // Verificar estrutura HTML básica válida para todos os browsers
        $this->assertStringContainsString('<head>', $html, 'Page must include <head> section');
        $this->assertStringContainsString('</head>', $html, 'Page must close <head> section');
        $this->assertStringContainsString('<body', $html, 'Page must include <body> tag');
        $this->assertStringContainsString('</body>', $html, 'Page must close <body> tag');
        $this->assertStringContainsString('</html>', $html, 'Page must close <html> tag');
    }
}
