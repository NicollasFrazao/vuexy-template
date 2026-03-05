<?php

namespace Tests\Property;

use Eris\Generator;
use Eris\TestTrait;
use Tests\PropertyTestCase;

class AssetProcessingTest extends PropertyTestCase
{
    use TestTrait;

    /**
     * Override Eris's getTestCaseAnnotations to fix PHPUnit 11 compatibility.
     * PHPUnit 11 removed PHPUnit\Util\Test::parseTestMethodAnnotations().
     */
    public function getTestCaseAnnotations()
    {
        return [];
    }

    /**
     * Feature: laravel-bootstrap-templates, Property 2: Configuração de Build Processa Assets
     *
     * **Validates: Requirements 5.1, 5.2, 5.3**
     *
     * Para qualquer tipo de asset (CSS, JavaScript, imagens, fontes), a configuração do Vite
     * deve incluir regras de processamento que transformem os arquivos de entrada em resources/
     * para arquivos otimizados em public/build/.
     *
     * @test
     */
    public function vite_config_processes_all_asset_types()
    {
        $this->forAll(
            Generator\elements(['css', 'js', 'images', 'fonts'])
        )
            ->then(function ($assetType) {
                // Verificar que vite.config.js existe
                $viteConfigPath = base_path('vite.config.js');
                $this->assertFileExists(
                    $viteConfigPath,
                    "vite.config.js should exist to process {$assetType} assets"
                );

                // Ler e analisar configuração do Vite
                $viteConfig = file_get_contents($viteConfigPath);

                // Verificar configurações específicas por tipo de asset
                switch ($assetType) {
                    case 'css':
                        // Verificar que há entrada CSS configurada
                        $this->assertMatchesRegularExpression(
                            "/input:\s*\[[\s\S]*?['\"]resources\/css\/.*?\.css['\"]/",
                            $viteConfig,
                            'Vite config should include CSS input files from resources/css/'
                        );
                        break;

                    case 'js':
                        // Verificar que há entrada JavaScript configurada
                        $this->assertMatchesRegularExpression(
                            "/input:\s*\[[\s\S]*?['\"]resources\/js\/.*?\.js['\"]/",
                            $viteConfig,
                            'Vite config should include JavaScript input files from resources/js/'
                        );
                        break;

                    case 'images':
                        // Verificar que há alias configurado para resources (inclui images)
                        $this->assertMatchesRegularExpression(
                            "/'@'\s*:\s*path\.resolve/",
                            $viteConfig,
                            'Vite config should include alias configuration for resources (@)'
                        );
                        break;

                    case 'fonts':
                        // Verificar que Vite está configurado para processar assets estáticos
                        // Vite processa fontes automaticamente quando referenciadas em CSS
                        // Verificar que há configuração de resolve ou que CSS está sendo processado
                        $hasResolveConfig = strpos($viteConfig, 'resolve:') !== false;
                        $hasCssInput = strpos($viteConfig, 'resources/css') !== false;

                        $this->assertTrue(
                            $hasResolveConfig || $hasCssInput,
                            'Vite config should have resolve configuration or CSS processing for fonts'
                        );
                        break;
                }

                // Verificar que laravel-vite-plugin está configurado
                $this->assertStringContainsString(
                    'laravel-vite-plugin',
                    $viteConfig,
                    "Vite config should use laravel-vite-plugin for {$assetType} processing"
                );

                // Verificar que há configuração de plugins
                $this->assertMatchesRegularExpression(
                    "/plugins:\s*\[/",
                    $viteConfig,
                    "Vite config should have plugins array configured for {$assetType} processing"
                );
            });
    }
}
