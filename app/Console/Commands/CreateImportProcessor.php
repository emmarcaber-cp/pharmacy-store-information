<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateImportProcessor extends Command
{
    // The name and signature of the command
    // Provide the nova resource where you will create an import processor
    protected $signature = 'nova-data-sync:import-processor {model}';

    // The command description
    protected $description = 'Create a new Import Processor class';

    // File system instance to handle file creation
    protected Filesystem $files;

    // Inject Filesystem to handle file creation
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    // The command logic
    public function handle()
    {
        $model = $this->getModelArgument();
        $directoryPath = $this->getDirectoryPath($model);
        $filePath = $this->getFilePath($model);

        if ($this->checkFileExists($filePath, $model)) {
            return;
        }

        $this->createDirectoryIfNotExists($directoryPath);
        $this->createProcessorFile($filePath, $model);

        $this->info("\n INFO  {$model}ImportProcessor created successfully at {$filePath}\n");
    }

    // Get the model argument
    protected function getModelArgument(): string
    {
        return $this->argument('model');
    }

    // Get the directory path where the processor file will be created
    protected function getDirectoryPath(string $model): string
    {
        return app_path("Nova/Imports/{$model}Import");
    }

    // Get the full file path of the processor class
    protected function getFilePath(string $model): string
    {
        return app_path("Nova/Imports/{$model}Import/{$model}ImportProcessor.php");
    }

    // Check if the file already exists, and output an error message if it does
    protected function checkFileExists(string $path, string $model): bool
    {
        if ($this->files->exists($path)) {
            $this->error("\n ERROR  {$model}ImportProcessor already exists at {$path}\n");
            return true;
        }
        return false;
    }

    // Create the directory if it doesn't exist
    protected function createDirectoryIfNotExists(string $path): void
    {
        $this->files->ensureDirectoryExists($path);
    }

    // Generate and create the processor file
    protected function createProcessorFile(string $filePath, string $model): void
    {
        $content = $this->generateProcessorContent($model);
        $this->files->put($filePath, $content);
    }

    // Method to generate the class content
    protected function generateProcessorContent(string $model): string
    {
        return <<<EOT
<?php

namespace App\Nova\Imports\\{$model}Import;

use Coreproc\NovaDataSync\Import\Jobs\ImportProcessor;
use Illuminate\Support\Facades\Log;

class {$model}ImportProcessor extends ImportProcessor
{
    public static function expectedHeaders(): array
    {
        return ['field1', 'field2'];
    }

    protected function rules(array \$row, int \$rowIndex): array
    {
        return [
            'field1' => ['required'],
            'field2' => ['required'],
        ];
    }

    protected function process(array \$row, int \$rowIndex): void
    {
        Log::info('processing row ' . \$rowIndex);

        // Logic to process each row in the imported CSV
    }

    public static function chunkSize(): int
    {
        return 100;
    }
}
    
EOT;
    }
}
