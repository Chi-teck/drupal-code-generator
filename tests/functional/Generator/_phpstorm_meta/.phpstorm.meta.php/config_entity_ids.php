<?php declare(strict_types = 1);

namespace PHPSTORM_META {

  // -- Action.
  registerArgumentsSet('action__ids',
    'comment_delete_action',
    'comment_publish_action',
    'comment_save_action',
    'comment_unpublish_action',
    'node_delete_action',
    'node_make_sticky_action',
    'node_make_unsticky_action',
    'node_promote_action',
    'node_publish_action',
    'node_save_action',
    'node_unpromote_action',
    'node_unpublish_action',
    'taxonomy_term_publish_action',
    'taxonomy_term_unpublish_action',
    'user_add_role_action.administrator',
    'user_add_role_action.content_editor',
    'user_block_user_action',
    'user_cancel_user_action',
    'user_remove_role_action.administrator',
    'user_remove_role_action.content_editor',
    'user_unblock_user_action',
  );
  expectedArguments(\Drupal\system\Entity\Action::load(), 0, argumentsSet('action__ids'));
  expectedReturnValues(\Drupal\system\Entity\Action::id(), argumentsSet('action__ids'));

  // -- Base field override.
  registerArgumentsSet('base_field_override__ids',
    'node.page.promote',
  );
  expectedArguments(\Drupal\Core\Field\Entity\BaseFieldOverride::load(), 0, argumentsSet('base_field_override__ids'));
  expectedReturnValues(\Drupal\Core\Field\Entity\BaseFieldOverride::id(), argumentsSet('base_field_override__ids'));

  // -- Block.
  registerArgumentsSet('block__ids',
    'claro_breadcrumbs',
    'claro_content',
    'claro_help',
    'claro_local_actions',
    'claro_messages',
    'claro_page_title',
    'claro_primary_local_tasks',
    'claro_secondary_local_tasks',
    'olivero_account_menu',
    'olivero_breadcrumbs',
    'olivero_content',
    'olivero_help',
    'olivero_main_menu',
    'olivero_messages',
    'olivero_page_title',
    'olivero_powered',
    'olivero_primary_admin_actions',
    'olivero_primary_local_tasks',
    'olivero_search_form_narrow',
    'olivero_search_form_wide',
    'olivero_secondary_local_tasks',
    'olivero_site_branding',
    'olivero_syndicate',
  );
  expectedArguments(\Drupal\block\Entity\Block::load(), 0, argumentsSet('block__ids'));
  expectedReturnValues(\Drupal\block\Entity\Block::id(), argumentsSet('block__ids'));
  expectedArguments(\Drupal\block\BlockInterface::load(), 0, argumentsSet('block__ids'));
  expectedReturnValues(\Drupal\block\BlockInterface::id(), argumentsSet('block__ids'));

  // -- Block type.
  registerArgumentsSet('block_content_type__ids',
    'basic',
  );
  expectedArguments(\Drupal\block_content\Entity\BlockContentType::load(), 0, argumentsSet('block_content_type__ids'));
  expectedReturnValues(\Drupal\block_content\Entity\BlockContentType::id(), argumentsSet('block_content_type__ids'));
  expectedArguments(\Drupal\block_content\BlockContentTypeInterface::load(), 0, argumentsSet('block_content_type__ids'));
  expectedReturnValues(\Drupal\block_content\BlockContentTypeInterface::id(), argumentsSet('block_content_type__ids'));

  // -- Comment type.
  registerArgumentsSet('comment_type__ids',
    'comment',
  );
  expectedArguments(\Drupal\comment\Entity\CommentType::load(), 0, argumentsSet('comment_type__ids'));
  expectedReturnValues(\Drupal\comment\Entity\CommentType::id(), argumentsSet('comment_type__ids'));
  expectedArguments(\Drupal\comment\CommentTypeInterface::load(), 0, argumentsSet('comment_type__ids'));
  expectedReturnValues(\Drupal\comment\CommentTypeInterface::id(), argumentsSet('comment_type__ids'));

  // -- Contact form.
  registerArgumentsSet('contact_form__ids',
    'feedback',
    'personal',
  );
  expectedArguments(\Drupal\contact\Entity\ContactForm::load(), 0, argumentsSet('contact_form__ids'));
  expectedReturnValues(\Drupal\contact\Entity\ContactForm::id(), argumentsSet('contact_form__ids'));
  expectedArguments(\Drupal\contact\ContactFormInterface::load(), 0, argumentsSet('contact_form__ids'));
  expectedReturnValues(\Drupal\contact\ContactFormInterface::id(), argumentsSet('contact_form__ids'));

  // -- Date format.
  registerArgumentsSet('date_format__ids',
    'fallback',
    'html_date',
    'html_datetime',
    'html_month',
    'html_time',
    'html_week',
    'html_year',
    'html_yearless_date',
    'long',
    'medium',
    'olivero_medium',
    'short',
  );
  expectedArguments(\Drupal\Core\Datetime\Entity\DateFormat::load(), 0, argumentsSet('date_format__ids'));
  expectedReturnValues(\Drupal\Core\Datetime\Entity\DateFormat::id(), argumentsSet('date_format__ids'));
  expectedArguments(\Drupal\Core\Datetime\DateFormatInterface::load(), 0, argumentsSet('date_format__ids'));
  expectedReturnValues(\Drupal\Core\Datetime\DateFormatInterface::id(), argumentsSet('date_format__ids'));

  // -- Text editor.
  registerArgumentsSet('editor__ids',
    'basic_html',
    'full_html',
  );
  expectedArguments(\Drupal\editor\Entity\Editor::load(), 0, argumentsSet('editor__ids'));
  expectedReturnValues(\Drupal\editor\Entity\Editor::id(), argumentsSet('editor__ids'));
  expectedArguments(\Drupal\editor\EditorInterface::load(), 0, argumentsSet('editor__ids'));
  expectedReturnValues(\Drupal\editor\EditorInterface::id(), argumentsSet('editor__ids'));

  // -- Entity form display.
  registerArgumentsSet('entity_form_display__ids',
    'block_content.basic.default',
    'comment.comment.default',
    'node.article.default',
    'node.page.default',
    'user.user.default',
  );
  expectedArguments(\Drupal\Core\Entity\Entity\EntityFormDisplay::load(), 0, argumentsSet('entity_form_display__ids'));
  expectedReturnValues(\Drupal\Core\Entity\Entity\EntityFormDisplay::id(), argumentsSet('entity_form_display__ids'));

  // -- Form mode.
  registerArgumentsSet('entity_form_mode__ids',
    'user.register',
  );
  expectedArguments(\Drupal\Core\Entity\Entity\EntityFormMode::load(), 0, argumentsSet('entity_form_mode__ids'));
  expectedReturnValues(\Drupal\Core\Entity\Entity\EntityFormMode::id(), argumentsSet('entity_form_mode__ids'));
  expectedArguments(\Drupal\Core\Entity\EntityFormModeInterface::load(), 0, argumentsSet('entity_form_mode__ids'));
  expectedReturnValues(\Drupal\Core\Entity\EntityFormModeInterface::id(), argumentsSet('entity_form_mode__ids'));

  // -- Entity view display.
  registerArgumentsSet('entity_view_display__ids',
    'block_content.basic.default',
    'comment.comment.default',
    'node.article.default',
    'node.article.rss',
    'node.article.teaser',
    'node.page.default',
    'node.page.teaser',
    'user.user.compact',
    'user.user.default',
  );
  expectedArguments(\Drupal\Core\Entity\Entity\EntityViewDisplay::load(), 0, argumentsSet('entity_view_display__ids'));
  expectedReturnValues(\Drupal\Core\Entity\Entity\EntityViewDisplay::id(), argumentsSet('entity_view_display__ids'));

  // -- View mode.
  registerArgumentsSet('entity_view_mode__ids',
    'block_content.full',
    'comment.full',
    'node.full',
    'node.rss',
    'node.search_index',
    'node.search_result',
    'node.teaser',
    'taxonomy_term.full',
    'user.compact',
    'user.full',
  );
  expectedArguments(\Drupal\Core\Entity\Entity\EntityViewMode::load(), 0, argumentsSet('entity_view_mode__ids'));
  expectedReturnValues(\Drupal\Core\Entity\Entity\EntityViewMode::id(), argumentsSet('entity_view_mode__ids'));
  expectedArguments(\Drupal\Core\Entity\EntityViewModeInterface::load(), 0, argumentsSet('entity_view_mode__ids'));
  expectedReturnValues(\Drupal\Core\Entity\EntityViewModeInterface::id(), argumentsSet('entity_view_mode__ids'));

  // -- Field.
  registerArgumentsSet('field_config__ids',
    'block_content.basic.body',
    'comment.comment.comment_body',
    'node.article.body',
    'node.article.comment',
    'node.article.field_image',
    'node.article.field_tags',
    'node.page.body',
    'user.user.user_picture',
  );
  expectedArguments(\Drupal\field\Entity\FieldConfig::load(), 0, argumentsSet('field_config__ids'));
  expectedReturnValues(\Drupal\field\Entity\FieldConfig::id(), argumentsSet('field_config__ids'));
  expectedArguments(\Drupal\field\FieldConfigInterface::load(), 0, argumentsSet('field_config__ids'));
  expectedReturnValues(\Drupal\field\FieldConfigInterface::id(), argumentsSet('field_config__ids'));

  // -- Field storage.
  registerArgumentsSet('field_storage_config__ids',
    'block_content.body',
    'comment.comment_body',
    'node.body',
    'node.comment',
    'node.field_image',
    'node.field_tags',
    'user.user_picture',
  );
  expectedArguments(\Drupal\field\Entity\FieldStorageConfig::load(), 0, argumentsSet('field_storage_config__ids'));
  expectedReturnValues(\Drupal\field\Entity\FieldStorageConfig::id(), argumentsSet('field_storage_config__ids'));
  expectedArguments(\Drupal\field\FieldStorageConfigInterface::load(), 0, argumentsSet('field_storage_config__ids'));
  expectedReturnValues(\Drupal\field\FieldStorageConfigInterface::id(), argumentsSet('field_storage_config__ids'));

  // -- Text format.
  registerArgumentsSet('filter_format__ids',
    'basic_html',
    'full_html',
    'plain_text',
    'restricted_html',
  );
  expectedArguments(\Drupal\filter\Entity\FilterFormat::load(), 0, argumentsSet('filter_format__ids'));
  expectedReturnValues(\Drupal\filter\Entity\FilterFormat::id(), argumentsSet('filter_format__ids'));
  expectedArguments(\Drupal\filter\FilterFormatInterface::load(), 0, argumentsSet('filter_format__ids'));
  expectedReturnValues(\Drupal\filter\FilterFormatInterface::id(), argumentsSet('filter_format__ids'));
  expectedArguments(\check_markup(), 1, argumentsSet('filter_format__ids'));

  // -- Image style.
  registerArgumentsSet('image_style__ids',
    'large',
    'medium',
    'thumbnail',
    'wide',
  );
  expectedArguments(\Drupal\image\Entity\ImageStyle::load(), 0, argumentsSet('image_style__ids'));
  expectedReturnValues(\Drupal\image\Entity\ImageStyle::id(), argumentsSet('image_style__ids'));
  expectedArguments(\Drupal\image\ImageStyleInterface::load(), 0, argumentsSet('image_style__ids'));
  expectedReturnValues(\Drupal\image\ImageStyleInterface::id(), argumentsSet('image_style__ids'));

  // -- Menu.
  registerArgumentsSet('menu__ids',
    'account',
    'admin',
    'footer',
    'main',
    'tools',
  );
  expectedArguments(\Drupal\system\Entity\Menu::load(), 0, argumentsSet('menu__ids'));
  expectedReturnValues(\Drupal\system\Entity\Menu::id(), argumentsSet('menu__ids'));
  expectedArguments(\Drupal\system\MenuInterface::load(), 0, argumentsSet('menu__ids'));
  expectedReturnValues(\Drupal\system\MenuInterface::id(), argumentsSet('menu__ids'));

  // -- Content type.
  registerArgumentsSet('node_type__ids',
    'article',
    'page',
  );
  expectedArguments(\Drupal\node\Entity\NodeType::load(), 0, argumentsSet('node_type__ids'));
  expectedReturnValues(\Drupal\node\Entity\NodeType::id(), argumentsSet('node_type__ids'));
  expectedArguments(\Drupal\node\NodeTypeInterface::load(), 0, argumentsSet('node_type__ids'));
  expectedReturnValues(\Drupal\node\NodeTypeInterface::id(), argumentsSet('node_type__ids'));

  // -- Search page.
  registerArgumentsSet('search_page__ids',
    'node_search',
    'user_search',
  );
  expectedArguments(\Drupal\search\Entity\SearchPage::load(), 0, argumentsSet('search_page__ids'));
  expectedReturnValues(\Drupal\search\Entity\SearchPage::id(), argumentsSet('search_page__ids'));
  expectedArguments(\Drupal\search\SearchPageInterface::load(), 0, argumentsSet('search_page__ids'));
  expectedReturnValues(\Drupal\search\SearchPageInterface::id(), argumentsSet('search_page__ids'));

  // -- Shortcut set.
  registerArgumentsSet('shortcut_set__ids',
    'default',
  );
  expectedArguments(\Drupal\shortcut\Entity\ShortcutSet::load(), 0, argumentsSet('shortcut_set__ids'));
  expectedReturnValues(\Drupal\shortcut\Entity\ShortcutSet::id(), argumentsSet('shortcut_set__ids'));
  expectedArguments(\Drupal\shortcut\ShortcutSetInterface::load(), 0, argumentsSet('shortcut_set__ids'));
  expectedReturnValues(\Drupal\shortcut\ShortcutSetInterface::id(), argumentsSet('shortcut_set__ids'));

  // -- Taxonomy vocabulary.
  registerArgumentsSet('taxonomy_vocabulary__ids',
    'tags',
  );
  expectedArguments(\Drupal\taxonomy\Entity\Vocabulary::load(), 0, argumentsSet('taxonomy_vocabulary__ids'));
  expectedReturnValues(\Drupal\taxonomy\Entity\Vocabulary::id(), argumentsSet('taxonomy_vocabulary__ids'));
  expectedArguments(\Drupal\taxonomy\VocabularyInterface::load(), 0, argumentsSet('taxonomy_vocabulary__ids'));
  expectedReturnValues(\Drupal\taxonomy\VocabularyInterface::id(), argumentsSet('taxonomy_vocabulary__ids'));

  // -- Tour.
  registerArgumentsSet('tour__ids',
    'block-layout',
    'views-ui',
  );
  expectedArguments(\Drupal\tour\Entity\Tour::load(), 0, argumentsSet('tour__ids'));
  expectedReturnValues(\Drupal\tour\Entity\Tour::id(), argumentsSet('tour__ids'));
  expectedArguments(\Drupal\tour\TourInterface::load(), 0, argumentsSet('tour__ids'));
  expectedReturnValues(\Drupal\tour\TourInterface::id(), argumentsSet('tour__ids'));

  // -- Role.
  registerArgumentsSet('user_role__ids',
    'administrator',
    'anonymous',
    'authenticated',
    'content_editor',
  );
  expectedArguments(\Drupal\user\Entity\Role::load(), 0, argumentsSet('user_role__ids'));
  expectedReturnValues(\Drupal\user\Entity\Role::id(), argumentsSet('user_role__ids'));
  expectedArguments(\Drupal\user\RoleInterface::load(), 0, argumentsSet('user_role__ids'));
  expectedReturnValues(\Drupal\user\RoleInterface::id(), argumentsSet('user_role__ids'));

  // -- View.
  registerArgumentsSet('view__ids',
    'archive',
    'block_content',
    'comment',
    'comments_recent',
    'content',
    'content_recent',
    'files',
    'frontpage',
    'glossary',
    'taxonomy_term',
    'user_admin_people',
    'watchdog',
    'who_s_new',
    'who_s_online',
  );
  expectedArguments(\Drupal\views\Entity\View::load(), 0, argumentsSet('view__ids'));
  expectedReturnValues(\Drupal\views\Entity\View::id(), argumentsSet('view__ids'));
  expectedArguments(\views_embed_view(), 0, argumentsSet('view__ids'));

}
