# Development notes

For bash you can append this line to $HOME/.bashrc file to easily run not
compiled dcg:
`export dcg=/var/www/dcg/bin/dcg`

## Testing
We stick with PHPUnit 4 because PHPUnit 5 does not support PHP 5.5. You can
install it as follows: `composer global require "phpunit/phpunit=4.*"`. Make
sure you have ~/.composer/vendor/bin/ in your path.
`export PATH=~/.composer/vendor/bin:$PATH`


alias dcg-test="(cd /var/www/dcg && phpunit && phpcs --standard=./rulset.xml)"

