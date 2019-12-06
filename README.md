# Drupal Code Generator

[![Build Status](https://travis-ci.org/Chi-teck/drupal-code-generator.svg?branch=master)](https://travis-ci.org/Chi-teck/drupal-code-generator)

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

## License
GNU General Public License, version 2 or later.
