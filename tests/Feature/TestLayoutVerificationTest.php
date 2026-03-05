<?php

namespace Tests\Feature;

use Tests\TestCase;

class TestLayoutVerificationTest extends TestCase
{
    /** @test */
    public function test_layout_page_renders_successfully()
    {
        $response = $this->get('/ui/alerts');

        $response->assertStatus(200);
        $response->assertSee('layout-wrapper');
    }

    /** @test */
    public function test_layout_includes_all_components()
    {
        $response = $this->get('/ui/alerts');

        // Verify sidebar is present
        $response->assertSee('menu-inner');

        // Verify navbar is present
        $response->assertSee('layout-navbar');

        // Verify footer is present
        $response->assertSee('content-footer');

        // Verify main content is present
        $response->assertSee('alert');
    }

    /** @test */
    public function test_layout_references_vite_assets()
    {
        $response = $this->get('/ui/alerts');

        // Verify that assets are loaded (Vite processes @vite directives)
        $content = $response->getContent();
        // In production, @vite is replaced with actual asset links
        $this->assertTrue(
            str_contains($content, 'resources/css/app.css') ||
            str_contains($content, 'resources/js/app.js') ||
            str_contains($content, '/build/'),
            'Layout should reference Vite-processed assets'
        );
    }
}
