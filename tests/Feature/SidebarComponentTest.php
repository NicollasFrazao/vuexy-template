<?php

namespace Tests\Feature;

use Tests\TestCase;

class SidebarComponentTest extends TestCase
{
    /** @test */
    public function sidebar_component_renders_on_dashboard()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('layout-menu');
        $response->assertSee('menu-vertical');
        $response->assertSee('Dashboard');
    }
    
    /** @test */
    public function sidebar_contains_menu_items()
    {
        $response = $this->get('/');
        
        // Check for menu items
        $response->assertSee('Dashboard');
        $response->assertSee('Account Settings');
        $response->assertSee('Profile');
    }
    
    /** @test */
    public function sidebar_marks_active_menu_item_on_dashboard()
    {
        $response = $this->get('/');
        
        $content = $response->getContent();
        
        // Check that dashboard menu item has active class
        $this->assertStringContainsString('menu-item active', $content);
    }
    
    /** @test */
    public function sidebar_marks_active_menu_item_on_profile()
    {
        $response = $this->get('/pages/profile');
        
        $response->assertStatus(200);
        $content = $response->getContent();
        
        // Check that profile menu item is present
        $this->assertStringContainsString('Profile', $content);
    }
    
    /** @test */
    public function sidebar_contains_app_brand()
    {
        $response = $this->get('/');
        
        $response->assertSee('app-brand');
        $response->assertSee(config('app.name', 'Vuexy'));
    }
    
    /** @test */
    public function sidebar_contains_mobile_toggler()
    {
        $response = $this->get('/');
        
        $response->assertSee('menu-mobile-toggler');
        $response->assertSee('layout-menu-toggle');
    }
}
