<?php

namespace Database\Seeders;

use App\Http\Controllers\Api\ApiController;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Output\ConsoleOutput;

class PermissionSeeder extends Seeder
{
    /**
     * @var array
     */
    private static array $apiV1ControllersBasePath;

    /**
     * @var array
     */
    private array $controllers;

    /**
     * @var array
     */
    private array $methods = [];

    /**
     * @var ConsoleOutput
     */
    private ConsoleOutput $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::$apiV1ControllersBasePath = config('controller_path');
        foreach (self::$apiV1ControllersBasePath as $folder => $path) {
            $this->extracted($path, $folder);
        }
        foreach ($this->controllers as $controller) {
            $className = $this->getCurrentClassNameByNamespaceFromDirectoryPath($controller);
            $this->methods[$className] = $this->getClassRequiredForSetPermissionMethods($className);
        }

        $this->createPermissions();
    }

    /**
     * @param string $classDirectoryPath
     * @return string
     */
    protected function getCurrentClassNameByNamespaceFromDirectoryPath(string $classDirectoryPath): string
    {
        return
            str_replace('/', '\\',
                str_replace('.php', '',
                    str_replace('./app', 'App', $classDirectoryPath)
                )
            );
    }

    /**
     * @param string $classNameByNamespace
     * @return string[]
     */
    protected function getClassRequiredForSetPermissionMethods(string $classNameByNamespace): array
    {
        $classParentMethods = get_class_methods(ApiController::class);
        $classAllMethods = get_class_methods($classNameByNamespace);
        return array_diff($classAllMethods, $classParentMethods);
    }

    private function createPermissions(): void
    {
        foreach ($this->methods as $controller => $methods) {
            $this->createNewPermissionRow($methods, $controller);
        }
    }

    /**
     * @param string $controller
     * @param string $method
     * @return bool
     */
    private function checkPermissionAlreadyExist(string $controller, string $method): bool
    {
        return Permission::query()
            ->where('controller', $controller)
            ->where('method', $method)
            ->exists();
    }

    /**
     * @param mixed $path
     * @param int|string $folder
     * @return void
     */
    public function extracted(mixed $path, int|string $folder): void
    {
        $scanResults = scandir($path);
        foreach ($scanResults as $key => $scanResult) {
            if (str_contains($scanResult, 'Controller.php')) {
                $this->controllers[$folder . $key] = $path . '/' . $scanResult;
            }
        }
    }

    /**
     * @param mixed $methods
     * @param int|string $controller
     * @return void
     */
    public function createNewPermissionRow(mixed $methods, int|string $controller): void
    {
        foreach ($methods as $method) {
            if ($this->checkPermissionAlreadyExist($controller, $method)) {
                $this->output->writeln($controller . ' ' . $method . ' ' . ' already exist' . PHP_EOL);
            } else {
                $this->output->writeln($controller . ' ' . $method . ' ' . ' creating');
                Permission::query()->updateOrCreate([
                    'controller' => $controller,
                    'method'     => $method
                ]);
                $this->output->writeln($controller . ' ' . $method . ' ' . ' created' . PHP_EOL);
            }
        }
    }
}
