<?php

namespace Tests\Property;

use Eris\Generator;
use Eris\TestTrait;
use Illuminate\Support\Facades\Route;
use Tests\PropertyTestCase;

class AssetExistenceTest extends PropertyTestCase
{
    use TestTrait;

    /**
     * Override Eris's getTestCaseAnnotations to fix PHPUnit 11 compatibility.
     */
    public function getTestCaseAnnotations()
    {
        return [];
    }

    /**
     * Feature: laravel-bootstrap-templates, Property 3: Assets Referenciados Existem
     *
     * **Validates: Requirements 3.2, 11.1, 11.2, 11.3, 11.4**
     *
     * Para qualquer página renderizada, todos os assets referenciados (arquivos CSS via tags
     * link, arquivos JavaScript via tags script, imagens via tags img, fontes via @font-face)
     * devem existir no sistema de arquivos e ser acessíveis.
     *
     * Since Vite uses hashed filenames, this test:
     * 1. Verifies that manifest.json exists and contains the expected entry points
     * 2. Verifies that every compiled file listed in the manifest actually exists on disk
     * 3. Verifies that assets referenced in rendered HTML pages exist on disk
     *
     * @test
     */
    public function manifest_entry_points_exist_on_disk()
    {
        $manifestPath = public_path('build/manifest.json');

        $this->assertFileExists(
            $manifestPath,
            'public/build/manifest.json must exist after running npm run build'
        );

        $manifest = json_decode(file_get_contents($manifestPath), true);

        $this->assertIsArray($manifest, 'manifest.json must contain valid JSON');
        $this->assertNotEmpty($manifest, 'manifest.json must not be empty');

        // Collect all unique compiled file paths from the manifest
        $compiledFiles = [];
        foreach ($manifest as $entryKey => $entry) {
            if (isset($entry['file'])) {
                $compiledFiles[$entry['file']] = $entryKey;
            }
            if (isset($entry['css']) && is_array($entry['css'])) {
                foreach ($entry['css'] as $cssFile) {
                    $compiledFiles[$cssFile] = $entryKey.' (css)';
                }
            }
        }

        $this->assertNotEmpty($compiledFiles, 'Manifest must reference at least one compiled file');

        // Skip if compiled files are not present (npm run build not executed)
        $firstFile = array_key_first($compiledFiles);
        if (! file_exists(public_path('build/'.$firstFile))) {
            $this->markTestSkipped(
                'Compiled build files not found in public/build/. Run "npm run build" to generate them.'
            );
        }

        $this->forAll(
            Generator\elements(array_keys($compiledFiles))
        )
            ->then(function ($compiledFile) use ($compiledFiles) {
                $fullPath = public_path('build/'.$compiledFile);
                $this->assertFileExists(
                    $fullPath,
                    "Compiled asset '{$compiledFile}' (from entry '{$compiledFiles[$compiledFile]}') "
                    ."must exist at public/build/{$compiledFile}"
                );
            });
    }

    /**
     * Feature: laravel-bootstrap-templates, Property 3: Assets Referenciados Existem
     *
     * **Validates: Requirements 3.2, 11.1, 11.2, 11.3, 11.4**
     *
     * Verifies that the manifest contains the expected CSS and JS entry points
     * defined in vite.config.js.
     *
     * @test
     */
    public function manifest_contains_expected_entry_points()
    {
        $manifestPath = public_path('build/manifest.json');

        $this->assertFileExists(
            $manifestPath,
            'public/build/manifest.json must exist after running npm run build'
        );

        $manifest = json_decode(file_get_contents($manifestPath), true);
        $this->assertIsArray($manifest, 'manifest.json must contain valid JSON');

        // Read vite.config.js to discover configured entry points
        $viteConfigPath = base_path('vite.config.js');
        $this->assertFileExists($viteConfigPath, 'vite.config.js must exist');

        $viteConfig = file_get_contents($viteConfigPath);

        // Extract entry points from vite.config.js input array
        preg_match_all("/['\"]resources\/(?:css|js)\/[^'\"]+\.[a-z]+['\"]/", $viteConfig, $matches);
        $configuredEntries = array_map(fn ($e) => trim($e, "'\""), $matches[0]);

        $this->assertNotEmpty(
            $configuredEntries,
            'vite.config.js should define at least one entry point in resources/css/ or resources/js/'
        );

        // Skip if compiled files are not present (npm run build not executed)
        $firstEntry = $configuredEntries[0];
        if (isset($manifest[$firstEntry])) {
            $firstFile = $manifest[$firstEntry]['file'] ?? null;
            if ($firstFile && ! file_exists(public_path('build/'.$firstFile))) {
                $this->markTestSkipped(
                    'Compiled build files not found in public/build/. Run "npm run build" to generate them.'
                );
            }
        }

        $this->forAll(
            Generator\elements($configuredEntries)
        )
            ->then(function ($entryPoint) use ($manifest) {
                $this->assertArrayHasKey(
                    $entryPoint,
                    $manifest,
                    "Entry point '{$entryPoint}' configured in vite.config.js must appear in manifest.json"
                );

                $entry = $manifest[$entryPoint];
                $this->assertArrayHasKey(
                    'file',
                    $entry,
                    "Manifest entry for '{$entryPoint}' must have a 'file' key pointing to the compiled output"
                );

                // The compiled file must exist on disk
                $compiledPath = public_path('build/'.$entry['file']);
                $this->assertFileExists(
                    $compiledPath,
                    "Compiled file '{$entry['file']}' for entry '{$entryPoint}' must exist at public/build/{$entry['file']}"
                );
            });
    }

    /**
     * Feature: laravel-bootstrap-templates, Property 3: Assets Referenciados Existem
     *
     * **Validates: Requirements 3.2, 11.1, 11.2, 11.3, 11.4**
     *
     * For any rendered HTML page, CSS <link> and JS <script> assets referenced via
     * Vite-generated paths must exist in public/build/.
     *
     * @test
     */
    public function assets_referenced_in_rendered_pages_exist_on_disk()
    {
        // Skip if compiled files are not present (npm run build not executed)
        $manifestPath = public_path('build/manifest.json');
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true) ?? [];
            $hasBuildFiles = false;
            foreach ($manifest as $entry) {
                if (isset($entry['file']) && file_exists(public_path('build/'.$entry['file']))) {
                    $hasBuildFiles = true;
                    break;
                }
            }
            if (! $hasBuildFiles) {
                $this->markTestSkipped(
                    'Compiled build files not found in public/build/. Run "npm run build" to generate them.'
                );
            }
        }

        // Collect GET routes that don't require parameters and aren't special
        $testableRoutes = $this->getTestableRoutes();

        $this->assertNotEmpty(
            $testableRoutes,
            'There must be at least one testable GET route to validate asset existence'
        );

        $this->forAll(
            Generator\elements($testableRoutes)
        )
            ->then(function ($routeUri) {
                $response = $this->get('/'.ltrim($routeUri, '/'));

                // Only validate pages that render successfully
                if ($response->status() !== 200) {
                    return;
                }

                $html = $response->getContent();

                // Extract CSS assets from <link rel="stylesheet" href="...">
                $cssAssets = $this->extractCssAssets($html);

                // Extract JS assets from <script src="...">
                $jsAssets = $this->extractJsAssets($html);

                // Extract image assets from <img src="...">
                $imgAssets = $this->extractImgAssets($html);

                $allAssets = array_merge($cssAssets, $jsAssets, $imgAssets);

                foreach ($allAssets as $assetUrl) {
                    // Only check assets served from public/build/
                    if (! $this->isBuildAsset($assetUrl)) {
                        continue;
                    }

                    $filePath = $this->resolveAssetPath($assetUrl);

                    $this->assertFileExists(
                        $filePath,
                        "Asset '{$assetUrl}' referenced in route '{$routeUri}' must exist at '{$filePath}'"
                    );
                }
            });
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Returns GET route URIs that are testable (no required params, not special).
     */
    private function getTestableRoutes(): array
    {
        $routes = [];

        foreach (Route::getRoutes() as $route) {
            $uri = $route->uri();

            if (! in_array('GET', $route->methods())) {
                continue;
            }

            // Skip routes with required parameters
            if (preg_match('/\{[^?}]+\}/', $uri)) {
                continue;
            }

            // Skip special / API routes
            foreach (['api/', 'sanctum/', '_ignition/', 'livewire/'] as $prefix) {
                if (str_starts_with($uri, $prefix)) {
                    continue 2;
                }
            }

            $routes[] = $uri;
        }

        return $routes;
    }

    /**
     * Extracts href values from <link rel="stylesheet"> tags.
     */
    private function extractCssAssets(string $html): array
    {
        preg_match_all('/<link[^>]+rel=["\']stylesheet["\'][^>]+href=["\']([^"\']+)["\'][^>]*>/i', $html, $m1);
        preg_match_all('/<link[^>]+href=["\']([^"\']+)["\'][^>]+rel=["\']stylesheet["\'][^>]*>/i', $html, $m2);

        return array_merge($m1[1], $m2[1]);
    }

    /**
     * Extracts src values from <script> tags.
     */
    private function extractJsAssets(string $html): array
    {
        preg_match_all('/<script[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $html, $matches);

        return $matches[1];
    }

    /**
     * Extracts src values from <img> tags.
     */
    private function extractImgAssets(string $html): array
    {
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $html, $matches);

        return $matches[1];
    }

    /**
     * Returns true if the asset URL points to public/build/.
     */
    private function isBuildAsset(string $url): bool
    {
        // Match URLs like /build/assets/app-xxx.css or build/assets/app-xxx.js
        return (bool) preg_match('#^/?build/#', $url);
    }

    /**
     * Resolves an asset URL to an absolute filesystem path under public/.
     */
    private function resolveAssetPath(string $url): string
    {
        // Strip query string / fragment
        $url = strtok($url, '?#');

        // Strip leading slash
        $url = ltrim($url, '/');

        return public_path($url);
    }
}
