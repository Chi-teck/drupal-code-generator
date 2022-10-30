<?php declare(strict_types = 1);

namespace PHPSTORM_META {

  registerArgumentsSet('roles',
    'anonymous',
    'authenticated',
    'content_editor',
    'administrator',
  );
  expectedArguments(\Drupal\user\UserInterface::hasRole(), 0, argumentsSet('roles'));
  expectedArguments(\Drupal\user\UserInterface::addRole(), 0, argumentsSet('roles'));
  expectedArguments(\Drupal\user\UserInterface::removeRole(), 0, argumentsSet('roles'));

}
