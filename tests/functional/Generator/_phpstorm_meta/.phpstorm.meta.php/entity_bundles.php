<?php

declare(strict_types=1);

namespace PHPSTORM_META {

  // Action.
  registerArgumentsSet('action__bundles',
    'action',
  );
  expectedReturnValues(\Drupal\system\Entity\Action::bundle(), argumentsSet('action__bundles'));

  // Base field override.
  registerArgumentsSet('base_field_override__bundles',
    'base_field_override',
  );
  expectedReturnValues(\Drupal\Core\Field\Entity\BaseFieldOverride::bundle(), argumentsSet('base_field_override__bundles'));

  // Block.
  registerArgumentsSet('block__bundles',
    'block',
  );
  expectedReturnValues(\Drupal\block\Entity\Block::bundle(), argumentsSet('block__bundles'));
  expectedReturnValues(\Drupal\block\BlockInterface::bundle(), argumentsSet('block__bundles'));

  // Content block.
  registerArgumentsSet('block_content__bundles',
    'basic',
  );
  expectedReturnValues(\Drupal\block_content\Entity\BlockContent::bundle(), argumentsSet('block_content__bundles'));
  expectedReturnValues(\Drupal\block_content\BlockContentInterface::bundle(), argumentsSet('block_content__bundles'));

  // Block type.
  registerArgumentsSet('block_content_type__bundles',
    'block_content_type',
  );
  expectedReturnValues(\Drupal\block_content\Entity\BlockContentType::bundle(), argumentsSet('block_content_type__bundles'));
  expectedReturnValues(\Drupal\block_content\BlockContentTypeInterface::bundle(), argumentsSet('block_content_type__bundles'));

  // Comment.
  registerArgumentsSet('comment__bundles',
    'comment',
  );
  expectedReturnValues(\Drupal\comment\Entity\Comment::bundle(), argumentsSet('comment__bundles'));
  expectedReturnValues(\Drupal\comment\Entity\Comment::getTypeId(), argumentsSet('comment__bundles'));
  expectedReturnValues(\Drupal\comment\CommentInterface::bundle(), argumentsSet('comment__bundles'));
  expectedReturnValues(\Drupal\comment\CommentInterface::getTypeId(), argumentsSet('comment__bundles'));

  // Comment type.
  registerArgumentsSet('comment_type__bundles',
    'comment_type',
  );
  expectedReturnValues(\Drupal\comment\Entity\CommentType::bundle(), argumentsSet('comment_type__bundles'));
  expectedReturnValues(\Drupal\comment\CommentTypeInterface::bundle(), argumentsSet('comment_type__bundles'));

  // Contact form.
  registerArgumentsSet('contact_form__bundles',
    'contact_form',
  );
  expectedReturnValues(\Drupal\contact\Entity\ContactForm::bundle(), argumentsSet('contact_form__bundles'));
  expectedReturnValues(\Drupal\contact\ContactFormInterface::bundle(), argumentsSet('contact_form__bundles'));

  // Contact message.
  registerArgumentsSet('contact_message__bundles',
    'feedback',
    'personal',
  );
  expectedReturnValues(\Drupal\contact\Entity\Message::bundle(), argumentsSet('contact_message__bundles'));
  expectedReturnValues(\Drupal\contact\MessageInterface::bundle(), argumentsSet('contact_message__bundles'));

  // Date format.
  registerArgumentsSet('date_format__bundles',
    'date_format',
  );
  expectedReturnValues(\Drupal\Core\Datetime\Entity\DateFormat::bundle(), argumentsSet('date_format__bundles'));
  expectedReturnValues(\Drupal\Core\Datetime\DateFormatInterface::bundle(), argumentsSet('date_format__bundles'));

  // Text editor.
  registerArgumentsSet('editor__bundles',
    'editor',
  );
  expectedReturnValues(\Drupal\editor\Entity\Editor::bundle(), argumentsSet('editor__bundles'));
  expectedReturnValues(\Drupal\editor\EditorInterface::bundle(), argumentsSet('editor__bundles'));

  // Entity form display.
  registerArgumentsSet('entity_form_display__bundles',
    'entity_form_display',
  );
  expectedReturnValues(\Drupal\Core\Entity\Entity\EntityFormDisplay::bundle(), argumentsSet('entity_form_display__bundles'));

  // Form mode.
  registerArgumentsSet('entity_form_mode__bundles',
    'entity_form_mode',
  );
  expectedReturnValues(\Drupal\Core\Entity\Entity\EntityFormMode::bundle(), argumentsSet('entity_form_mode__bundles'));
  expectedReturnValues(\Drupal\Core\Entity\EntityFormModeInterface::bundle(), argumentsSet('entity_form_mode__bundles'));

  // Entity view display.
  registerArgumentsSet('entity_view_display__bundles',
    'entity_view_display',
  );
  expectedReturnValues(\Drupal\Core\Entity\Entity\EntityViewDisplay::bundle(), argumentsSet('entity_view_display__bundles'));

  // View mode.
  registerArgumentsSet('entity_view_mode__bundles',
    'entity_view_mode',
  );
  expectedReturnValues(\Drupal\Core\Entity\Entity\EntityViewMode::bundle(), argumentsSet('entity_view_mode__bundles'));
  expectedReturnValues(\Drupal\Core\Entity\EntityViewModeInterface::bundle(), argumentsSet('entity_view_mode__bundles'));

  // Field.
  registerArgumentsSet('field_config__bundles',
    'field_config',
  );
  expectedReturnValues(\Drupal\field\Entity\FieldConfig::bundle(), argumentsSet('field_config__bundles'));
  expectedReturnValues(\Drupal\field\FieldConfigInterface::bundle(), argumentsSet('field_config__bundles'));

  // Field storage.
  registerArgumentsSet('field_storage_config__bundles',
    'field_storage_config',
  );
  expectedReturnValues(\Drupal\field\Entity\FieldStorageConfig::bundle(), argumentsSet('field_storage_config__bundles'));
  expectedReturnValues(\Drupal\field\FieldStorageConfigInterface::bundle(), argumentsSet('field_storage_config__bundles'));

  // File.
  registerArgumentsSet('file__bundles',
    'file',
  );
  expectedReturnValues(\Drupal\file\Entity\File::bundle(), argumentsSet('file__bundles'));
  expectedReturnValues(\Drupal\file\FileInterface::bundle(), argumentsSet('file__bundles'));

  // Text format.
  registerArgumentsSet('filter_format__bundles',
    'filter_format',
  );
  expectedReturnValues(\Drupal\filter\Entity\FilterFormat::bundle(), argumentsSet('filter_format__bundles'));
  expectedReturnValues(\Drupal\filter\FilterFormatInterface::bundle(), argumentsSet('filter_format__bundles'));

  // Image style.
  registerArgumentsSet('image_style__bundles',
    'image_style',
  );
  expectedReturnValues(\Drupal\image\Entity\ImageStyle::bundle(), argumentsSet('image_style__bundles'));
  expectedReturnValues(\Drupal\image\ImageStyleInterface::bundle(), argumentsSet('image_style__bundles'));

  // Menu.
  registerArgumentsSet('menu__bundles',
    'menu',
  );
  expectedReturnValues(\Drupal\system\Entity\Menu::bundle(), argumentsSet('menu__bundles'));
  expectedReturnValues(\Drupal\system\MenuInterface::bundle(), argumentsSet('menu__bundles'));

  // Custom menu link.
  registerArgumentsSet('menu_link_content__bundles',
    'menu_link_content',
  );
  expectedReturnValues(\Drupal\menu_link_content\Entity\MenuLinkContent::bundle(), argumentsSet('menu_link_content__bundles'));
  expectedReturnValues(\Drupal\menu_link_content\MenuLinkContentInterface::bundle(), argumentsSet('menu_link_content__bundles'));

  // Content.
  registerArgumentsSet('node__bundles',
    'article',
    'page',
  );
  expectedReturnValues(\Drupal\node\Entity\Node::bundle(), argumentsSet('node__bundles'));
  expectedReturnValues(\Drupal\node\Entity\Node::getType(), argumentsSet('node__bundles'));
  expectedReturnValues(\Drupal\node\NodeInterface::bundle(), argumentsSet('node__bundles'));
  expectedReturnValues(\Drupal\node\NodeInterface::getType(), argumentsSet('node__bundles'));

  // Content type.
  registerArgumentsSet('node_type__bundles',
    'node_type',
  );
  expectedReturnValues(\Drupal\node\Entity\NodeType::bundle(), argumentsSet('node_type__bundles'));
  expectedReturnValues(\Drupal\node\NodeTypeInterface::bundle(), argumentsSet('node_type__bundles'));

  // URL alias.
  registerArgumentsSet('path_alias__bundles',
    'path_alias',
  );
  expectedReturnValues(\Drupal\path_alias\Entity\PathAlias::bundle(), argumentsSet('path_alias__bundles'));
  expectedReturnValues(\Drupal\path_alias\PathAliasInterface::bundle(), argumentsSet('path_alias__bundles'));

  // Search page.
  registerArgumentsSet('search_page__bundles',
    'search_page',
  );
  expectedReturnValues(\Drupal\search\Entity\SearchPage::bundle(), argumentsSet('search_page__bundles'));
  expectedReturnValues(\Drupal\search\SearchPageInterface::bundle(), argumentsSet('search_page__bundles'));

  // Shortcut link.
  registerArgumentsSet('shortcut__bundles',
    'default',
  );
  expectedReturnValues(\Drupal\shortcut\Entity\Shortcut::bundle(), argumentsSet('shortcut__bundles'));
  expectedReturnValues(\Drupal\shortcut\ShortcutInterface::bundle(), argumentsSet('shortcut__bundles'));

  // Shortcut set.
  registerArgumentsSet('shortcut_set__bundles',
    'shortcut_set',
  );
  expectedReturnValues(\Drupal\shortcut\Entity\ShortcutSet::bundle(), argumentsSet('shortcut_set__bundles'));
  expectedReturnValues(\Drupal\shortcut\ShortcutSetInterface::bundle(), argumentsSet('shortcut_set__bundles'));

  // Taxonomy term.
  registerArgumentsSet('taxonomy_term__bundles',
    'tags',
  );
  expectedReturnValues(\Drupal\taxonomy\Entity\Term::bundle(), argumentsSet('taxonomy_term__bundles'));
  expectedReturnValues(\Drupal\taxonomy\TermInterface::bundle(), argumentsSet('taxonomy_term__bundles'));

  // Taxonomy vocabulary.
  registerArgumentsSet('taxonomy_vocabulary__bundles',
    'taxonomy_vocabulary',
  );
  expectedReturnValues(\Drupal\taxonomy\Entity\Vocabulary::bundle(), argumentsSet('taxonomy_vocabulary__bundles'));
  expectedReturnValues(\Drupal\taxonomy\VocabularyInterface::bundle(), argumentsSet('taxonomy_vocabulary__bundles'));

  // User.
  registerArgumentsSet('user__bundles',
    'user',
  );
  expectedReturnValues(\Drupal\user\Entity\User::bundle(), argumentsSet('user__bundles'));
  expectedReturnValues(\Drupal\user\UserInterface::bundle(), argumentsSet('user__bundles'));

  // Role.
  registerArgumentsSet('user_role__bundles',
    'user_role',
  );
  expectedReturnValues(\Drupal\user\Entity\Role::bundle(), argumentsSet('user_role__bundles'));
  expectedReturnValues(\Drupal\user\RoleInterface::bundle(), argumentsSet('user_role__bundles'));

  // View.
  registerArgumentsSet('view__bundles',
    'view',
  );
  expectedReturnValues(\Drupal\views\Entity\View::bundle(), argumentsSet('view__bundles'));

}
