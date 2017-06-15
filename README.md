# Drupal Code Generator

[![Build Status](https://travis-ci.org/Chi-teck/drupal-code-generator.svg?branch=master)](https://travis-ci.org/Chi-teck/drupal-code-generator)

A command line code generator for Drupal.

## Installation

```shell
# Download the latest stable release of the code generator.
wget https://github.com/Chi-teck/drupal-code-generator/releases/download/1.17.2/dcg.phar

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

# Display Drupal 8 submenu.
dcg d8

# Call generator directly.
dcg d8:plugin:field:widget

# Generate code non interactively.
dcg controller -a '{"name": "Example", "machine_name": "example", "class": "ExampleController"}'
```

## Extending
All custom generators should be placed to _$HOME/.dcg/Command_ directory. The following command will help you to get started with creating own generators.
```bash
# Create custom DCG command.
dcg dcg-command -d$HOME/.dcg/Command
```

## License
GNU General Public License, version 2
