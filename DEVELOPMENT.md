# Development notes

## Setting up development copy of the project

```shell
# Clone the project.
git clone https://github.com/Chi-teck/drupal-code-generator

# Change working directory.
cd drupal-code-generator

# Install dependencies.
composer install

# Run generator.
bin/dcg

```

To make _dcg_ available in any system location append this line to your _.bashrc_ file:
`alias dcg-dev=/path/to/to/drupal-code-generator/bin/dcg`
Then after you have logged out and in the _dcg_ development version will be accessible through _dcg-dev_ command.

## Testing

### 
```sh
# Test code generator.
/path/to/drupal-code-generator/scripts/run-dcg-tests.sh

# Test generated code.
/path/to/drupal-code-generator/scripts/run-sut-tests.sh
```

## Building PHAR executable

1. Install [Box 2](https://github.com/box-project/box2).
2. Run `scripts/buld.sh` script.
3. Test the generated archive: `php dcg.phar --version`.
