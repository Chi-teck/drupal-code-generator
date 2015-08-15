# Drupal Code Generator

[![Build Status](https://travis-ci.org/Chi-teck/drupal-code-generator.svg?branch=master)](https://travis-ci.org/Chi-teck/drupal-code-generator)

A command line code generator for Drupal.

## Installation

```shell
# Download the latest stable release of the code generator.
wget https://github.com/Chi-teck/drupal-code-generator/releases/download/1.3.0/dcg.phar

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

# Display Drupal 7 submenu.
dcg d7

# Call generator directly.
dcg d7:component:ctools-plugin:content-type
```

## Extending
Coping DCG core templates into _$HOME/.dcg/Resources/templates_ directory  will automatically override them. All custom generators should be placed under _$HOME/.dcg/Commands_ directory.
```bash
# Create custom DCG command.
dcg dcg-command -d~/.dcg/Commands
```

## Extending
Coping DCG core templates into _$HOME/.dcg/Resources/templates_ directory  will automatically override them. All custom generators should be placed under _$HOME/.dcg/Commands_ directory. The following command will help you to create own DCG generator: `dcg dcg-command -d~/.dcg/Commands`.


## License
GNU General Public License, version 2

## Other tools for Drupal code generation

- [Module Builder](https://www.drupal.org/project/module_builder)
- [Drupal Console](https://github.com/hechoendrupal/DrupalAppConsole)
- [PhpStorm file templates for Drupal development](https://github.com/Chi-teck/PhpStorm-Drupal-Templates)
