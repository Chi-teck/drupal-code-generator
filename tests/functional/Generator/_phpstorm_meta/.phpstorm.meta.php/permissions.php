<?php declare(strict_types = 1);

namespace PHPSTORM_META {

  registerArgumentsSet('permissions',
    'access administration pages',
    'access announcements',
    'access block library',
    'access comments',
    'access content',
    'access content overview',
    'access contextual links',
    'access files overview',
    'access help pages',
    'access shortcuts',
    'access site in maintenance mode',
    'access site reports',
    'access site-wide contact form',
    'access taxonomy overview',
    'access toolbar',
    'access user contact forms',
    'access user profiles',
    'administer account settings',
    'administer block content',
    'administer block types',
    'administer block_content display',
    'administer block_content fields',
    'administer block_content form display',
    'administer blocks',
    'administer comment display',
    'administer comment fields',
    'administer comment form display',
    'administer comment types',
    'administer comments',
    'administer contact forms',
    'administer contact_message display',
    'administer contact_message fields',
    'administer contact_message form display',
    'administer content types',
    'administer display modes',
    'administer filters',
    'administer image styles',
    'administer menu',
    'administer modules',
    'administer node display',
    'administer node fields',
    'administer node form display',
    'administer nodes',
    'administer permissions',
    'administer search',
    'administer shortcuts',
    'administer site configuration',
    'administer software updates',
    'administer taxonomy',
    'administer taxonomy_term display',
    'administer taxonomy_term fields',
    'administer taxonomy_term form display',
    'administer themes',
    'administer url aliases',
    'administer user display',
    'administer user fields',
    'administer user form display',
    'administer users',
    'administer views',
    'bypass node access',
    'cancel account',
    'change own username',
    'create article content',
    'create basic block content',
    'create page content',
    'create terms in tags',
    'create url aliases',
    'customize shortcut links',
    'delete all revisions',
    'delete any article content',
    'delete any basic block content',
    'delete any basic block content revisions',
    'delete any file',
    'delete any page content',
    'delete article revisions',
    'delete own article content',
    'delete own files',
    'delete own page content',
    'delete page revisions',
    'delete terms in tags',
    'edit any article content',
    'edit any basic block content',
    'edit any page content',
    'edit own article content',
    'edit own comments',
    'edit own page content',
    'edit terms in tags',
    'export configuration',
    'import configuration',
    'link to any page',
    'post comments',
    'revert all revisions',
    'revert any basic block content revisions',
    'revert article revisions',
    'revert page revisions',
    'search content',
    'select account cancellation method',
    'skip comment approval',
    'switch shortcut sets',
    'synchronize configuration',
    'use advanced search',
    'use text format basic_html',
    'use text format full_html',
    'use text format restricted_html',
    'view all revisions',
    'view any basic block content history',
    'view article revisions',
    'view own unpublished content',
    'view page revisions',
    'view the administration theme',
    'view update notifications',
    'view user email addresses',
  );
  expectedArguments(\Drupal\Core\Session\AccountInterface::hasPermission(), 0, argumentsSet('permissions'));
  expectedArguments(\Drupal\Core\Access\AccessResult::allowedIfHasPermission(), 1, argumentsSet('permissions'));
  expectedArguments(\Drupal\user\RoleInterface::allowedIfHasPermission(), 0, argumentsSet('permissions'));
  expectedArguments(\Drupal\user\RoleInterface::grantPermission(), 0, argumentsSet('permissions'));
  expectedArguments(\Drupal\user\RoleInterface::revokePermission(), 0, argumentsSet('permissions'));

}
