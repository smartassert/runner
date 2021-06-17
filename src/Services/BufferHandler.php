<?php

declare(strict_types=1);

namespace webignition\BasilCliRunner\Services;

class BufferHandler
{
    private const YAML_DOCUMENT_SEPARATOR = '---';
    private const YAML_DOCUMENT_SEPARATOR_LENGTH = 3;

    private bool $hasYamlOutputStarted = false;

    public function handle(string $buffer): ?string
    {
        if (false === $this->hasYamlOutputStarted && strlen($buffer) >= self::YAML_DOCUMENT_SEPARATOR_LENGTH) {
            $this->hasYamlOutputStarted = $this->bufferStartsWithYamlDocumentSeparator($buffer);
        }

        if (true === $this->hasYamlOutputStarted) {
            return $buffer;
        }

        return null;
    }

    private function bufferStartsWithYamlDocumentSeparator(string $buffer): bool
    {
        if (self::YAML_DOCUMENT_SEPARATOR === $buffer) {
            return true;
        }

        return str_starts_with($buffer, self::YAML_DOCUMENT_SEPARATOR);
    }
}
