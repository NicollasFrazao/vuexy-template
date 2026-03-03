<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Integration tests for asset loading.
 *
 * Validates: Requirements 11.1, 11.2, 11.3
 *
 * Verifies that CSS, JavaScript, and key images referenced in the Vite manifest
 * exist on disk (i.e., would be served without a 404 error).
 */
class AssetIntegrationTest extends TestCase
{
    private array $manifest = [];

    protected function setUp(): void
    {
        parent::setUp();

        $manifestPath = public_path('build/manifest.json');

        if (file_exists($manifestPath)) {
            $this->manifest = json_decode(file_get_contents($manifestPath), true) ?? [];
        }
    }

    // -------------------------------------------------------------------------
    // CSS tests — Requirement 11.1
    // -------------------------------------------------------------------------

    /**
     * Testa que o manifest.json existe após o build.
     *
     * @test
     */
    public function manifest_json_exists_after_build(): void
    {
        $this->assertFileExists(
            public_path('build/manifest.json'),
            'public/build/manifest.json deve existir após npm run build'
        );
    }

    /**
     * Testa que o CSS principal (app.css) é compilado e existe sem erros 404.
     *
     * Validates: Requirement 11.1
     *
     * @test
     */
    public function css_app_is_compiled_and_exists_without_404(): void
    {
        $this->assertArrayHasKey(
            'resources/css/app.css',
            $this->manifest,
            'resources/css/app.css deve estar no manifest.json'
        );

        $compiledFile = $this->manifest['resources/css/app.css']['file'];
        $fullPath = public_path('build/'.$compiledFile);

        $this->assertFileExists(
            $fullPath,
            "CSS compilado '{$compiledFile}' deve existir em public/build/ (sem erro 404)"
        );
        // app.css may be empty (only comments) — existence is sufficient to avoid a 404
    }

    /**
     * Testa que o CSS do core (core.css) é compilado e existe sem erros 404.
     *
     * Validates: Requirement 11.1
     *
     * @test
     */
    public function css_core_is_compiled_and_exists_without_404(): void
    {
        $this->assertArrayHasKey(
            'resources/css/core.css',
            $this->manifest,
            'resources/css/core.css deve estar no manifest.json'
        );

        $compiledFile = $this->manifest['resources/css/core.css']['file'];
        $fullPath = public_path('build/'.$compiledFile);

        $this->assertFileExists(
            $fullPath,
            "CSS compilado '{$compiledFile}' deve existir em public/build/ (sem erro 404)"
        );
        $this->assertGreaterThan(0, filesize($fullPath), 'O arquivo CSS compilado não deve estar vazio');
    }

    /**
     * Testa que todos os arquivos CSS referenciados no manifest existem sem erros 404.
     *
     * Validates: Requirement 11.1
     *
     * @test
     */
    public function all_css_files_in_manifest_exist_without_404(): void
    {
        $cssEntries = array_filter(
            $this->manifest,
            fn ($key) => str_ends_with($key, '.css'),
            ARRAY_FILTER_USE_KEY
        );

        $this->assertNotEmpty($cssEntries, 'O manifest deve conter pelo menos um entry point CSS');

        foreach ($cssEntries as $entryKey => $entry) {
            $compiledFile = $entry['file'];
            $fullPath = public_path('build/'.$compiledFile);

            $this->assertFileExists(
                $fullPath,
                "CSS '{$entryKey}' compilado como '{$compiledFile}' deve existir em public/build/ (sem erro 404)"
            );
        }
    }

    // -------------------------------------------------------------------------
    // JavaScript tests — Requirement 11.2
    // -------------------------------------------------------------------------

    /**
     * Testa que o JavaScript principal (app.js) é compilado e existe sem erros 404.
     *
     * Validates: Requirement 11.2
     *
     * @test
     */
    public function js_app_is_compiled_and_exists_without_404(): void
    {
        $this->assertArrayHasKey(
            'resources/js/app.js',
            $this->manifest,
            'resources/js/app.js deve estar no manifest.json'
        );

        $compiledFile = $this->manifest['resources/js/app.js']['file'];
        $fullPath = public_path('build/'.$compiledFile);

        $this->assertFileExists(
            $fullPath,
            "JavaScript compilado '{$compiledFile}' deve existir em public/build/ (sem erro 404)"
        );
        $this->assertGreaterThan(0, filesize($fullPath), 'O arquivo JS compilado não deve estar vazio');
    }

    /**
     * Testa que o JavaScript do template (template.js) é compilado e existe sem erros 404.
     *
     * Validates: Requirement 11.2
     *
     * @test
     */
    public function js_template_is_compiled_and_exists_without_404(): void
    {
        $this->assertArrayHasKey(
            'resources/js/template.js',
            $this->manifest,
            'resources/js/template.js deve estar no manifest.json'
        );

        $compiledFile = $this->manifest['resources/js/template.js']['file'];
        $fullPath = public_path('build/'.$compiledFile);

        $this->assertFileExists(
            $fullPath,
            "JavaScript compilado '{$compiledFile}' deve existir em public/build/ (sem erro 404)"
        );
        $this->assertGreaterThan(0, filesize($fullPath), 'O arquivo JS compilado não deve estar vazio');
    }

    /**
     * Testa que todos os arquivos JavaScript referenciados no manifest existem sem erros 404.
     *
     * Validates: Requirement 11.2
     *
     * @test
     */
    public function all_js_files_in_manifest_exist_without_404(): void
    {
        $jsEntries = array_filter(
            $this->manifest,
            fn ($key) => str_ends_with($key, '.js'),
            ARRAY_FILTER_USE_KEY
        );

        $this->assertNotEmpty($jsEntries, 'O manifest deve conter pelo menos um entry point JavaScript');

        foreach ($jsEntries as $entryKey => $entry) {
            $compiledFile = $entry['file'];
            $fullPath = public_path('build/'.$compiledFile);

            $this->assertFileExists(
                $fullPath,
                "JavaScript '{$entryKey}' compilado como '{$compiledFile}' deve existir em public/build/ (sem erro 404)"
            );
        }
    }

    // -------------------------------------------------------------------------
    // Image tests — Requirement 11.3
    // -------------------------------------------------------------------------

    /**
     * Testa que as imagens de avatar principais existem em resources/images/.
     *
     * Validates: Requirement 11.3
     *
     * @test
     */
    public function key_avatar_images_exist(): void
    {
        $keyAvatars = [
            'resources/images/avatars/1.png',
            'resources/images/avatars/2.png',
            'resources/images/avatars/3.png',
        ];

        foreach ($keyAvatars as $avatarPath) {
            $this->assertFileExists(
                base_path($avatarPath),
                "Imagem de avatar '{$avatarPath}' deve existir"
            );
        }
    }

    /**
     * Testa que as imagens de ilustração principais existem em resources/images/.
     *
     * Validates: Requirement 11.3
     *
     * @test
     */
    public function key_illustration_images_exist(): void
    {
        $keyIllustrations = [
            'resources/images/illustrations/page-misc-error.png',
            'resources/images/illustrations/bg-shape-image-light.png',
            'resources/images/illustrations/bg-shape-image-dark.png',
        ];

        foreach ($keyIllustrations as $imagePath) {
            $this->assertFileExists(
                base_path($imagePath),
                "Imagem de ilustração '{$imagePath}' deve existir"
            );
        }
    }

    /**
     * Testa que o favicon existe.
     *
     * Validates: Requirement 11.3
     *
     * @test
     */
    public function favicon_exists(): void
    {
        $this->assertFileExists(
            base_path('resources/images/favicon/favicon.ico'),
            'O favicon deve existir em resources/images/favicon/favicon.ico'
        );
    }

    /**
     * Testa que as imagens referenciadas no manifest existem em public/build/.
     *
     * Validates: Requirement 11.3
     *
     * @test
     */
    public function all_images_in_manifest_exist_without_404(): void
    {
        $imageExtensions = ['png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'webp'];

        $imageEntries = array_filter(
            $this->manifest,
            function ($key) use ($imageExtensions) {
                $ext = strtolower(pathinfo($key, PATHINFO_EXTENSION));

                return in_array($ext, $imageExtensions, true);
            },
            ARRAY_FILTER_USE_KEY
        );

        // Images may not all be in the manifest (only those imported by JS/CSS are),
        // but any that are listed must exist on disk.
        foreach ($imageEntries as $entryKey => $entry) {
            $compiledFile = $entry['file'];
            $fullPath = public_path('build/'.$compiledFile);

            $this->assertFileExists(
                $fullPath,
                "Imagem '{$entryKey}' compilada como '{$compiledFile}' deve existir em public/build/ (sem erro 404)"
            );
        }

        // Always pass if no images are in the manifest (they may be served directly)
        $this->assertTrue(true);
    }

    /**
     * Testa que as páginas renderizadas referenciam assets CSS e JS que existem.
     *
     * Validates: Requirements 11.1, 11.2
     *
     * @test
     */
    public function rendered_pages_reference_existing_css_and_js_assets(): void
    {
        $routes = ['/', '/pages/profile', '/pages/account-settings'];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);

            $html = $response->getContent();

            // Extract CSS hrefs from <link rel="stylesheet">
            preg_match_all(
                '/<link[^>]+rel=["\']stylesheet["\'][^>]+href=["\']([^"\']+)["\'][^>]*>/i',
                $html,
                $cssMatches
            );
            preg_match_all(
                '/<link[^>]+href=["\']([^"\']+)["\'][^>]+rel=["\']stylesheet["\'][^>]*>/i',
                $html,
                $cssMatches2
            );
            $cssAssets = array_merge($cssMatches[1], $cssMatches2[1]);

            // Extract JS srcs from <script src="...">
            preg_match_all('/<script[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $html, $jsMatches);
            $jsAssets = $jsMatches[1];

            foreach (array_merge($cssAssets, $jsAssets) as $assetUrl) {
                // Only check assets served from /build/
                if (! preg_match('#^/?build/#', $assetUrl)) {
                    continue;
                }

                $filePath = public_path(ltrim(strtok($assetUrl, '?#'), '/'));

                $this->assertFileExists(
                    $filePath,
                    "Asset '{$assetUrl}' referenciado na rota '{$route}' deve existir em '{$filePath}' (sem erro 404)"
                );
            }
        }
    }
}
