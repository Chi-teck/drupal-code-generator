# Drupal Code Generator

[![Build Status](https://travis-ci.org/Chi-teck/drupal-code-generator.svg?branch=master)](https://travis-ci.org/Chi-teck/drupal-code-generator)

A command line code generator for Drupal.

## Installation

```shell
# Download the latest stable release of the code generator.
wget https://github.com/Chi-teck/drupal-code-generator/releases/download/1.2.1/dcg.phar

# Make the file executable.
chmod +x dcg.phar

# Make the generator available to all users as a systemwide executable.
sudo mv dcg.phar /usr/local/bin/dcg
```

## Upgrade
Simply repeat installation commands.

## Usage
```shell
# Display main menu.
dcg

# Display submenu.
dcg generate:d7

# Call generator directly.
dcg generate:d7:component:ctools-plugin:content-type
```

## License
GNU General Public License, version 2

## Other Drupal tools for code generation

- [Module Builder](https://www.drupal.org/project/module_builder)
- [Drupal Console](https://github.com/hechoendrupal/DrupalAppConsole)
