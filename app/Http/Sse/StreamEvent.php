<?php

namespace App\Http\Sse;

class StreamEvent
{
    public function __construct(
        public string $type,
        public mixed $data
    ) {}

    public function emit(): void
    {
        // todo: investigate if type can be echoed as event:
        if ($this->type === 'error') {
            echo "event: error\n";
        }
        echo 'data: '.json_encode($this->toArray())."\n\n";

        if (ob_get_level() > 0) {
            ob_flush();
        }

        flush();
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'data' => $this->data,
        ];
    }

    public static function token(string $token): self
    {
        return new self('token', $token);
    }
}
