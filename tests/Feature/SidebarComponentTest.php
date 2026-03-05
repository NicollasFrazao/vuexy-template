<?php

namespace Tests\Feature;

use Tests\TestCase;

class SidebarComponentTest extends TestCase
{
    /** @test */
    public function sidebar_component_renders_on_dashboard()
    {
        $response = $this->get('/ui/alerts');

        $response->assertStatus(200);
        $response->assertSee('layout-menu');
        $response->assertSee('menu-vertical');
    }

    /** @test */
    public function sidebar_contains_menu_items()
    {
        $response = $this->get('/ui/alerts');

        // Check for menu items present in the sidebar
        $response->assertSee('Dashboard');
    }

    /** @test */
    public function sidebar_marks_active_menu_item_on_dashboard()
    {
        $response = $this->get('/ui/alerts');

        $content = $response->getContent();

        // Check that some menu item has active class
        $this->assertStringContainsString('menu-item', $content);
    }

    /** @test */
    public function sidebar_marks_active_menu_item_on_profile()
    {
        $response = $this->get('/pages/account-settings-connections');

        $response->assertStatus(200);
        $content = $response->getContent();

        $this->assertStringContainsString('Connections', $content);
    }

    /** @test */
    public function sidebar_contains_app_brand()
    {
        $response = $this->get('/ui/alerts');

        $response->assertSee('app-brand');
        $response->assertSee(config('app.name', 'Vuexy'));
    }

    /** @test */
    public function sidebar_contains_mobile_toggler()
    {
        $response = $this->get('/ui/alerts');

        $response->assertSee('menu-mobile-toggler');
        $response->assertSee('layout-menu-toggle');
    }
}
