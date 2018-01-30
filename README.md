# Drupal Code Generator

[![Build Status](https://travis-ci.org/Chi-teck/drupal-code-generator.svg?branch=master)](https://travis-ci.org/Chi-teck/drupal-code-generator)

A command line code generator for Drupal.

## Installation

1. Download the latest [stable release](https://github.com/Chi-teck/drupal-code-generator/releases/latest) of the code generator.
2. Make the file executable.
3. Move it to a directory that is part of your `PATH`.

```shell
release_url=https://api.github.com/repos/chi-teck/drupal-code-generator/releases/latest
wget $(wget -qO- $release_url | awk -F'"' '/browser_download_url/ { print $4 }')
chmod +x dcg.phar
sudo mv dcg.phar /usr/local/bin/dcg
dcg --version
```
Installation using Composer is also supported.

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
dcg twig-extension -a '{"name": "Example", "machine_name": "example", "class": "ExampleTwigExtension"}'
```
## Extending
All custom generators should be placed to _$HOME/.dcg/Command_ directory. The following command will help you to get started with creating own generators.
```bash
# Create custom DCG command.
dcg dcg-command -d $HOME/.dcg/Command
```
## License
GNU General Public License, version 2 or later.
