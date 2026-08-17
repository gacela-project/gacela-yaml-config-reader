<?php

declare(strict_types=1);

namespace Gacela\Framework\Config\ConfigReader;

use Gacela\Framework\Config\ConfigReaderInterface;
use Gacela\Framework\Event\ConfigReader\ReadYamlConfigEvent;
use Gacela\Framework\Event\Dispatcher\EventDispatchingCapabilities;
use Symfony\Component\Yaml\Yaml;

use function is_array;

use const PATHINFO_EXTENSION;

final class YamlConfigReader implements ConfigReaderInterface
{
    use EventDispatchingCapabilities;

    /**
     * @return array<string,mixed>
     */
    public function read(string $absolutePath): array
    {
        if (!$this->canRead($absolutePath)) {
            return [];
        }

        if (self::shouldDispatch(ReadYamlConfigEvent::class)) {
            self::dispatchEvent(new ReadYamlConfigEvent($absolutePath));
        }

        /** @var null|array<string,mixed> $content */
        $content = Yaml::parseFile($absolutePath);

        return is_array($content) ? $content : [];
    }

    private function canRead(string $absolutePath): bool
    {
        $extension = pathinfo($absolutePath, PATHINFO_EXTENSION);

        return ($extension === 'yaml' || $extension === 'yml')
            && file_exists($absolutePath);
    }
}
