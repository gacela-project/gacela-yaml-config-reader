<?php

declare(strict_types=1);

namespace GacelaTest\Integration\Framework\UsingYamlConfig;

use Gacela\Framework\Config\ConfigReader\YamlConfigReader;
use Gacela\Framework\Gacela;
use PHPUnit\Framework\TestCase;

final class IntegrationTest extends TestCase
{
    public function setUp(): void
    {
        Gacela::bootstrap(__DIR__, [], [
            'yaml' => new YamlConfigReader(),
            'yml' => new YamlConfigReader(),
        ]);
    }

    public function test_read_config_values_yaml_yml(): void
    {
        $facade = new LocalConfig\Facade();

        self::assertSame(
            [
                'config_yml' => 'YML_CONFIG',
                'config_yaml' => 'YAML_CONFIG',
                'override' => 'YAML_OVERRIDE',
            ],
            $facade->doSomething()
        );
    }
}
