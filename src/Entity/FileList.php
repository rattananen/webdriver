<?php

namespace Rattananen\Webdriver\Entity;

class FileList implements \ArrayAccess, \Countable, \Stringable
{
    /**
     * @param string[] $files file paths
     */
    public function __construct(
        private array $files = []
    ) {
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->files[] = $value;
        } else {
            $this->files[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->files[$offset]);
    }

    public function offsetUnset($offset): void
    {
        unset($this->files[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return isset($this->files[$offset]) ? $this->files[$offset] : null;
    }

    public function count(): int
    {
        return count($this->files);
    }

    public function __toString(): string
    {
        return implode("\n", array_map(fn ($f) => realpath($f), $this->files));
    }
}
