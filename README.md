# Drupal Code Generator

[![Tests](https://github.com/Chi-teck/drupal-code-generator/workflows/Tests/badge.svg)](https://github.com/Chi-teck/drupal-code-generator/actions?query=workflow%3ATests)
[![Total Downloads](https://poser.pugx.org/chi-teck/drupal-code-generator/downloads)](//packagist.org/packages/chi-teck/drupal-code-generator)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg?style=flat)](https://php.net/)

A command line code generator for Drupal.

## Installation

1. Download the latest [stable release](https://github.com/Chi-teck/drupal-code-generator/releases) of the code generator.
2. Make the file executable.
3. Move it to a directory that is part of your `PATH`.

Installation using Composer is also supported.

## Upgrade
Simply repeat installation commands.

## Usage
```shell
# Display navigation.
dcg

# Call generator directly.
dcg plugin:field:widget

# Generate code non-interactively.
dcg config-form -a Example -a example -a SettingsForm -a No
```

## Compatibility
DCG|PHP|Symfony|Twig|Drupal|Drush
:-:|:-:|:-:|:-:|:-:|:-:
1|7.1+|3, 4|1, 2|7, 8|9, 10
2|7.4+|4, 5|2, 3|7, 9|11+

## License
GNU General Public License, version 2 or later.
