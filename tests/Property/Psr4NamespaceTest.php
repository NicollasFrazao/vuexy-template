<?php

namespace Tests\Property;

use Eris\Generator;
use Eris\TestTrait;
use Tests\PropertyTestCase;

class Psr4NamespaceTest extends PropertyTestCase
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
     * Feature: laravel-bootstrap-templates, Property 7: Namespaces Seguem PSR-4
     *
     * **Validates: Requirements 10.2**
     *
     * Para qualquer classe PHP no projeto (controllers, models, middlewares), o namespace
     * declarado deve corresponder exatamente à estrutura de diretórios relativa ao diretório
     * app/, seguindo o padrão PSR-4 (ex: App\Http\Controllers para app/Http/Controllers/).
     *
     * @test
     */
    public function any_php_class_in_app_follows_psr4_namespace()
    {
        $phpFiles = $this->collectPhpFiles(app_path());

        $this->assertNotEmpty(
            $phpFiles,
            'Should find PHP files in app/ directory'
        );

        $this->forAll(
            Generator\elements($phpFiles)
        )
            ->then(function (string $filePath) {
                $namespace = $this->extractNamespace($filePath);

                // Skip files that don't declare a namespace
                if ($namespace === null) {
                    return;
                }

                $expectedNamespace = $this->deriveExpectedNamespace($filePath);

                $this->assertEquals(
                    $expectedNamespace,
                    $namespace,
                    "File '{$filePath}' declares namespace '{$namespace}' but PSR-4 expects '{$expectedNamespace}'"
                );
            });
    }

    /**
     * Recursively collect all PHP files under the given directory.
     *
     * @return string[]
     */
    private function collectPhpFiles(string $directory): array
    {
        $files = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getRealPath();
            }
        }

        return $files;
    }

    /**
     * Extract the declared namespace from a PHP file.
     * Returns null if no namespace declaration is found.
     */
    private function extractNamespace(string $filePath): ?string
    {
        $content = file_get_contents($filePath);

        if ($content === false) {
            return null;
        }

        if (preg_match('/^\s*namespace\s+([A-Za-z0-9_\\\\]+)\s*;/m', $content, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Derive the expected PSR-4 namespace for a file based on its path.
     *
     * PSR-4 mapping: App\ → app/
     * e.g. app/Http/Controllers/DashboardController.php → App\Http\Controllers
     *
     * @param  string  $filePath  Absolute path to the PHP file
     */
    private function deriveExpectedNamespace(string $filePath): string
    {
        $appPath = realpath(app_path());

        // Get the path relative to app/
        $relativePath = ltrim(str_replace($appPath, '', $filePath), DIRECTORY_SEPARATOR);

        // Remove the filename (keep only the directory part)
        $relativeDir = dirname($relativePath);

        if ($relativeDir === '.') {
            // File is directly in app/ → namespace is App
            return 'App';
        }

        // Convert directory separators to namespace separators
        $namespaceSuffix = str_replace(DIRECTORY_SEPARATOR, '\\', $relativeDir);

        return 'App\\'.$namespaceSuffix;
    }
}
