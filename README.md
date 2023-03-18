# Drupal Code Generator

[![Tests](https://github.com/Chi-teck/drupal-code-generator/workflows/Tests/badge.svg)](https://github.com/Chi-teck/drupal-code-generator/actions?query=workflow%3ATests)
[![Total Downloads](https://poser.pugx.org/chi-teck/drupal-code-generator/downloads)](//packagist.org/packages/chi-teck/drupal-code-generator)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.1-8892BF.svg?style=flat)](https://php.net/)

A command line code generator for Drupal.

## Installation
```
composer require chi-teck/drupal-code-generator --dev
```

Optionally, generate shell completions for DCG executable.
```
./vendor/bin/dcg completion bash >> ~/.bash_completion
```

## Usage
```shell
# Display navigation.
./vendor/bin/dcg

# Call generator directly.
./vendor/bin/dcg plugin:field:widget

# Generate code non-interactively.
./vendor/bin/dcg config-form -a Example -a example -a SettingsForm -a No
```

## Compatibility
DCG|PHP|Symfony|Twig|Drupal|Drush
:-:|:-:|:-:|:-:|:-:|:-:
1|7.1 - 7.4|3, 4|1, 2|7, 8|9, 10
2|7.4+|4, 5|2, 3|7, 9|11
3|8.1+|6|3|10|12

## License
GNU General Public License, version 2 or later.
