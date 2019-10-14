# Drupal Code Generator

[![Build Status](https://travis-ci.org/Chi-teck/drupal-code-generator.svg?branch=master)](https://travis-ci.org/Chi-teck/drupal-code-generator)

Un generador de linea de comando para Drupal.

## Instalación

1. Baja version mas reciente [stable release](https://github.com/Chi-teck/drupal-code-generator/releases/latest) del generador de código.
2. Has el archivo ejecutable.
3. Mueve el archivo a un directorio que sea parte de tu `PATH`.

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
# Display navigation.
dcg

# Call generator directly.
dcg plugin:field:widget

# Generate code non-interactively.
dcg config-form -a Example -a example -a SettingsForm -a No
```
## Extending
All custom generators should be placed to _$HOME/.dcg_ directory. The following command can help you to get started with creating own generators.
```bash
# Create custom DCG command.
dcg dcg-command -d $HOME/.dcg
```
## License
GNU General Public License, version 2 or later.
