<?php

declare(strict_types=1);

namespace Gacela\Framework\Config\ConfigReader;

use Gacela\Framework\Config\ConfigReaderInterface;
use Symfony\Component\Yaml\Yaml;

final class YamlConfigReader implements ConfigReaderInterface
{
    /**
     * @return array<string,mixed>
     */
    public function read(string $absolutePath): array
    {
        if (!$this->canRead($absolutePath)) {
            return [];
        }

        /** @var null|array<string,mixed> $content */
        $content = Yaml::parseFile($absolutePath);

        return is_array($content) ? $content : [];
    }

    private function canRead(string $absolutePath): bool
    {
        $extension = pathinfo($absolutePath, PATHINFO_EXTENSION);

        return ('yaml' === $extension || 'yml' === $extension)
            && file_exists($absolutePath);
    }
}
