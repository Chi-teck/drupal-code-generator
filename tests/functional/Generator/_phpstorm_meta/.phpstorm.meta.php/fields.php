<?php

declare(strict_types=1);

namespace PHPSTORM_META {

  // Content block.
  registerArgumentsSet('fields_block_content',
    'id',
    'uuid',
    'revision_id',
    'langcode',
    'type',
    'revision_created',
    'revision_user',
    'revision_log',
    'status',
    'info',
    'changed',
    'reusable',
    'default_langcode',
    'revision_default',
    'revision_translation_affected',
    'body',
  );
  expectedArguments(\Drupal\block_content\Entity\BlockContent::set(), 0, argumentsSet('fields_block_content'));
  expectedArguments(\Drupal\block_content\Entity\BlockContent::get(), 0, argumentsSet('fields_block_content'));
  expectedArguments(\Drupal\block_content\Entity\BlockContent::hasField(), 0, argumentsSet('fields_block_content'));
  expectedArguments(\Drupal\block_content\BlockContentInterface::set(), 0, argumentsSet('fields_block_content'));
  expectedArguments(\Drupal\block_content\BlockContentInterface::get(), 0, argumentsSet('fields_block_content'));
  expectedArguments(\Drupal\block_content\BlockContentInterface::hasField(), 0, argumentsSet('fields_block_content'));

  // Comment.
  registerArgumentsSet('fields_comment',
    'cid',
    'uuid',
    'langcode',
    'comment_type',
    'status',
    'uid',
    'pid',
    'entity_id',
    'subject',
    'name',
    'mail',
    'homepage',
    'hostname',
    'created',
    'changed',
    'thread',
    'entity_type',
    'field_name',
    'default_langcode',
    'comment_body',
  );
  expectedArguments(\Drupal\comment\Entity\Comment::set(), 0, argumentsSet('fields_comment'));
  expectedArguments(\Drupal\comment\Entity\Comment::get(), 0, argumentsSet('fields_comment'));
  expectedArguments(\Drupal\comment\Entity\Comment::hasField(), 0, argumentsSet('fields_comment'));
  expectedArguments(\Drupal\comment\CommentInterface::set(), 0, argumentsSet('fields_comment'));
  expectedArguments(\Drupal\comment\CommentInterface::get(), 0, argumentsSet('fields_comment'));
  expectedArguments(\Drupal\comment\CommentInterface::hasField(), 0, argumentsSet('fields_comment'));

  // Contact message.
  registerArgumentsSet('fields_contact_message',
    'uuid',
    'langcode',
    'contact_form',
    'name',
    'mail',
    'subject',
    'message',
    'copy',
    'recipient',
  );
  expectedArguments(\Drupal\contact\Entity\Message::set(), 0, argumentsSet('fields_contact_message'));
  expectedArguments(\Drupal\contact\Entity\Message::get(), 0, argumentsSet('fields_contact_message'));
  expectedArguments(\Drupal\contact\Entity\Message::hasField(), 0, argumentsSet('fields_contact_message'));
  expectedArguments(\Drupal\contact\MessageInterface::set(), 0, argumentsSet('fields_contact_message'));
  expectedArguments(\Drupal\contact\MessageInterface::get(), 0, argumentsSet('fields_contact_message'));
  expectedArguments(\Drupal\contact\MessageInterface::hasField(), 0, argumentsSet('fields_contact_message'));

  // File.
  registerArgumentsSet('fields_file',
    'fid',
    'uuid',
    'langcode',
    'uid',
    'filename',
    'uri',
    'filemime',
    'filesize',
    'status',
    'created',
    'changed',
  );
  expectedArguments(\Drupal\file\Entity\File::set(), 0, argumentsSet('fields_file'));
  expectedArguments(\Drupal\file\Entity\File::get(), 0, argumentsSet('fields_file'));
  expectedArguments(\Drupal\file\Entity\File::hasField(), 0, argumentsSet('fields_file'));
  expectedArguments(\Drupal\file\FileInterface::set(), 0, argumentsSet('fields_file'));
  expectedArguments(\Drupal\file\FileInterface::get(), 0, argumentsSet('fields_file'));
  expectedArguments(\Drupal\file\FileInterface::hasField(), 0, argumentsSet('fields_file'));

  // Custom menu link.
  registerArgumentsSet('fields_menu_link_content',
    'id',
    'uuid',
    'revision_id',
    'langcode',
    'bundle',
    'revision_created',
    'revision_user',
    'revision_log_message',
    'enabled',
    'title',
    'description',
    'menu_name',
    'link',
    'external',
    'rediscover',
    'weight',
    'expanded',
    'parent',
    'changed',
    'default_langcode',
    'revision_default',
    'revision_translation_affected',
  );
  expectedArguments(\Drupal\menu_link_content\Entity\MenuLinkContent::set(), 0, argumentsSet('fields_menu_link_content'));
  expectedArguments(\Drupal\menu_link_content\Entity\MenuLinkContent::get(), 0, argumentsSet('fields_menu_link_content'));
  expectedArguments(\Drupal\menu_link_content\Entity\MenuLinkContent::hasField(), 0, argumentsSet('fields_menu_link_content'));
  expectedArguments(\Drupal\menu_link_content\MenuLinkContentInterface::set(), 0, argumentsSet('fields_menu_link_content'));
  expectedArguments(\Drupal\menu_link_content\MenuLinkContentInterface::get(), 0, argumentsSet('fields_menu_link_content'));
  expectedArguments(\Drupal\menu_link_content\MenuLinkContentInterface::hasField(), 0, argumentsSet('fields_menu_link_content'));

  // Content.
  registerArgumentsSet('fields_node',
    'nid',
    'uuid',
    'vid',
    'langcode',
    'type',
    'revision_timestamp',
    'revision_uid',
    'revision_log',
    'status',
    'uid',
    'title',
    'created',
    'changed',
    'promote',
    'sticky',
    'default_langcode',
    'revision_default',
    'revision_translation_affected',
    'body',
    'comment',
    'field_image',
    'field_tags',
  );
  expectedArguments(\Drupal\node\Entity\Node::set(), 0, argumentsSet('fields_node'));
  expectedArguments(\Drupal\node\Entity\Node::get(), 0, argumentsSet('fields_node'));
  expectedArguments(\Drupal\node\Entity\Node::hasField(), 0, argumentsSet('fields_node'));
  expectedArguments(\Drupal\node\NodeInterface::set(), 0, argumentsSet('fields_node'));
  expectedArguments(\Drupal\node\NodeInterface::get(), 0, argumentsSet('fields_node'));
  expectedArguments(\Drupal\node\NodeInterface::hasField(), 0, argumentsSet('fields_node'));

  // URL alias.
  registerArgumentsSet('fields_path_alias',
    'id',
    'uuid',
    'revision_id',
    'langcode',
    'path',
    'alias',
    'status',
    'revision_default',
  );
  expectedArguments(\Drupal\path_alias\Entity\PathAlias::set(), 0, argumentsSet('fields_path_alias'));
  expectedArguments(\Drupal\path_alias\Entity\PathAlias::get(), 0, argumentsSet('fields_path_alias'));
  expectedArguments(\Drupal\path_alias\Entity\PathAlias::hasField(), 0, argumentsSet('fields_path_alias'));
  expectedArguments(\Drupal\path_alias\PathAliasInterface::set(), 0, argumentsSet('fields_path_alias'));
  expectedArguments(\Drupal\path_alias\PathAliasInterface::get(), 0, argumentsSet('fields_path_alias'));
  expectedArguments(\Drupal\path_alias\PathAliasInterface::hasField(), 0, argumentsSet('fields_path_alias'));

  // Shortcut link.
  registerArgumentsSet('fields_shortcut',
    'id',
    'uuid',
    'langcode',
    'shortcut_set',
    'title',
    'weight',
    'link',
    'default_langcode',
  );
  expectedArguments(\Drupal\shortcut\Entity\Shortcut::set(), 0, argumentsSet('fields_shortcut'));
  expectedArguments(\Drupal\shortcut\Entity\Shortcut::get(), 0, argumentsSet('fields_shortcut'));
  expectedArguments(\Drupal\shortcut\Entity\Shortcut::hasField(), 0, argumentsSet('fields_shortcut'));
  expectedArguments(\Drupal\shortcut\ShortcutInterface::set(), 0, argumentsSet('fields_shortcut'));
  expectedArguments(\Drupal\shortcut\ShortcutInterface::get(), 0, argumentsSet('fields_shortcut'));
  expectedArguments(\Drupal\shortcut\ShortcutInterface::hasField(), 0, argumentsSet('fields_shortcut'));

  // Taxonomy term.
  registerArgumentsSet('fields_taxonomy_term',
    'tid',
    'uuid',
    'revision_id',
    'langcode',
    'vid',
    'revision_created',
    'revision_user',
    'revision_log_message',
    'status',
    'name',
    'description',
    'weight',
    'parent',
    'changed',
    'default_langcode',
    'revision_default',
    'revision_translation_affected',
  );
  expectedArguments(\Drupal\taxonomy\Entity\Term::set(), 0, argumentsSet('fields_taxonomy_term'));
  expectedArguments(\Drupal\taxonomy\Entity\Term::get(), 0, argumentsSet('fields_taxonomy_term'));
  expectedArguments(\Drupal\taxonomy\Entity\Term::hasField(), 0, argumentsSet('fields_taxonomy_term'));
  expectedArguments(\Drupal\taxonomy\TermInterface::set(), 0, argumentsSet('fields_taxonomy_term'));
  expectedArguments(\Drupal\taxonomy\TermInterface::get(), 0, argumentsSet('fields_taxonomy_term'));
  expectedArguments(\Drupal\taxonomy\TermInterface::hasField(), 0, argumentsSet('fields_taxonomy_term'));

  // User.
  registerArgumentsSet('fields_user',
    'uid',
    'uuid',
    'langcode',
    'preferred_langcode',
    'preferred_admin_langcode',
    'name',
    'pass',
    'mail',
    'timezone',
    'status',
    'created',
    'changed',
    'access',
    'login',
    'init',
    'roles',
    'default_langcode',
    'user_picture',
  );
  expectedArguments(\Drupal\user\Entity\User::set(), 0, argumentsSet('fields_user'));
  expectedArguments(\Drupal\user\Entity\User::get(), 0, argumentsSet('fields_user'));
  expectedArguments(\Drupal\user\Entity\User::hasField(), 0, argumentsSet('fields_user'));
  expectedArguments(\Drupal\user\UserInterface::set(), 0, argumentsSet('fields_user'));
  expectedArguments(\Drupal\user\UserInterface::get(), 0, argumentsSet('fields_user'));
  expectedArguments(\Drupal\user\UserInterface::hasField(), 0, argumentsSet('fields_user'));

}
