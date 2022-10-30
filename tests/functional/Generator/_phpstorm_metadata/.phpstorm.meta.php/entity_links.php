<?php declare(strict_types = 1);

namespace PHPSTORM_META {

  // Block.
  registerArgumentsSet('block__links',
    'delete-form',
    'edit-form',
    'enable',
    'disable',
  );
  expectedArguments(\Drupal\block\Entity\Block::toUrl(), 0, argumentsSet('block__links'));
  expectedArguments(\Drupal\block\Entity\Block::toLink(), 1, argumentsSet('block__links'));
  expectedArguments(\Drupal\block\BlockInterface::toUrl(), 0, argumentsSet('block__links'));
  expectedArguments(\Drupal\block\BlockInterface::toLink(), 1, argumentsSet('block__links'));

  // Custom block.
  registerArgumentsSet('block_content__links',
    'canonical',
    'delete-form',
    'edit-form',
    'collection',
    'create',
  );
  expectedArguments(\Drupal\block_content\Entity\BlockContent::toUrl(), 0, argumentsSet('block_content__links'));
  expectedArguments(\Drupal\block_content\Entity\BlockContent::toLink(), 1, argumentsSet('block_content__links'));
  expectedArguments(\Drupal\block_content\BlockContentInterface::toUrl(), 0, argumentsSet('block_content__links'));
  expectedArguments(\Drupal\block_content\BlockContentInterface::toLink(), 1, argumentsSet('block_content__links'));

  // Custom block type.
  registerArgumentsSet('block_content_type__links',
    'delete-form',
    'edit-form',
    'entity-permissions-form',
    'collection',
  );
  expectedArguments(\Drupal\block_content\Entity\BlockContentType::toUrl(), 0, argumentsSet('block_content_type__links'));
  expectedArguments(\Drupal\block_content\Entity\BlockContentType::toLink(), 1, argumentsSet('block_content_type__links'));
  expectedArguments(\Drupal\block_content\BlockContentTypeInterface::toUrl(), 0, argumentsSet('block_content_type__links'));
  expectedArguments(\Drupal\block_content\BlockContentTypeInterface::toLink(), 1, argumentsSet('block_content_type__links'));

  // Comment.
  registerArgumentsSet('comment__links',
    'canonical',
    'delete-form',
    'delete-multiple-form',
    'edit-form',
    'create',
  );
  expectedArguments(\Drupal\comment\Entity\Comment::toUrl(), 0, argumentsSet('comment__links'));
  expectedArguments(\Drupal\comment\Entity\Comment::toLink(), 1, argumentsSet('comment__links'));
  expectedArguments(\Drupal\comment\CommentInterface::toUrl(), 0, argumentsSet('comment__links'));
  expectedArguments(\Drupal\comment\CommentInterface::toLink(), 1, argumentsSet('comment__links'));

  // Comment type.
  registerArgumentsSet('comment_type__links',
    'delete-form',
    'edit-form',
    'add-form',
    'entity-permissions-form',
    'collection',
  );
  expectedArguments(\Drupal\comment\Entity\CommentType::toUrl(), 0, argumentsSet('comment_type__links'));
  expectedArguments(\Drupal\comment\Entity\CommentType::toLink(), 1, argumentsSet('comment_type__links'));
  expectedArguments(\Drupal\comment\CommentTypeInterface::toUrl(), 0, argumentsSet('comment_type__links'));
  expectedArguments(\Drupal\comment\CommentTypeInterface::toLink(), 1, argumentsSet('comment_type__links'));

  // Contact form.
  registerArgumentsSet('contact_form__links',
    'delete-form',
    'edit-form',
    'entity-permissions-form',
    'collection',
    'canonical',
  );
  expectedArguments(\Drupal\contact\Entity\ContactForm::toUrl(), 0, argumentsSet('contact_form__links'));
  expectedArguments(\Drupal\contact\Entity\ContactForm::toLink(), 1, argumentsSet('contact_form__links'));
  expectedArguments(\Drupal\contact\ContactFormInterface::toUrl(), 0, argumentsSet('contact_form__links'));
  expectedArguments(\Drupal\contact\ContactFormInterface::toLink(), 1, argumentsSet('contact_form__links'));

  // Date format.
  registerArgumentsSet('date_format__links',
    'edit-form',
    'delete-form',
    'collection',
  );
  expectedArguments(\Drupal\Core\Datetime\Entity\DateFormat::toUrl(), 0, argumentsSet('date_format__links'));
  expectedArguments(\Drupal\Core\Datetime\Entity\DateFormat::toLink(), 1, argumentsSet('date_format__links'));
  expectedArguments(\Drupal\Core\Datetime\DateFormatInterface::toUrl(), 0, argumentsSet('date_format__links'));
  expectedArguments(\Drupal\Core\Datetime\DateFormatInterface::toLink(), 1, argumentsSet('date_format__links'));

  // Form mode.
  registerArgumentsSet('entity_form_mode__links',
    'delete-form',
    'edit-form',
    'add-form',
    'collection',
  );
  expectedArguments(\Drupal\Core\Entity\Entity\EntityFormMode::toUrl(), 0, argumentsSet('entity_form_mode__links'));
  expectedArguments(\Drupal\Core\Entity\Entity\EntityFormMode::toLink(), 1, argumentsSet('entity_form_mode__links'));
  expectedArguments(\Drupal\Core\Entity\EntityFormModeInterface::toUrl(), 0, argumentsSet('entity_form_mode__links'));
  expectedArguments(\Drupal\Core\Entity\EntityFormModeInterface::toLink(), 1, argumentsSet('entity_form_mode__links'));

  // View mode.
  registerArgumentsSet('entity_view_mode__links',
    'delete-form',
    'edit-form',
    'add-form',
    'collection',
  );
  expectedArguments(\Drupal\Core\Entity\Entity\EntityViewMode::toUrl(), 0, argumentsSet('entity_view_mode__links'));
  expectedArguments(\Drupal\Core\Entity\Entity\EntityViewMode::toLink(), 1, argumentsSet('entity_view_mode__links'));
  expectedArguments(\Drupal\Core\Entity\EntityViewModeInterface::toUrl(), 0, argumentsSet('entity_view_mode__links'));
  expectedArguments(\Drupal\Core\Entity\EntityViewModeInterface::toLink(), 1, argumentsSet('entity_view_mode__links'));

  // Field storage.
  registerArgumentsSet('field_storage_config__links',
    'collection',
  );
  expectedArguments(\Drupal\field\Entity\FieldStorageConfig::toUrl(), 0, argumentsSet('field_storage_config__links'));
  expectedArguments(\Drupal\field\Entity\FieldStorageConfig::toLink(), 1, argumentsSet('field_storage_config__links'));
  expectedArguments(\Drupal\field\FieldStorageConfigInterface::toUrl(), 0, argumentsSet('field_storage_config__links'));
  expectedArguments(\Drupal\field\FieldStorageConfigInterface::toLink(), 1, argumentsSet('field_storage_config__links'));

  // Text format.
  registerArgumentsSet('filter_format__links',
    'edit-form',
    'disable',
  );
  expectedArguments(\Drupal\filter\Entity\FilterFormat::toUrl(), 0, argumentsSet('filter_format__links'));
  expectedArguments(\Drupal\filter\Entity\FilterFormat::toLink(), 1, argumentsSet('filter_format__links'));
  expectedArguments(\Drupal\filter\FilterFormatInterface::toUrl(), 0, argumentsSet('filter_format__links'));
  expectedArguments(\Drupal\filter\FilterFormatInterface::toLink(), 1, argumentsSet('filter_format__links'));

  // Image style.
  registerArgumentsSet('image_style__links',
    'flush-form',
    'edit-form',
    'delete-form',
    'collection',
  );
  expectedArguments(\Drupal\image\Entity\ImageStyle::toUrl(), 0, argumentsSet('image_style__links'));
  expectedArguments(\Drupal\image\Entity\ImageStyle::toLink(), 1, argumentsSet('image_style__links'));
  expectedArguments(\Drupal\image\ImageStyleInterface::toUrl(), 0, argumentsSet('image_style__links'));
  expectedArguments(\Drupal\image\ImageStyleInterface::toLink(), 1, argumentsSet('image_style__links'));

  // Menu.
  registerArgumentsSet('menu__links',
    'add-form',
    'delete-form',
    'edit-form',
    'add-link-form',
    'collection',
  );
  expectedArguments(\Drupal\system\Entity\Menu::toUrl(), 0, argumentsSet('menu__links'));
  expectedArguments(\Drupal\system\Entity\Menu::toLink(), 1, argumentsSet('menu__links'));
  expectedArguments(\Drupal\system\MenuInterface::toUrl(), 0, argumentsSet('menu__links'));
  expectedArguments(\Drupal\system\MenuInterface::toLink(), 1, argumentsSet('menu__links'));

  // Custom menu link.
  registerArgumentsSet('menu_link_content__links',
    'canonical',
    'edit-form',
    'delete-form',
  );
  expectedArguments(\Drupal\menu_link_content\Entity\MenuLinkContent::toUrl(), 0, argumentsSet('menu_link_content__links'));
  expectedArguments(\Drupal\menu_link_content\Entity\MenuLinkContent::toLink(), 1, argumentsSet('menu_link_content__links'));
  expectedArguments(\Drupal\menu_link_content\MenuLinkContentInterface::toUrl(), 0, argumentsSet('menu_link_content__links'));
  expectedArguments(\Drupal\menu_link_content\MenuLinkContentInterface::toLink(), 1, argumentsSet('menu_link_content__links'));

  // Content.
  registerArgumentsSet('node__links',
    'canonical',
    'delete-form',
    'delete-multiple-form',
    'edit-form',
    'version-history',
    'revision',
    'create',
  );
  expectedArguments(\Drupal\node\Entity\Node::toUrl(), 0, argumentsSet('node__links'));
  expectedArguments(\Drupal\node\Entity\Node::toLink(), 1, argumentsSet('node__links'));
  expectedArguments(\Drupal\node\NodeInterface::toUrl(), 0, argumentsSet('node__links'));
  expectedArguments(\Drupal\node\NodeInterface::toLink(), 1, argumentsSet('node__links'));

  // Content type.
  registerArgumentsSet('node_type__links',
    'edit-form',
    'delete-form',
    'entity-permissions-form',
    'collection',
  );
  expectedArguments(\Drupal\node\Entity\NodeType::toUrl(), 0, argumentsSet('node_type__links'));
  expectedArguments(\Drupal\node\Entity\NodeType::toLink(), 1, argumentsSet('node_type__links'));
  expectedArguments(\Drupal\node\NodeTypeInterface::toUrl(), 0, argumentsSet('node_type__links'));
  expectedArguments(\Drupal\node\NodeTypeInterface::toLink(), 1, argumentsSet('node_type__links'));

  // URL alias.
  registerArgumentsSet('path_alias__links',
    'collection',
    'add-form',
    'edit-form',
    'delete-form',
  );
  expectedArguments(\Drupal\path_alias\Entity\PathAlias::toUrl(), 0, argumentsSet('path_alias__links'));
  expectedArguments(\Drupal\path_alias\Entity\PathAlias::toLink(), 1, argumentsSet('path_alias__links'));
  expectedArguments(\Drupal\path_alias\PathAliasInterface::toUrl(), 0, argumentsSet('path_alias__links'));
  expectedArguments(\Drupal\path_alias\PathAliasInterface::toLink(), 1, argumentsSet('path_alias__links'));

  // Search page.
  registerArgumentsSet('search_page__links',
    'edit-form',
    'delete-form',
    'enable',
    'disable',
    'set-default',
    'collection',
  );
  expectedArguments(\Drupal\search\Entity\SearchPage::toUrl(), 0, argumentsSet('search_page__links'));
  expectedArguments(\Drupal\search\Entity\SearchPage::toLink(), 1, argumentsSet('search_page__links'));
  expectedArguments(\Drupal\search\SearchPageInterface::toUrl(), 0, argumentsSet('search_page__links'));
  expectedArguments(\Drupal\search\SearchPageInterface::toLink(), 1, argumentsSet('search_page__links'));

  // Shortcut link.
  registerArgumentsSet('shortcut__links',
    'canonical',
    'delete-form',
    'edit-form',
  );
  expectedArguments(\Drupal\shortcut\Entity\Shortcut::toUrl(), 0, argumentsSet('shortcut__links'));
  expectedArguments(\Drupal\shortcut\Entity\Shortcut::toLink(), 1, argumentsSet('shortcut__links'));
  expectedArguments(\Drupal\shortcut\ShortcutInterface::toUrl(), 0, argumentsSet('shortcut__links'));
  expectedArguments(\Drupal\shortcut\ShortcutInterface::toLink(), 1, argumentsSet('shortcut__links'));

  // Shortcut set.
  registerArgumentsSet('shortcut_set__links',
    'customize-form',
    'delete-form',
    'edit-form',
    'collection',
  );
  expectedArguments(\Drupal\shortcut\Entity\ShortcutSet::toUrl(), 0, argumentsSet('shortcut_set__links'));
  expectedArguments(\Drupal\shortcut\Entity\ShortcutSet::toLink(), 1, argumentsSet('shortcut_set__links'));
  expectedArguments(\Drupal\shortcut\ShortcutSetInterface::toUrl(), 0, argumentsSet('shortcut_set__links'));
  expectedArguments(\Drupal\shortcut\ShortcutSetInterface::toLink(), 1, argumentsSet('shortcut_set__links'));

  // Taxonomy term.
  registerArgumentsSet('taxonomy_term__links',
    'canonical',
    'delete-form',
    'edit-form',
    'create',
  );
  expectedArguments(\Drupal\taxonomy\Entity\Term::toUrl(), 0, argumentsSet('taxonomy_term__links'));
  expectedArguments(\Drupal\taxonomy\Entity\Term::toLink(), 1, argumentsSet('taxonomy_term__links'));
  expectedArguments(\Drupal\taxonomy\TermInterface::toUrl(), 0, argumentsSet('taxonomy_term__links'));
  expectedArguments(\Drupal\taxonomy\TermInterface::toLink(), 1, argumentsSet('taxonomy_term__links'));

  // Taxonomy vocabulary.
  registerArgumentsSet('taxonomy_vocabulary__links',
    'add-form',
    'delete-form',
    'reset-form',
    'overview-form',
    'edit-form',
    'entity-permissions-form',
    'collection',
  );
  expectedArguments(\Drupal\taxonomy\Entity\Vocabulary::toUrl(), 0, argumentsSet('taxonomy_vocabulary__links'));
  expectedArguments(\Drupal\taxonomy\Entity\Vocabulary::toLink(), 1, argumentsSet('taxonomy_vocabulary__links'));
  expectedArguments(\Drupal\taxonomy\VocabularyInterface::toUrl(), 0, argumentsSet('taxonomy_vocabulary__links'));
  expectedArguments(\Drupal\taxonomy\VocabularyInterface::toLink(), 1, argumentsSet('taxonomy_vocabulary__links'));

  // User.
  registerArgumentsSet('user__links',
    'canonical',
    'edit-form',
    'cancel-form',
    'collection',
    'contact-form',
  );
  expectedArguments(\Drupal\user\Entity\User::toUrl(), 0, argumentsSet('user__links'));
  expectedArguments(\Drupal\user\Entity\User::toLink(), 1, argumentsSet('user__links'));
  expectedArguments(\Drupal\user\UserInterface::toUrl(), 0, argumentsSet('user__links'));
  expectedArguments(\Drupal\user\UserInterface::toLink(), 1, argumentsSet('user__links'));

  // Role.
  registerArgumentsSet('user_role__links',
    'delete-form',
    'edit-form',
    'edit-permissions-form',
    'collection',
  );
  expectedArguments(\Drupal\user\Entity\Role::toUrl(), 0, argumentsSet('user_role__links'));
  expectedArguments(\Drupal\user\Entity\Role::toLink(), 1, argumentsSet('user_role__links'));
  expectedArguments(\Drupal\user\RoleInterface::toUrl(), 0, argumentsSet('user_role__links'));
  expectedArguments(\Drupal\user\RoleInterface::toLink(), 1, argumentsSet('user_role__links'));

  // View.
  registerArgumentsSet('view__links',
    'edit-form',
    'edit-display-form',
    'preview-form',
    'duplicate-form',
    'delete-form',
    'enable',
    'disable',
    'break-lock-form',
    'collection',
  );
  expectedArguments(\Drupal\views\Entity\View::toUrl(), 0, argumentsSet('view__links'));
  expectedArguments(\Drupal\views\Entity\View::toLink(), 1, argumentsSet('view__links'));

}
