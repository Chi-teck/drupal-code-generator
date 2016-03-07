# Development notes

## Setting up development copy of the project

```shell
# Clone the project.
git clone https://github.com/Chi-teck/drupal-code-generator

# Change working directory.
cd drupal-code-generator

# Switch to development branch.
git checkout development

# Install dependencies.
composer install

# Run generator.
bin/dcg

```

To make _dcg_ avaible in any system location append this line to your _.bashrc_ file:
`export dcg=/path/to/dcg/bin/dcg`
Then after you have logged out and in the _dcg_ will be accessible through _$dcg_ global shell variable.

## Testing
We stick to PHPUnit 4 because PHP 5.5 is not supported by PHPUnit 5. You can
install it as follows:
```shell
composer global require "phpunit/phpunit=4.*"
```
Make sure you have _~/.composer/vendor/bin_ in your PATH:
```shell
export PATH=~/.composer/vendor/bin:$PATH
```

The following alias helps you run tests form any location:
```
alias dcg-test="(cd /path/to/drupal-code-generator && phpunit && phpcs --standard=./rulset.xml)"
```

## Creating a Phar

1. Install [Box 2](https://github.com/box-project/box2).
2. Navigate to the directory where Drupal Code Generator was installed.
3. Run the following command: `box build` (use `-v` option if you need verbose output).
4. Test the generated archive: `php dcg.phar --version`.


