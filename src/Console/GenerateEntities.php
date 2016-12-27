<?php


namespace Joselfonseca\LaravelApiTools\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateEntities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:entity {resource : name of the resource in singular}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate base scaffolding for an entity';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Generating files');
        $this->generateDirectories();
        $resource = [
            'singular_key' => strtolower($this->argument('resource')),
            'resource_key' => strtolower(str_plural($this->argument('resource')))
        ];
        $this->generateModel($resource);
        $this->generateService($resource);
        $this->generateContract($resource);
        $this->generateTransformer($resource);
        $this->generateController($resource);
    }

    /**
     * @param $resource
     */
    protected function generateModel($resource)
    {
        $namespace = studly_case($resource['resource_key']);
        if(!is_dir(app_path('Entities/'.$namespace))){
            mkdir(app_path('Entities/'.$namespace));
        }
        $modelStub = $this->files->get(__DIR__ . '/../../stubs/model.stub');
        $modelStub = str_replace('DummyClass', studly_case($resource['singular_key']), $modelStub);
        $modelStub = str_replace('StResourceKey', $namespace, $modelStub);
        if (!$this->files->exists(app_path('Entities/'.$namespace. '/' . studly_case($resource['singular_key']) . '.php'))) {
            $this->files->put(app_path('Entities/'.$namespace. '/' . studly_case($resource['singular_key']) . '.php'), $modelStub);
        }
    }

    /**
     * @param $resource
     */
    protected function generateContract($resource)
    {
        $namespace = studly_case($resource['resource_key']);
        if(!is_dir(app_path('Contracts/'.$namespace))){
            mkdir(app_path('Contracts/'.$namespace));
        }
        $serviceName = studly_case($resource['resource_key']).'Service';
        $contractStub = $this->files->get(__DIR__ . '/../../stubs/contract.stub');
        $contractStub = str_replace('DummyClass', $serviceName.'Contract', $contractStub);
        $contractStub = str_replace('DummyModel', studly_case($resource['singular_key']), $contractStub);
        $contractStub = str_replace('StResourceKey', $namespace, $contractStub);
        if (!$this->files->exists(app_path('Contracts/'.$namespace. '/' . $serviceName.'Contract' . '.php'))) {
            $this->files->put(app_path('Contracts/'.$namespace. '/' . $serviceName.'Contract' . '.php'), $contractStub);
        }
    }

    /**
     * @param $resource
     */
    protected function generateTransformer($resource)
    {
        $namespace = studly_case($resource['resource_key']);
        if(!is_dir(app_path('Transformers/'.$namespace))){
            mkdir(app_path('Transformers/'.$namespace));
        }
        $transformerName = studly_case($resource['resource_key']).'Transformer';
        $transformerStub = $this->files->get(__DIR__ . '/../../stubs/transformer.stub');
        $transformerStub = str_replace('DummyClass', $transformerName, $transformerStub);
        $transformerStub = str_replace('DummyModel', studly_case($resource['singular_key']), $transformerStub);
        $transformerStub = str_replace('StResourceKey', $namespace, $transformerStub);
        if (!$this->files->exists(app_path('Transformers/'.$namespace. '/' . $transformerName . '.php'))) {
            $this->files->put(app_path('Transformers/'.$namespace. '/' . $transformerName . '.php'), $transformerStub);
        }
    }

    /**
     * @param $resource
     */
    protected function generateService($resource)
    {
        $namespace = studly_case($resource['resource_key']);
        if(!is_dir(app_path('Services/'.$namespace))){
            mkdir(app_path('Services/'.$namespace));
        }
        $serviceStub = $this->files->get(__DIR__ . '/../../stubs/service.stub');
        $serviceName = studly_case($resource['resource_key']).'Service';
        $serviceStub = str_replace('DummyClass', $serviceName, $serviceStub);
        $serviceStub = str_replace('DummyModel', studly_case($resource['singular_key']), $serviceStub);
        $serviceStub = str_replace('DummyTransformer', studly_case($resource['singular_key']).'Transformer', $serviceStub);
        $serviceStub = str_replace('DummyContract', $serviceName.'Contract', $serviceStub);
        $serviceStub = str_replace('DummyResourceKey', $resource['resource_key'], $serviceStub);
        $serviceStub = str_replace('StResourceKey', $namespace, $serviceStub);
        if (!$this->files->exists(app_path('Services/'.$namespace. '/' . $serviceName . '.php'))) {
            $this->files->put(app_path('Services/'.$namespace. '/' . $serviceName . '.php'), $serviceStub);
        }
    }

    /**
     * @param $resource
     */
    protected function generateController($resource)
    {
        $namespace = studly_case($resource['resource_key']);
        if(!is_dir(app_path('Http/Controllers/'.$namespace))){
            mkdir(app_path('Http/Controllers/'.$namespace));
        }
        $serviceName = studly_case($resource['resource_key']).'Service';
        $controllerStub = $this->files->get(__DIR__ . '/../../stubs/controller.stub');
        $controllerName = studly_case($resource['resource_key']).'Controller';
        $controllerStub = str_replace('Contract', $serviceName.'Contract', $controllerStub);
        $controllerStub = str_replace('StResourceKey', $namespace, $controllerStub);
        if (!$this->files->exists(app_path('Http/Controllers/'.$namespace. '/' . $controllerName . '.php'))) {
            $this->files->put(app_path('Http/Controllers/'.$namespace. '/' . $controllerName . '.php'), $controllerStub);
        }
    }

    /**
     *
     */
    protected function generateDirectories()
    {
        if(!is_dir(app_path('Entities/'))){
            mkdir(app_path('Entities/'));
        }
        if(!is_dir(app_path('Contracts/'))){
            mkdir(app_path('Contracts/'));
        }
        if(!is_dir(app_path('Transformers/'))){
            mkdir(app_path('Transformers/'));
        }
        if(!is_dir(app_path('Services/'))){
            mkdir(app_path('Services/'));
        }
    }
}
