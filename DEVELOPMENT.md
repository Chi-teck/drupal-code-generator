# Development notes

## Setting up development copy of the project

```shell
# Clone the project.
git clone https://github.com/Chi-teck/drupal-code-generator

# Change working directory.
cd drupal-code-generator

# Install dependencies.
composer install
```

## Testing

```shell
# Run unit tests.
/path/to/drupal-code-generator/scripts/unit-tests.sh

# Run functional tests.
/path/to/drupal-code-generator/scripts/functional-tests.sh

# Run tests for generated code.
/path/to/drupal-code-generator/scripts/sut-tests.sh
```

### SUT testing

In order to run this type of tests you need to install [Symfony CLI][Symfony CLI download].

[Symfony CLI download]: https://symfony.com/download
