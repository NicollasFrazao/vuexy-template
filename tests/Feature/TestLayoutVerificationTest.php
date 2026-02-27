<?php

namespace Tests\Feature;

use Tests\TestCase;

class TestLayoutVerificationTest extends TestCase
{
    /** @test */
    public function test_layout_page_renders_successfully()
    {
        $response = $this->get('/test-layout');
        
        $response->assertStatus(200);
        $response->assertSee('Teste de Layout e Componentes');
    }
    
    /** @test */
    public function test_layout_includes_all_components()
    {
        $response = $this->get('/test-layout');
        
        // Verify sidebar is present
        $response->assertSee('menu-inner');
        
        // Verify navbar is present
        $response->assertSee('layout-navbar');
        
        // Verify footer is present
        $response->assertSee('content-footer');
        
        // Verify main content is present
        $response->assertSee('Componentes Verificados');
    }
    
    /** @test */
    public function test_layout_references_vite_assets()
    {
        $response = $this->get('/test-layout');
        
        // Verify Vite directives are present (they will be processed in production)
        $content = $response->getContent();
        $this->assertStringContainsString('@vite', $content);
    }
}
