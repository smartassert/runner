<?php

declare(strict_types=1);

namespace webignition\BasilCliRunner\Model\ResultPrinter\DataSet;

use webignition\BasilCliRunner\Model\ResultPrinter\Comment;
use webignition\BasilCliRunner\Model\ResultPrinter\RenderableInterface;

class KeyValue implements RenderableInterface
{
    private Key $key;
    private Comment $value;

    public function __construct(string $key, string $value)
    {
        $this->key = new Key($key);
        $this->value = new Comment($value);
    }

    public function render(): string
    {
        return sprintf(
            '%s: %s',
            $this->key->render(),
            $this->value->render()
        );
    }
}
