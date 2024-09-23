<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateExportAction extends Command
{
    // The name and signature of the command
    // Provide the nova resource where you will create an export action
    protected $signature = 'nova-data-sync:export-action {model}';

    // The command description
    protected $description = 'Create a new Export Action class';

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

        $this->info("\n INFO  {$model}ExportAction created successfully at {$filePath}\n");
    }

    // Get the model argument
    protected function getModelArgument(): string
    {
        return $this->argument('model');
    }

    // Get the directory path where the processor file will be created
    protected function getDirectoryPath(string $model): string
    {
        return app_path("Nova/Exports/{$model}Export");
    }

    // Get the full file path of the processor class
    protected function getFilePath(string $model): string
    {
        return app_path("Nova/Exports/{$model}Export/{$model}ExportAction.php");
    }

    // Check if the file already exists, and output an error message if it does
    protected function checkFileExists(string $path, string $model): bool
    {
        if ($this->files->exists($path)) {
            $this->error("ERROR  Export Action already exists.");
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

namespace App\Nova\Exports\\{$model}Export;

use Laravel\Nova\Fields\ActionFields;
use Illuminate\Support\Collection;
use App\Nova\Exports\\{$model}Export\\{$model}ExportProcessor;
use Coreproc\NovaDataSync\Export\Jobs\ExportProcessor;
use Coreproc\NovaDataSync\Export\Nova\Action\ExportNovaAction;

class {$model}ExportAction extends ExportNovaAction
{
   protected function processor(ActionFields \$fields, Collection \$models): ExportProcessor
    {
        return new {$model}ExportProcessor();
    }
}
EOT;
    }
}
