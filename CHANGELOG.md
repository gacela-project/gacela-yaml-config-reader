# Changelog

## Unreleased

**Breaking for consumers.** This release moves the package onto Gacela 2.x and drops every PHP version below 8.3.

Before it, the package was **unsatisfiable with Gacela 2.x**: its own constraint was `php: ^8.0, <8.3`, which excludes the 8.3 Gacela 2.x requires, while `gacela-project/gacela: *` claimed to accept every version of the framework ever published. Composer could only resolve the pair by picking a Gacela 1.x — silently, with nothing said. Both halves are fixed here.

### Changed

- **Requires `gacela-project/gacela: ^2.4`** (was `*`). A wildcard is not a compatibility statement; it accepted 0.x, 1.x and 2.x alike and was never tested against most of them
- **Requires PHP `>=8.3`** (was `^8.0, <8.3`). The upper bound is what made the package impossible to install beside Gacela 2.x. `config.platform.php` moved to `8.3.16` to match
- **Widened `symfony/yaml` to `^6.4 || ^7.0 || ^8.0`** (was `^5.4`). Only `Yaml::parseFile()` is used and it is unchanged across all three. Symfony 5.4 is dropped rather than kept: it is out of support, and the new PHP floor puts every application that could take this release on a later major anyway
- `YamlConfigReader` allocates `ReadYamlConfigEvent` only when a listener is registered for it, guarding the dispatch with `shouldDispatch()` as Gacela's own `PhpConfigReader` does. No observable change: an unlistened event was dispatched into nothing before

Nothing changed in the public surface. `YamlConfigReader::class` is registered through `addAppConfig()` exactly as before, `ReadYamlConfigEvent` keeps its constructor, `absolutePath()` and `toString()` output, and no code in a consuming application needs to change beyond its own Gacela and PHP bumps.

### Fixed

- The `tests` CI job ran `phpunit --testsuite integration`, a suite this package has never declared, so it exercised nothing. It runs `unit,feature` now — the suites that actually boot Gacela and read a `.yaml`/`.yml`

### Development

- PHPUnit `^11.5 || ^12.0`, PHPStan `^2.0`, Psalm `^6.16`, Infection `^0.34`, php-cs-fixer `^3.95`; `phpunit.xml` migrated to the current schema and set to fail on warnings, notices and deprecations
- Mutation testing still passes its 100% MSI gate on the new toolchain
- CI runs the suite on PHP 8.3, 8.4 and 8.5, and the static analysis and mutation jobs on 8.3
- `composer test` added as an alias of `test-all`, matching `gacela-env-config-reader`
