<?php

namespace Tests\Feature;

use Tests\TestCase;

class AssetImportTest extends TestCase
{
    /**
     * Test that Vite build completes successfully without module resolution errors
     *
     * @test
     */
    public function vite_build_completes_without_errors()
    {
        // Check if npm is available
        $npmCheck = [];
        $npmCheckReturn = 0;
        exec('which npm 2>&1', $npmCheck, $npmCheckReturn);
        
        if ($npmCheckReturn !== 0) {
            $this->markTestSkipped('npm is not available in this environment (expected in Docker PHP container)');
        }

        // Run the build command
        $output = [];
        $returnCode = 0;
        exec('npm run build 2>&1', $output, $returnCode);

        $outputString = implode("\n", $output);

        // Assert build succeeded
        $this->assertEquals(0, $returnCode, "Vite build failed with output:\n".$outputString);

        // Assert no module resolution errors
        $this->assertStringNotContainsString('Module not found', $outputString);
        $this->assertStringNotContainsString('Cannot find module', $outputString);
        $this->assertStringNotContainsString('Failed to resolve', $outputString);

        // Assert manifest was created
        $this->assertFileExists(public_path('build/manifest.json'));
    }

    /**
     * Test that all CSS entry points are compiled
     *
     * @test
     */
    public function all_css_entry_points_are_compiled()
    {
        $manifest = json_decode(
            file_get_contents(public_path('build/manifest.json')),
            true
        );

        // Check that CSS files are in the manifest
        $this->assertArrayHasKey('resources/css/app.css', $manifest);
        $this->assertArrayHasKey('resources/css/core.css', $manifest);
        $this->assertArrayHasKey('resources/css/theme-default.css', $manifest);
        $this->assertArrayHasKey('resources/css/demo.css', $manifest);
    }

    /**
     * Test that all JavaScript entry points are compiled
     *
     * @test
     */
    public function all_javascript_entry_points_are_compiled()
    {
        $manifest = json_decode(
            file_get_contents(public_path('build/manifest.json')),
            true
        );

        // Check that JS files are in the manifest
        $this->assertArrayHasKey('resources/js/app.js', $manifest);
        $this->assertArrayHasKey('resources/js/template.js', $manifest);
    }

    /**
     * Test that CSS imports are resolved correctly
     *
     * @test
     */
    public function css_imports_are_resolved()
    {
        // Read theme-default.css
        $themeDefaultContent = file_get_contents(resource_path('css/theme-default.css'));

        // Check that it has import statements
        $this->assertStringContainsString('@import', $themeDefaultContent);

        // Verify the imported files exist
        $this->assertFileExists(resource_path('css/vendor/_custom-variables/_bootstrap-extended.scss'));
        $this->assertFileExists(resource_path('css/vendor/_custom-variables/_components.scss'));
    }

    /**
     * Test that JavaScript imports are resolved correctly
     *
     * @test
     */
    public function javascript_imports_are_resolved()
    {
        // Read template.js
        $templateContent = file_get_contents(resource_path('js/template.js'));

        // Check that it has import statements
        $this->assertStringContainsString('import', $templateContent);

        // Verify the imported files exist
        $this->assertFileExists(resource_path('js/vendors/helpers.js'));
        $this->assertFileExists(resource_path('js/vendors/menu.js'));
        $this->assertFileExists(resource_path('js/config.js'));
        $this->assertFileExists(resource_path('js/main.js'));
    }

    /**
     * Test that Vite aliases are configured correctly
     *
     * @test
     */
    public function vite_aliases_are_configured()
    {
        $viteConfig = file_get_contents(base_path('vite.config.js'));

        // Check that aliases are defined
        $this->assertStringContainsString("'@': '/resources/js'", $viteConfig);
        $this->assertStringContainsString("'@css': '/resources/css'", $viteConfig);
        $this->assertStringContainsString("'@img': '/resources/images'", $viteConfig);
    }
}
