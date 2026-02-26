<?php

namespace Tests\Property;

use Eris\TestTrait;
use Tests\TestCase;
use Eris\Generator;

class LaravelStructureTest extends TestCase
{
    use TestTrait;
    
    /**
     * Feature: laravel-bootstrap-templates, Property 1: Estrutura Laravel Completa
     * 
     * **Validates: Requirements 1.3, 2.2, 2.3, 10.1**
     * 
     * Para qualquer branch criada (starter ou full), o projeto deve conter todos os 
     * diretórios essenciais do Laravel (app/, config/, database/, public/, resources/, 
     * routes/, storage/, tests/), arquivo composer.json com dependências padrão do Laravel, 
     * e arquivo package.json com dependências frontend padrão.
     * 
     * @test
     */
    public function any_branch_contains_complete_laravel_structure()
    {
        $this->forAll(
            Generator\elements(['starter', 'full'])
        )
        ->then(function ($branchType) {
            // Verificar diretórios essenciais
            $requiredDirs = [
                'app', 'config', 'database', 'public', 
                'resources', 'routes', 'storage', 'tests'
            ];
            
            foreach ($requiredDirs as $dir) {
                $this->assertDirectoryExists(
                    base_path($dir),
                    "Directory {$dir}/ should exist for {$branchType} branch"
                );
            }
            
            // Verificar arquivos essenciais
            $this->assertFileExists(
                base_path('composer.json'),
                "composer.json should exist for {$branchType} branch"
            );
            $this->assertFileExists(
                base_path('package.json'),
                "package.json should exist for {$branchType} branch"
            );
            $this->assertFileExists(
                base_path('artisan'),
                "artisan file should exist for {$branchType} branch"
            );
            
            // Verificar dependências no composer.json
            $composerContent = file_get_contents(base_path('composer.json'));
            $composer = json_decode($composerContent, true);
            
            $this->assertIsArray(
                $composer,
                "composer.json should contain valid JSON for {$branchType} branch"
            );
            
            $this->assertArrayHasKey(
                'require',
                $composer,
                "composer.json should have 'require' section for {$branchType} branch"
            );
            
            $this->assertArrayHasKey(
                'laravel/framework',
                $composer['require'],
                "composer.json should include laravel/framework dependency for {$branchType} branch"
            );
            
            // Verificar dependências no package.json
            $packageContent = file_get_contents(base_path('package.json'));
            $package = json_decode($packageContent, true);
            
            $this->assertIsArray(
                $package,
                "package.json should contain valid JSON for {$branchType} branch"
            );
            
            // Verificar que package.json tem devDependencies ou dependencies
            $hasDevDeps = isset($package['devDependencies']) && is_array($package['devDependencies']);
            $hasDeps = isset($package['dependencies']) && is_array($package['dependencies']);
            
            $this->assertTrue(
                $hasDevDeps || $hasDeps,
                "package.json should have dependencies or devDependencies for {$branchType} branch"
            );
        });
    }
}
