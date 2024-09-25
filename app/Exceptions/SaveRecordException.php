<?php

namespace App\Exceptions;

use RuntimeException;

class SaveRecordException extends RuntimeException
{
    public function __construct(protected mixed $model)
    {
        parent::__construct('Failed to save record');
    }

    public function render(): void
    {
        abort(500, $this->getMessage());
    }

    public function context(): array
    {
        return [
            'model' => $this->model,
            'attributes' => $this->model->getAttributes(),
        ];
    }
}
