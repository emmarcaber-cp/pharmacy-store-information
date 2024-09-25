<?php

namespace App\Exceptions;

use RuntimeException;

class SaveRecordException extends RuntimeException
{
    /**
     * SaveRecordException constructor.
     *
     * @param string $message
     * @param mixed $model
     * @param \Throwable|null $previous
     */
    public function __construct(protected mixed $model = null)
    {
        parent::__construct("SaveRecordException: Failed to Save Record." . json_encode($this->context()));
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
