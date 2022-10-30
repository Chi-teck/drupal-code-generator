<?php /** @noinspection ALL */

namespace PHPSTORM_META {
  registerArgumentsSet('role_names',
    'anonymous',
    'authenticated',
    'content_editor',
    'administrator',
  );
  expectedArguments(\Drupal\user\UserInterface::hasRole(), 0, argumentsSet('role_names'));
  expectedArguments(\Drupal\user\UserInterface::addRole(), 0, argumentsSet('role_names'));
  expectedArguments(\Drupal\user\UserInterface::removeRole(), 0, argumentsSet('role_names'));
}
