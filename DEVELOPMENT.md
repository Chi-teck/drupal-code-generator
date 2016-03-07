# Development notes

## Setting up development copy of the genetator

```shell
# Clone the project.
git clone https://github.com/Chi-teck/drupal-code-generator

# Switch to develop branch.
git checkout develop

# Change working directory.
cd drupal-code-generator

# Install dependencies.
composer install

# Run generator.
bin/dcg

```

To make _dcg_ avaible in any system location append this line to your _.bashrc_ file:
`export dcg=/path/to/dcg/bin/dcg`
Then after you have logged out and in the _dcg_ will be accessible through _$dcg_ variable.

## Testing
We stick with PHPUnit 4 because PHPUnit 5 does not support PHP 5.5. You can
install it as follows:
```shell
composer global require "phpunit/phpunit=4.*"
```
Make sure you have ~/.composer/vendor/bin in your path:
```shell
export PATH=~/.composer/vendor/bin:$PATH
```

The following alias helps you to run tests form any location:
```
alias dcg-test="(cd /path/to/dcg && phpunit && phpcs --standard=./rulset.xml)"
```

## Creating a Phar

1. Install [Box 2 application](https://github.com/box-project/box2).
2. Navigate to the directory where Drupal code generator was installed.
3. Run the following command: `box build` (use `-v` option if you need verbose output).
4. Test the archive: `php dcg.phar --verision`.


