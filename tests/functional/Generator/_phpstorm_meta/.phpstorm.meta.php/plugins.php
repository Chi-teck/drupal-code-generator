<?php declare(strict_types = 1);

namespace PHPSTORM_META {

  // -- breakpoint.manager.
  registerArgumentsSet('breakpoint.manager__plugin_ids',
    'olivero.grid-max',
    'olivero.grid-md',
    'olivero.lg',
    'olivero.md',
    'olivero.nav',
    'olivero.nav-md',
    'olivero.sm',
    'olivero.xl',
    'toolbar.narrow',
    'toolbar.standard',
    'toolbar.wide',
  );
  expectedArguments(\Drupal\breakpoint\BreakpointManager::createInstance(), 0, argumentsSet('breakpoint.manager__plugin_ids'));
  expectedArguments(\Drupal\breakpoint\BreakpointManager::getDefinition(), 0, argumentsSet('breakpoint.manager__plugin_ids'));
  expectedArguments(\Drupal\breakpoint\BreakpointManager::hasDefinition(), 0, argumentsSet('breakpoint.manager__plugin_ids'));
  expectedArguments(\Drupal\breakpoint\BreakpointManager::processDefinition(), 1, argumentsSet('breakpoint.manager__plugin_ids'));
  expectedArguments(\Drupal\breakpoint\BreakpointManagerInterface::createInstance(), 0, argumentsSet('breakpoint.manager__plugin_ids'));
  expectedArguments(\Drupal\breakpoint\BreakpointManagerInterface::getDefinition(), 0, argumentsSet('breakpoint.manager__plugin_ids'));
  expectedArguments(\Drupal\breakpoint\BreakpointManagerInterface::hasDefinition(), 0, argumentsSet('breakpoint.manager__plugin_ids'));
  expectedArguments(\Drupal\breakpoint\BreakpointManagerInterface::processDefinition(), 1, argumentsSet('breakpoint.manager__plugin_ids'));

  // -- config.typed.
  registerArgumentsSet('config.typed__plugin_ids',
    '_core_config_info',
    'action.configuration.action_goto_action',
    'action.configuration.action_message_action',
    'action.configuration.action_send_email_action',
    'action.configuration.comment_unpublish_by_keyword_action',
    'action.configuration.entity:*:*',
    'action.configuration.node_assign_owner_action',
    'action.configuration.node_make_sticky_action',
    'action.configuration.node_make_unsticky_action',
    'action.configuration.node_promote_action',
    'action.configuration.node_unpromote_action',
    'action.configuration.node_unpublish_by_keyword_action',
    'action.configuration.user_add_role_action',
    'action.configuration.user_block_user_action',
    'action.configuration.user_cancel_user_action',
    'action.configuration.user_remove_role_action',
    'action.configuration.user_unblock_user_action',
    'action_configuration_default',
    'automated_cron.settings',
    'base_entity_reference_field_settings',
    'base_file_field_field_settings',
    'block.block.*',
    'block.settings.*',
    'block.settings.extra_field_block:*:*:*',
    'block.settings.field_block:*:*:*',
    'block.settings.local_tasks_block',
    'block.settings.node_syndicate_block',
    'block.settings.search_form_block',
    'block.settings.system_branding_block',
    'block.settings.system_menu_block:*',
    'block.settings.views_block:*',
    'block.settings.views_exposed_filter_block:*',
    'block_content.type.*',
    'block_settings',
    'boolean',
    'ckeditor5.element',
    'ckeditor5.plugin.ckeditor5_alignment',
    'ckeditor5.plugin.ckeditor5_heading',
    'ckeditor5.plugin.ckeditor5_imageResize',
    'ckeditor5.plugin.ckeditor5_language',
    'ckeditor5.plugin.ckeditor5_list',
    'ckeditor5.plugin.ckeditor5_sourceEditing',
    'ckeditor5.plugin.ckeditor5_style',
    'ckeditor5.plugin.media_media',
    'ckeditor5.toolbar_item',
    'ckeditor5_valid_pair__format_and_editor',
    'claro.settings',
    'color_hex',
    'comment.settings',
    'comment.type.*',
    'condition.plugin',
    'condition.plugin.current_theme',
    'condition.plugin.entity_bundle:*',
    'condition.plugin.request_path',
    'condition.plugin.user_role',
    'config_dependencies',
    'config_dependencies_base',
    'config_entity',
    'config_object',
    'contact.form.*',
    'contact.settings',
    'core.base_field_override.*.*.*',
    'core.date_format.*',
    'core.entity_form_display.*.*.*',
    'core.entity_form_mode.*.*',
    'core.entity_view_display.*.*.*',
    'core.entity_view_mode.*.*',
    'core.extension',
    'core.menu.static_menu_link_overrides',
    'core_date_format_pattern.0',
    'core_date_format_pattern.1',
    'date_format',
    'dblog.settings',
    'display_variant.plugin',
    'editor.editor.*',
    'editor.settings.ckeditor5',
    'email',
    'entity_reference_selection',
    'entity_reference_selection.*',
    'entity_reference_selection.default',
    'entity_reference_selection.default:*',
    'entity_reference_selection.default:user',
    'entity_reference_selection.views',
    'field.field.*.*.*',
    'field.field_settings.*',
    'field.field_settings.boolean',
    'field.field_settings.changed',
    'field.field_settings.comment',
    'field.field_settings.created',
    'field.field_settings.datetime',
    'field.field_settings.decimal',
    'field.field_settings.email',
    'field.field_settings.entity_reference',
    'field.field_settings.file',
    'field.field_settings.float',
    'field.field_settings.image',
    'field.field_settings.integer',
    'field.field_settings.link',
    'field.field_settings.list_float',
    'field.field_settings.list_integer',
    'field.field_settings.list_string',
    'field.field_settings.password',
    'field.field_settings.string',
    'field.field_settings.string_long',
    'field.field_settings.text',
    'field.field_settings.text_long',
    'field.field_settings.text_with_summary',
    'field.field_settings.uri',
    'field.formatter.settings.*',
    'field.formatter.settings.boolean',
    'field.formatter.settings.comment_default',
    'field.formatter.settings.comment_permalink',
    'field.formatter.settings.datetime_base',
    'field.formatter.settings.datetime_custom',
    'field.formatter.settings.datetime_default',
    'field.formatter.settings.datetime_plain',
    'field.formatter.settings.datetime_time_ago',
    'field.formatter.settings.entity_reference_entity_id',
    'field.formatter.settings.entity_reference_entity_view',
    'field.formatter.settings.entity_reference_label',
    'field.formatter.settings.entity_reference_rss_category',
    'field.formatter.settings.file_audio',
    'field.formatter.settings.file_default',
    'field.formatter.settings.file_extension',
    'field.formatter.settings.file_filemime',
    'field.formatter.settings.file_link',
    'field.formatter.settings.file_rss_enclosure',
    'field.formatter.settings.file_table',
    'field.formatter.settings.file_uri',
    'field.formatter.settings.file_url_plain',
    'field.formatter.settings.file_video',
    'field.formatter.settings.image',
    'field.formatter.settings.image_url',
    'field.formatter.settings.language',
    'field.formatter.settings.link',
    'field.formatter.settings.link_separate',
    'field.formatter.settings.list_default',
    'field.formatter.settings.list_key',
    'field.formatter.settings.number_decimal',
    'field.formatter.settings.number_integer',
    'field.formatter.settings.number_unformatted',
    'field.formatter.settings.string',
    'field.formatter.settings.text_default',
    'field.formatter.settings.text_summary_or_trimmed',
    'field.formatter.settings.text_trimmed',
    'field.formatter.settings.timestamp',
    'field.formatter.settings.timestamp_ago',
    'field.formatter.settings.uri_link',
    'field.formatter.settings.user_name',
    'field.settings',
    'field.storage.*.*',
    'field.storage_settings.*',
    'field.storage_settings.changed',
    'field.storage_settings.comment',
    'field.storage_settings.created',
    'field.storage_settings.datetime',
    'field.storage_settings.decimal',
    'field.storage_settings.email',
    'field.storage_settings.entity_reference',
    'field.storage_settings.file',
    'field.storage_settings.float',
    'field.storage_settings.image',
    'field.storage_settings.integer',
    'field.storage_settings.link',
    'field.storage_settings.list_float',
    'field.storage_settings.list_integer',
    'field.storage_settings.list_string',
    'field.storage_settings.password',
    'field.storage_settings.string',
    'field.storage_settings.string_long',
    'field.storage_settings.text',
    'field.storage_settings.text_long',
    'field.storage_settings.text_with_summary',
    'field.storage_settings.uri',
    'field.value.*',
    'field.value.boolean',
    'field.value.changed',
    'field.value.comment',
    'field.value.created',
    'field.value.datetime',
    'field.value.decimal',
    'field.value.email',
    'field.value.entity_reference',
    'field.value.file',
    'field.value.float',
    'field.value.image',
    'field.value.integer',
    'field.value.link',
    'field.value.list_float',
    'field.value.list_integer',
    'field.value.list_string',
    'field.value.string',
    'field.value.string_long',
    'field.value.text',
    'field.value.text_long',
    'field.value.text_with_summary',
    'field.value.timestamp',
    'field.value.uri',
    'field.widget.settings.*',
    'field.widget.settings.boolean_checkbox',
    'field.widget.settings.checkbox',
    'field.widget.settings.comment_default',
    'field.widget.settings.datetime_datelist',
    'field.widget.settings.datetime_default',
    'field.widget.settings.datetime_timestamp',
    'field.widget.settings.email_default',
    'field.widget.settings.entity_reference_autocomplete',
    'field.widget.settings.entity_reference_autocomplete_tags',
    'field.widget.settings.file_generic',
    'field.widget.settings.hidden',
    'field.widget.settings.image_image',
    'field.widget.settings.link_default',
    'field.widget.settings.number',
    'field.widget.settings.options_buttons',
    'field.widget.settings.options_select',
    'field.widget.settings.path',
    'field.widget.settings.string_textarea',
    'field.widget.settings.string_textfield',
    'field.widget.settings.text_textarea',
    'field.widget.settings.text_textarea_with_summary',
    'field.widget.settings.text_textfield',
    'field.widget.settings.uri',
    'field_config_base',
    'field_default_image',
    'field_formatter',
    'field_formatter.entity_view_display',
    'field_formatter_settings_base_file',
    'field_ui.settings',
    'file.formatter.media',
    'file.settings',
    'filter',
    'filter.format.*',
    'filter.settings',
    'filter_settings.*',
    'filter_settings.filter_html',
    'filter_settings.filter_url',
    'float',
    'ignore',
    'image.effect.*',
    'image.effect.image_convert',
    'image.effect.image_crop',
    'image.effect.image_desaturate',
    'image.effect.image_resize',
    'image.effect.image_rotate',
    'image.effect.image_scale',
    'image.effect.image_scale_and_crop',
    'image.settings',
    'image.style.*',
    'image_size',
    'integer',
    'label',
    'layout_plugin.settings',
    'layout_plugin.settings.*',
    'mail',
    'mapping',
    'menu_ui.settings',
    'migrate.source.update_settings',
    'node.settings',
    'node.type.*',
    'node.type.*.third_party.menu_ui',
    'olivero.settings',
    'path',
    'plural_label',
    'route',
    'search.page.*',
    'search.plugin.node_search',
    'search.plugin.user_search',
    'search.settings',
    'sequence',
    'shortcut.set.*',
    'string',
    'system.action.*',
    'system.advisories',
    'system.cron',
    'system.date',
    'system.diff',
    'system.feature_flags',
    'system.file',
    'system.image',
    'system.image.gd',
    'system.logging',
    'system.mail',
    'system.maintenance',
    'system.menu.*',
    'system.performance',
    'system.rss',
    'system.site',
    'system.theme',
    'system.theme.global',
    'taxonomy.settings',
    'taxonomy.vocabulary.*',
    'text',
    'text.settings',
    'text_format',
    'theme_settings',
    'theme_settings.third_party.shortcut',
    'timestamp',
    'tour.tip',
    'tour.tip.text',
    'tour.tour.*',
    'undefined',
    'update.settings',
    'uri',
    'user.flood',
    'user.mail',
    'user.role.*',
    'user.settings',
    'uuid',
    'views.access.none',
    'views.access.perm',
    'views.access.role',
    'views.area.*',
    'views.area.display_link',
    'views.area.entity',
    'views.area.http_status_code',
    'views.area.node_listing_empty',
    'views.area.result',
    'views.area.text',
    'views.area.text_custom',
    'views.area.title',
    'views.area.view',
    'views.argument.*',
    'views.argument.argument_comment_user_uid',
    'views.argument.broken',
    'views.argument.date',
    'views.argument.date_day',
    'views.argument.date_fulldate',
    'views.argument.date_month',
    'views.argument.date_week',
    'views.argument.date_year',
    'views.argument.date_year_month',
    'views.argument.datetime',
    'views.argument.datetime_day',
    'views.argument.datetime_full_date',
    'views.argument.datetime_month',
    'views.argument.datetime_week',
    'views.argument.datetime_year',
    'views.argument.datetime_year_month',
    'views.argument.file_fid',
    'views.argument.formula',
    'views.argument.groupby_numeric',
    'views.argument.language',
    'views.argument.many_to_one',
    'views.argument.node_nid',
    'views.argument.node_type',
    'views.argument.node_uid_revision',
    'views.argument.node_vid',
    'views.argument.null',
    'views.argument.number_list_field',
    'views.argument.numeric',
    'views.argument.search',
    'views.argument.standard',
    'views.argument.string',
    'views.argument.string_list_field',
    'views.argument.taxonomy',
    'views.argument.taxonomy_index_tid',
    'views.argument.taxonomy_index_tid_depth',
    'views.argument.taxonomy_index_tid_depth_modifier',
    'views.argument.user__roles_rid',
    'views.argument.user_uid',
    'views.argument.vocabulary_vid',
    'views.argument_default.*',
    'views.argument_default.fixed',
    'views.argument_default.query_parameter',
    'views.argument_default.raw',
    'views.argument_default.taxonomy_tid',
    'views.argument_default.user',
    'views.argument_validator.*',
    'views.argument_validator.entity:*',
    'views.argument_validator.entity:taxonomy_term',
    'views.argument_validator.entity:user',
    'views.argument_validator.none',
    'views.argument_validator.php',
    'views.argument_validator.taxonomy_term_name',
    'views.argument_validator_entity',
    'views.cache.none',
    'views.cache.tag',
    'views.cache.time',
    'views.display.attachment',
    'views.display.block',
    'views.display.default',
    'views.display.embed',
    'views.display.entity_reference',
    'views.display.feed',
    'views.display.page',
    'views.exposed_form.basic',
    'views.exposed_form.input_required',
    'views.field.*',
    'views.field.boolean',
    'views.field.broken',
    'views.field.bulk_form',
    'views.field.comment_bulk_form',
    'views.field.comment_ces_last_comment_name',
    'views.field.comment_ces_last_updated',
    'views.field.comment_depth',
    'views.field.comment_entity_link',
    'views.field.comment_last_timestamp',
    'views.field.comment_link_approve',
    'views.field.comment_link_reply',
    'views.field.commented_entity',
    'views.field.contact_link',
    'views.field.contextual_links',
    'views.field.counter',
    'views.field.custom',
    'views.field.date',
    'views.field.dblog_message',
    'views.field.dblog_operations',
    'views.field.dropbutton',
    'views.field.entity_label',
    'views.field.entity_link',
    'views.field.entity_link_delete',
    'views.field.entity_link_edit',
    'views.field.field',
    'views.field.file',
    'views.field.file_size',
    'views.field.history_user_timestamp',
    'views.field.language',
    'views.field.links',
    'views.field.machine_name',
    'views.field.markup',
    'views.field.node',
    'views.field.node_bulk_form',
    'views.field.node_new_comments',
    'views.field.node_revision_link',
    'views.field.node_revision_link_delete',
    'views.field.node_revision_link_revert',
    'views.field.numeric',
    'views.field.prerender_list',
    'views.field.rendered_entity',
    'views.field.search_score',
    'views.field.serialized',
    'views.field.standard',
    'views.field.taxonomy_index_tid',
    'views.field.term_name',
    'views.field.time_interval',
    'views.field.url',
    'views.field.user',
    'views.field.user_bulk_form',
    'views.field.user_data',
    'views.field.user_permissions',
    'views.field.user_roles',
    'views.filter.*',
    'views.filter.boolean',
    'views.filter.broken',
    'views.filter.bundle',
    'views.filter.combine',
    'views.filter.comment_ces_last_updated',
    'views.filter.comment_user_uid',
    'views.filter.date',
    'views.filter.datetime',
    'views.filter.dblog_types',
    'views.filter.file_status',
    'views.filter.group_item.*',
    'views.filter.group_item.boolean',
    'views.filter.group_item.in_operator',
    'views.filter.history_user_timestamp',
    'views.filter.in_operator',
    'views.filter.language',
    'views.filter.latest_revision',
    'views.filter.list_field',
    'views.filter.many_to_one',
    'views.filter.node_access',
    'views.filter.node_comment',
    'views.filter.node_status',
    'views.filter.node_uid_revision',
    'views.filter.numeric',
    'views.filter.search',
    'views.filter.standard',
    'views.filter.string',
    'views.filter.taxonomy_index_tid',
    'views.filter.taxonomy_index_tid_depth',
    'views.filter.user_current',
    'views.filter.user_name',
    'views.filter.user_permissions',
    'views.filter.user_roles',
    'views.filter_value.*',
    'views.filter_value.boolean',
    'views.filter_value.combine',
    'views.filter_value.date',
    'views.filter_value.datetime',
    'views.filter_value.equality',
    'views.filter_value.groupby_numeric',
    'views.filter_value.in_operator',
    'views.filter_value.node_access',
    'views.filter_value.node_status',
    'views.filter_value.numeric',
    'views.filter_value.search_keywords',
    'views.filter_value.string',
    'views.filter_value.user_current',
    'views.pager.*',
    'views.pager.full',
    'views.pager.mini',
    'views.pager.none',
    'views.pager.some',
    'views.query.views_query',
    'views.relationship.*',
    'views.relationship.broken',
    'views.relationship.entity_reverse',
    'views.relationship.groupwise_max',
    'views.relationship.node_term_data',
    'views.relationship.standard',
    'views.row.*',
    'views.row.comment_rss',
    'views.row.entity:*',
    'views.row.entity_reference',
    'views.row.fields',
    'views.row.node_rss',
    'views.row.opml_fields',
    'views.row.rss_fields',
    'views.row.search_view',
    'views.settings',
    'views.sort.*',
    'views.sort.boolean',
    'views.sort.broken',
    'views.sort.comment_ces_last_comment_name',
    'views.sort.comment_ces_last_updated',
    'views.sort.comment_thread',
    'views.sort.date',
    'views.sort.datetime',
    'views.sort.random',
    'views.sort.search_score',
    'views.sort.standard',
    'views.sort_expose.*',
    'views.sort_expose.boolean',
    'views.sort_expose.date',
    'views.sort_expose.datetime',
    'views.sort_expose.random',
    'views.sort_expose.standard',
    'views.style.*',
    'views.style.default',
    'views.style.default_summary',
    'views.style.entity_reference',
    'views.style.grid',
    'views.style.grid_responsive',
    'views.style.html_list',
    'views.style.rss',
    'views.style.table',
    'views.style.unformatted_summary',
    'views.view.*',
    'views_area',
    'views_argument',
    'views_block',
    'views_cache',
    'views_display',
    'views_display_extender',
    'views_display_path',
    'views_entity_row',
    'views_exposed_form',
    'views_field',
    'views_field_bulk_form',
    'views_field_user',
    'views_filter',
    'views_filter_boolean_string',
    'views_filter_group_item',
    'views_handler',
    'views_pager',
    'views_pager_sql',
    'views_query',
    'views_relationship',
    'views_row',
    'views_sort',
    'views_sort_expose',
    'views_style',
  );
  expectedArguments(\Drupal\Core\Config\TypedConfigManager::createInstance(), 0, argumentsSet('config.typed__plugin_ids'));
  expectedArguments(\Drupal\Core\Config\TypedConfigManager::getDefinition(), 0, argumentsSet('config.typed__plugin_ids'));
  expectedArguments(\Drupal\Core\Config\TypedConfigManager::hasDefinition(), 0, argumentsSet('config.typed__plugin_ids'));
  expectedArguments(\Drupal\Core\Config\TypedConfigManager::processDefinition(), 1, argumentsSet('config.typed__plugin_ids'));
  expectedArguments(\Drupal\Core\Config\TypedConfigManagerInterface::createInstance(), 0, argumentsSet('config.typed__plugin_ids'));
  expectedArguments(\Drupal\Core\Config\TypedConfigManagerInterface::getDefinition(), 0, argumentsSet('config.typed__plugin_ids'));
  expectedArguments(\Drupal\Core\Config\TypedConfigManagerInterface::hasDefinition(), 0, argumentsSet('config.typed__plugin_ids'));
  expectedArguments(\Drupal\Core\Config\TypedConfigManagerInterface::processDefinition(), 1, argumentsSet('config.typed__plugin_ids'));

  // -- entity_type.manager.
  override(\Drupal\Core\Entity\EntityTypeManager::createInstance(), map(['' => '\Drupal\Core\Entity\EntityInterface']));
  override(\Drupal\Core\Entity\EntityTypeManager::getInstance(), map(['' => '\Drupal\Core\Entity\EntityInterface|bool']));
  override(\Drupal\Core\Entity\EntityTypeManagerInterface::createInstance(), map(['' => '\Drupal\Core\Entity\EntityInterface']));
  override(\Drupal\Core\Entity\EntityTypeManagerInterface::getInstance(), map(['' => '\Drupal\Core\Entity\EntityInterface|bool']));
  registerArgumentsSet('entity_type.manager__plugin_ids',
    'action',
    'base_field_override',
    'block',
    'block_content',
    'block_content_type',
    'comment',
    'comment_type',
    'contact_form',
    'contact_message',
    'date_format',
    'editor',
    'entity_form_display',
    'entity_form_mode',
    'entity_view_display',
    'entity_view_mode',
    'field_config',
    'field_storage_config',
    'file',
    'filter_format',
    'image_style',
    'menu',
    'menu_link_content',
    'node',
    'node_type',
    'path_alias',
    'search_page',
    'shortcut',
    'shortcut_set',
    'taxonomy_term',
    'taxonomy_vocabulary',
    'tour',
    'user',
    'user_role',
    'view',
  );
  expectedArguments(\Drupal\Core\Entity\EntityTypeManager::createInstance(), 0, argumentsSet('entity_type.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityTypeManager::getDefinition(), 0, argumentsSet('entity_type.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityTypeManager::hasDefinition(), 0, argumentsSet('entity_type.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityTypeManager::processDefinition(), 1, argumentsSet('entity_type.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityTypeManagerInterface::createInstance(), 0, argumentsSet('entity_type.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityTypeManagerInterface::getDefinition(), 0, argumentsSet('entity_type.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityTypeManagerInterface::hasDefinition(), 0, argumentsSet('entity_type.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityTypeManagerInterface::processDefinition(), 1, argumentsSet('entity_type.manager__plugin_ids'));

  // -- image.toolkit.manager.
  override(\Drupal\Core\ImageToolkit\ImageToolkitManager::createInstance(), map(['' => '\Drupal\Core\ImageToolkit\ImageToolkitInterface']));
  override(\Drupal\Core\ImageToolkit\ImageToolkitManager::getInstance(), map(['' => '\Drupal\Core\ImageToolkit\ImageToolkitInterface|bool']));
  registerArgumentsSet('image.toolkit.manager__plugin_ids',
    'gd',
  );
  expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitManager::createInstance(), 0, argumentsSet('image.toolkit.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitManager::getDefinition(), 0, argumentsSet('image.toolkit.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitManager::hasDefinition(), 0, argumentsSet('image.toolkit.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitManager::processDefinition(), 1, argumentsSet('image.toolkit.manager__plugin_ids'));

  // -- image.toolkit.operation.manager.
  override(\Drupal\Core\ImageToolkit\ImageToolkitOperationManager::createInstance(), map(['' => '\Drupal\Core\ImageToolkit\ImageToolkitOperationInterface']));
  override(\Drupal\Core\ImageToolkit\ImageToolkitOperationManager::getInstance(), map(['' => '\Drupal\Core\ImageToolkit\ImageToolkitOperationInterface|bool']));
  override(\Drupal\Core\ImageToolkit\ImageToolkitOperationManagerInterface::createInstance(), map(['' => '\Drupal\Core\ImageToolkit\ImageToolkitOperationInterface']));
  override(\Drupal\Core\ImageToolkit\ImageToolkitOperationManagerInterface::getInstance(), map(['' => '\Drupal\Core\ImageToolkit\ImageToolkitOperationInterface|bool']));
  registerArgumentsSet('image.toolkit.operation.manager__plugin_ids',
    'gd_convert',
    'gd_create_new',
    'gd_crop',
    'gd_desaturate',
    'gd_resize',
    'gd_rotate',
    'gd_scale',
    'gd_scale_and_crop',
  );
  expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitOperationManager::createInstance(), 0, argumentsSet('image.toolkit.operation.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitOperationManager::getDefinition(), 0, argumentsSet('image.toolkit.operation.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitOperationManager::hasDefinition(), 0, argumentsSet('image.toolkit.operation.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitOperationManager::processDefinition(), 1, argumentsSet('image.toolkit.operation.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitOperationManagerInterface::createInstance(), 0, argumentsSet('image.toolkit.operation.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitOperationManagerInterface::getDefinition(), 0, argumentsSet('image.toolkit.operation.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitOperationManagerInterface::hasDefinition(), 0, argumentsSet('image.toolkit.operation.manager__plugin_ids'));
  expectedArguments(\Drupal\Core\ImageToolkit\ImageToolkitOperationManagerInterface::processDefinition(), 1, argumentsSet('image.toolkit.operation.manager__plugin_ids'));

  // -- plugin.manager.action.
  override(\Drupal\Core\Action\ActionManager::createInstance(), map(['' => '\Drupal\Core\Action\ActionInterface']));
  override(\Drupal\Core\Action\ActionManager::getInstance(), map(['' => '\Drupal\Core\Action\ActionInterface|bool']));
  registerArgumentsSet('plugin.manager.action__plugin_ids',
    'action_goto_action',
    'action_message_action',
    'action_send_email_action',
    'comment_unpublish_by_keyword_action',
    'entity:delete_action:comment',
    'entity:delete_action:node',
    'entity:publish_action:block_content',
    'entity:publish_action:comment',
    'entity:publish_action:menu_link_content',
    'entity:publish_action:node',
    'entity:publish_action:path_alias',
    'entity:publish_action:taxonomy_term',
    'entity:save_action:block_content',
    'entity:save_action:comment',
    'entity:save_action:file',
    'entity:save_action:menu_link_content',
    'entity:save_action:node',
    'entity:save_action:taxonomy_term',
    'entity:save_action:user',
    'entity:unpublish_action:block_content',
    'entity:unpublish_action:comment',
    'entity:unpublish_action:menu_link_content',
    'entity:unpublish_action:node',
    'entity:unpublish_action:path_alias',
    'entity:unpublish_action:taxonomy_term',
    'node_assign_owner_action',
    'node_make_sticky_action',
    'node_make_unsticky_action',
    'node_promote_action',
    'node_unpromote_action',
    'node_unpublish_by_keyword_action',
    'user_add_role_action',
    'user_block_user_action',
    'user_cancel_user_action',
    'user_remove_role_action',
    'user_unblock_user_action',
  );
  expectedArguments(\Drupal\Core\Action\ActionManager::createInstance(), 0, argumentsSet('plugin.manager.action__plugin_ids'));
  expectedArguments(\Drupal\Core\Action\ActionManager::getDefinition(), 0, argumentsSet('plugin.manager.action__plugin_ids'));
  expectedArguments(\Drupal\Core\Action\ActionManager::hasDefinition(), 0, argumentsSet('plugin.manager.action__plugin_ids'));
  expectedArguments(\Drupal\Core\Action\ActionManager::processDefinition(), 1, argumentsSet('plugin.manager.action__plugin_ids'));

  // -- plugin.manager.archiver.
  override(\Drupal\Core\Archiver\ArchiverManager::createInstance(), map(['' => '\Drupal\Core\Archiver\ArchiverInterface']));
  override(\Drupal\Core\Archiver\ArchiverManager::getInstance(), map(['' => '\Drupal\Core\Archiver\ArchiverInterface|bool']));
  registerArgumentsSet('plugin.manager.archiver__plugin_ids',
    'Tar',
    'Zip',
  );
  expectedArguments(\Drupal\Core\Archiver\ArchiverManager::createInstance(), 0, argumentsSet('plugin.manager.archiver__plugin_ids'));
  expectedArguments(\Drupal\Core\Archiver\ArchiverManager::getDefinition(), 0, argumentsSet('plugin.manager.archiver__plugin_ids'));
  expectedArguments(\Drupal\Core\Archiver\ArchiverManager::hasDefinition(), 0, argumentsSet('plugin.manager.archiver__plugin_ids'));
  expectedArguments(\Drupal\Core\Archiver\ArchiverManager::processDefinition(), 1, argumentsSet('plugin.manager.archiver__plugin_ids'));

  // -- plugin.manager.block.
  override(\Drupal\Core\Block\BlockManager::createInstance(), map(['' => '\Drupal\Core\Block\BlockPluginInterface']));
  override(\Drupal\Core\Block\BlockManager::getInstance(), map(['' => '\Drupal\Core\Block\BlockPluginInterface|bool']));
  override(\Drupal\Core\Block\BlockManagerInterface::createInstance(), map(['' => '\Drupal\Core\Block\BlockPluginInterface']));
  override(\Drupal\Core\Block\BlockManagerInterface::getInstance(), map(['' => '\Drupal\Core\Block\BlockPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.block__plugin_ids',
    'broken',
    'help_block',
    'local_actions_block',
    'local_tasks_block',
    'node_syndicate_block',
    'page_title_block',
    'search_form_block',
    'shortcuts',
    'system_branding_block',
    'system_breadcrumb_block',
    'system_main_block',
    'system_menu_block:account',
    'system_menu_block:admin',
    'system_menu_block:footer',
    'system_menu_block:main',
    'system_menu_block:tools',
    'system_messages_block',
    'system_powered_by_block',
    'user_login_block',
    'views_block:comments_recent-block_1',
    'views_block:content_recent-block_1',
    'views_block:who_s_new-block_1',
    'views_block:who_s_online-who_s_online_block',
  );
  expectedArguments(\Drupal\Core\Block\BlockManager::createInstance(), 0, argumentsSet('plugin.manager.block__plugin_ids'));
  expectedArguments(\Drupal\Core\Block\BlockManager::getDefinition(), 0, argumentsSet('plugin.manager.block__plugin_ids'));
  expectedArguments(\Drupal\Core\Block\BlockManager::hasDefinition(), 0, argumentsSet('plugin.manager.block__plugin_ids'));
  expectedArguments(\Drupal\Core\Block\BlockManager::processDefinition(), 1, argumentsSet('plugin.manager.block__plugin_ids'));
  expectedArguments(\Drupal\Core\Block\BlockManagerInterface::createInstance(), 0, argumentsSet('plugin.manager.block__plugin_ids'));
  expectedArguments(\Drupal\Core\Block\BlockManagerInterface::getDefinition(), 0, argumentsSet('plugin.manager.block__plugin_ids'));
  expectedArguments(\Drupal\Core\Block\BlockManagerInterface::hasDefinition(), 0, argumentsSet('plugin.manager.block__plugin_ids'));
  expectedArguments(\Drupal\Core\Block\BlockManagerInterface::processDefinition(), 1, argumentsSet('plugin.manager.block__plugin_ids'));

  // -- plugin.manager.ckeditor5.plugin.
  override(\Drupal\ckeditor5\Plugin\CKEditor5PluginManager::createInstance(), map(['' => '\Drupal\ckeditor5\Plugin\CKEditor5PluginInterface']));
  override(\Drupal\ckeditor5\Plugin\CKEditor5PluginManager::getInstance(), map(['' => '\Drupal\ckeditor5\Plugin\CKEditor5PluginInterface|bool']));
  override(\Drupal\ckeditor5\Plugin\CKEditor5PluginManagerInterface::createInstance(), map(['' => '\Drupal\ckeditor5\Plugin\CKEditor5PluginInterface']));
  override(\Drupal\ckeditor5\Plugin\CKEditor5PluginManagerInterface::getInstance(), map(['' => '\Drupal\ckeditor5\Plugin\CKEditor5PluginInterface|bool']));
  registerArgumentsSet('plugin.manager.ckeditor5.plugin__plugin_ids',
    'ckeditor5_alignment',
    'ckeditor5_arbitraryHtmlSupport',
    'ckeditor5_blockquote',
    'ckeditor5_bold',
    'ckeditor5_code',
    'ckeditor5_codeBlock',
    'ckeditor5_drupalMediaCaption',
    'ckeditor5_emphasis',
    'ckeditor5_essentials',
    'ckeditor5_globalAttributeDir',
    'ckeditor5_globalAttributeLang',
    'ckeditor5_heading',
    'ckeditor5_horizontalLine',
    'ckeditor5_image',
    'ckeditor5_imageAlign',
    'ckeditor5_imageCaption',
    'ckeditor5_imageResize',
    'ckeditor5_imageUpload',
    'ckeditor5_imageUrl',
    'ckeditor5_indent',
    'ckeditor5_language',
    'ckeditor5_link',
    'ckeditor5_linkImage',
    'ckeditor5_linkMedia',
    'ckeditor5_list',
    'ckeditor5_paragraph',
    'ckeditor5_pasteFromOffice',
    'ckeditor5_removeFormat',
    'ckeditor5_sourceEditing',
    'ckeditor5_specialCharacters',
    'ckeditor5_strikethrough',
    'ckeditor5_style',
    'ckeditor5_subscript',
    'ckeditor5_superscript',
    'ckeditor5_table',
    'ckeditor5_underline',
    'ckeditor5_wildcardHtmlSupport',
  );
  expectedArguments(\Drupal\ckeditor5\Plugin\CKEditor5PluginManager::createInstance(), 0, argumentsSet('plugin.manager.ckeditor5.plugin__plugin_ids'));
  expectedArguments(\Drupal\ckeditor5\Plugin\CKEditor5PluginManager::getDefinition(), 0, argumentsSet('plugin.manager.ckeditor5.plugin__plugin_ids'));
  expectedArguments(\Drupal\ckeditor5\Plugin\CKEditor5PluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.ckeditor5.plugin__plugin_ids'));
  expectedArguments(\Drupal\ckeditor5\Plugin\CKEditor5PluginManager::processDefinition(), 1, argumentsSet('plugin.manager.ckeditor5.plugin__plugin_ids'));
  expectedArguments(\Drupal\ckeditor5\Plugin\CKEditor5PluginManagerInterface::createInstance(), 0, argumentsSet('plugin.manager.ckeditor5.plugin__plugin_ids'));
  expectedArguments(\Drupal\ckeditor5\Plugin\CKEditor5PluginManagerInterface::getDefinition(), 0, argumentsSet('plugin.manager.ckeditor5.plugin__plugin_ids'));
  expectedArguments(\Drupal\ckeditor5\Plugin\CKEditor5PluginManagerInterface::hasDefinition(), 0, argumentsSet('plugin.manager.ckeditor5.plugin__plugin_ids'));
  expectedArguments(\Drupal\ckeditor5\Plugin\CKEditor5PluginManagerInterface::processDefinition(), 1, argumentsSet('plugin.manager.ckeditor5.plugin__plugin_ids'));

  // -- plugin.manager.condition.
  override(\Drupal\Core\Condition\ConditionManager::createInstance(), map(['' => '\Drupal\Core\Condition\ConditionInterface']));
  override(\Drupal\Core\Condition\ConditionManager::getInstance(), map(['' => '\Drupal\Core\Condition\ConditionInterface|bool']));
  registerArgumentsSet('plugin.manager.condition__plugin_ids',
    'current_theme',
    'entity_bundle:block_content',
    'entity_bundle:comment',
    'entity_bundle:contact_message',
    'entity_bundle:menu_link_content',
    'entity_bundle:node',
    'entity_bundle:shortcut',
    'entity_bundle:taxonomy_term',
    'request_path',
    'user_role',
  );
  expectedArguments(\Drupal\Core\Condition\ConditionManager::createInstance(), 0, argumentsSet('plugin.manager.condition__plugin_ids'));
  expectedArguments(\Drupal\Core\Condition\ConditionManager::getDefinition(), 0, argumentsSet('plugin.manager.condition__plugin_ids'));
  expectedArguments(\Drupal\Core\Condition\ConditionManager::hasDefinition(), 0, argumentsSet('plugin.manager.condition__plugin_ids'));
  expectedArguments(\Drupal\Core\Condition\ConditionManager::processDefinition(), 1, argumentsSet('plugin.manager.condition__plugin_ids'));

  // -- plugin.manager.display_variant.
  override(\Drupal\Core\Display\VariantManager::createInstance(), map(['' => '\Drupal\Core\Display\VariantInterface']));
  override(\Drupal\Core\Display\VariantManager::getInstance(), map(['' => '\Drupal\Core\Display\VariantInterface|bool']));
  registerArgumentsSet('plugin.manager.display_variant__plugin_ids',
    'block_page',
    'simple_page',
  );
  expectedArguments(\Drupal\Core\Display\VariantManager::createInstance(), 0, argumentsSet('plugin.manager.display_variant__plugin_ids'));
  expectedArguments(\Drupal\Core\Display\VariantManager::getDefinition(), 0, argumentsSet('plugin.manager.display_variant__plugin_ids'));
  expectedArguments(\Drupal\Core\Display\VariantManager::hasDefinition(), 0, argumentsSet('plugin.manager.display_variant__plugin_ids'));
  expectedArguments(\Drupal\Core\Display\VariantManager::processDefinition(), 1, argumentsSet('plugin.manager.display_variant__plugin_ids'));

  // -- plugin.manager.editor.
  override(\Drupal\editor\Plugin\EditorManager::createInstance(), map(['' => '\Drupal\editor\Plugin\EditorPluginInterface']));
  override(\Drupal\editor\Plugin\EditorManager::getInstance(), map(['' => '\Drupal\editor\Plugin\EditorPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.editor__plugin_ids',
    'ckeditor5',
  );
  expectedArguments(\Drupal\editor\Plugin\EditorManager::createInstance(), 0, argumentsSet('plugin.manager.editor__plugin_ids'));
  expectedArguments(\Drupal\editor\Plugin\EditorManager::getDefinition(), 0, argumentsSet('plugin.manager.editor__plugin_ids'));
  expectedArguments(\Drupal\editor\Plugin\EditorManager::hasDefinition(), 0, argumentsSet('plugin.manager.editor__plugin_ids'));
  expectedArguments(\Drupal\editor\Plugin\EditorManager::processDefinition(), 1, argumentsSet('plugin.manager.editor__plugin_ids'));

  // -- plugin.manager.element_info.
  override(\Drupal\Core\Render\ElementInfoManager::createInstance(), map(['' => '\Drupal\Core\Render\Element\ElementInterface']));
  override(\Drupal\Core\Render\ElementInfoManager::getInstance(), map(['' => '\Drupal\Core\Render\Element\ElementInterface|bool']));
  override(\Drupal\Core\Render\ElementInfoManagerInterface::createInstance(), map(['' => '\Drupal\Core\Render\Element\ElementInterface']));
  override(\Drupal\Core\Render\ElementInfoManagerInterface::getInstance(), map(['' => '\Drupal\Core\Render\Element\ElementInterface|bool']));
  registerArgumentsSet('plugin.manager.element_info__plugin_ids',
    'actions',
    'ajax',
    'break_lock_link',
    'button',
    'checkbox',
    'checkboxes',
    'color',
    'container',
    'contextual_links',
    'contextual_links_placeholder',
    'date',
    'datelist',
    'datetime',
    'details',
    'dropbutton',
    'email',
    'entity_autocomplete',
    'field_ui_table',
    'fieldgroup',
    'fieldset',
    'file',
    'form',
    'hidden',
    'html',
    'html_tag',
    'image_button',
    'inline_template',
    'item',
    'label',
    'language_select',
    'link',
    'machine_name',
    'managed_file',
    'more_link',
    'number',
    'operations',
    'page',
    'page_title',
    'pager',
    'password',
    'password_confirm',
    'path',
    'processed_text',
    'radio',
    'radios',
    'range',
    'search',
    'select',
    'status_messages',
    'status_report',
    'status_report_page',
    'submit',
    'system_compact_link',
    'table',
    'tableselect',
    'tel',
    'text_format',
    'textarea',
    'textfield',
    'token',
    'toolbar',
    'toolbar_item',
    'url',
    'value',
    'vertical_tabs',
    'view',
    'weight',
  );
  expectedArguments(\Drupal\Core\Render\ElementInfoManager::createInstance(), 0, argumentsSet('plugin.manager.element_info__plugin_ids'));
  expectedArguments(\Drupal\Core\Render\ElementInfoManager::getDefinition(), 0, argumentsSet('plugin.manager.element_info__plugin_ids'));
  expectedArguments(\Drupal\Core\Render\ElementInfoManager::hasDefinition(), 0, argumentsSet('plugin.manager.element_info__plugin_ids'));
  expectedArguments(\Drupal\Core\Render\ElementInfoManager::processDefinition(), 1, argumentsSet('plugin.manager.element_info__plugin_ids'));
  expectedArguments(\Drupal\Core\Render\ElementInfoManagerInterface::createInstance(), 0, argumentsSet('plugin.manager.element_info__plugin_ids'));
  expectedArguments(\Drupal\Core\Render\ElementInfoManagerInterface::getDefinition(), 0, argumentsSet('plugin.manager.element_info__plugin_ids'));
  expectedArguments(\Drupal\Core\Render\ElementInfoManagerInterface::hasDefinition(), 0, argumentsSet('plugin.manager.element_info__plugin_ids'));
  expectedArguments(\Drupal\Core\Render\ElementInfoManagerInterface::processDefinition(), 1, argumentsSet('plugin.manager.element_info__plugin_ids'));

  // -- plugin.manager.entity_reference_selection.
  override(\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManager::createInstance(), map(['' => '\Drupal\Core\Entity\EntityReferenceSelection\SelectionInterface']));
  override(\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManager::getInstance(), map(['' => '\Drupal\Core\Entity\EntityReferenceSelection\SelectionInterface|bool']));
  override(\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManagerInterface::createInstance(), map(['' => '\Drupal\Core\Entity\EntityReferenceSelection\SelectionInterface']));
  override(\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManagerInterface::getInstance(), map(['' => '\Drupal\Core\Entity\EntityReferenceSelection\SelectionInterface|bool']));
  registerArgumentsSet('plugin.manager.entity_reference_selection__plugin_ids',
    'broken',
    'default:action',
    'default:base_field_override',
    'default:block',
    'default:block_content',
    'default:block_content_type',
    'default:comment',
    'default:comment_type',
    'default:contact_form',
    'default:contact_message',
    'default:date_format',
    'default:editor',
    'default:entity_form_display',
    'default:entity_form_mode',
    'default:entity_view_display',
    'default:entity_view_mode',
    'default:field_config',
    'default:field_storage_config',
    'default:file',
    'default:filter_format',
    'default:image_style',
    'default:menu',
    'default:menu_link_content',
    'default:node',
    'default:node_type',
    'default:path_alias',
    'default:search_page',
    'default:shortcut',
    'default:shortcut_set',
    'default:taxonomy_term',
    'default:taxonomy_vocabulary',
    'default:tour',
    'default:user',
    'default:user_role',
    'default:view',
    'views',
  );
  expectedArguments(\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManager::createInstance(), 0, argumentsSet('plugin.manager.entity_reference_selection__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.entity_reference_selection__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.entity_reference_selection__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.entity_reference_selection__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManagerInterface::createInstance(), 0, argumentsSet('plugin.manager.entity_reference_selection__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManagerInterface::getDefinition(), 0, argumentsSet('plugin.manager.entity_reference_selection__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManagerInterface::hasDefinition(), 0, argumentsSet('plugin.manager.entity_reference_selection__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityReferenceSelection\SelectionPluginManagerInterface::processDefinition(), 1, argumentsSet('plugin.manager.entity_reference_selection__plugin_ids'));

  // -- plugin.manager.field.field_type.
  override(\Drupal\Core\Field\FieldTypePluginManager::createInstance(), map(['' => '\Drupal\Core\Field\FieldItemInterface']));
  override(\Drupal\Core\Field\FieldTypePluginManager::getInstance(), map(['' => '\Drupal\Core\Field\FieldItemInterface|bool']));
  override(\Drupal\Core\Field\FieldTypePluginManagerInterface::createInstance(), map(['' => '\Drupal\Core\Field\FieldItemInterface']));
  override(\Drupal\Core\Field\FieldTypePluginManagerInterface::getInstance(), map(['' => '\Drupal\Core\Field\FieldItemInterface|bool']));
  registerArgumentsSet('plugin.manager.field.field_type__plugin_ids',
    'boolean',
    'changed',
    'comment',
    'created',
    'datetime',
    'decimal',
    'email',
    'entity_reference',
    'file',
    'file_uri',
    'float',
    'image',
    'integer',
    'language',
    'link',
    'list_float',
    'list_integer',
    'list_string',
    'map',
    'password',
    'path',
    'string',
    'string_long',
    'text',
    'text_long',
    'text_with_summary',
    'timestamp',
    'uri',
    'uuid',
  );
  expectedArguments(\Drupal\Core\Field\FieldTypePluginManager::createInstance(), 0, argumentsSet('plugin.manager.field.field_type__plugin_ids'));
  expectedArguments(\Drupal\Core\Field\FieldTypePluginManager::getDefinition(), 0, argumentsSet('plugin.manager.field.field_type__plugin_ids'));
  expectedArguments(\Drupal\Core\Field\FieldTypePluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.field.field_type__plugin_ids'));
  expectedArguments(\Drupal\Core\Field\FieldTypePluginManager::processDefinition(), 1, argumentsSet('plugin.manager.field.field_type__plugin_ids'));
  expectedArguments(\Drupal\Core\Field\FieldTypePluginManagerInterface::createInstance(), 0, argumentsSet('plugin.manager.field.field_type__plugin_ids'));
  expectedArguments(\Drupal\Core\Field\FieldTypePluginManagerInterface::getDefinition(), 0, argumentsSet('plugin.manager.field.field_type__plugin_ids'));
  expectedArguments(\Drupal\Core\Field\FieldTypePluginManagerInterface::hasDefinition(), 0, argumentsSet('plugin.manager.field.field_type__plugin_ids'));
  expectedArguments(\Drupal\Core\Field\FieldTypePluginManagerInterface::processDefinition(), 1, argumentsSet('plugin.manager.field.field_type__plugin_ids'));

  // -- plugin.manager.field.formatter.
  override(\Drupal\Core\Field\FormatterPluginManager::createInstance(), map(['' => '\Drupal\Core\Field\FormatterInterface']));
  override(\Drupal\Core\Field\FormatterPluginManager::getInstance(), map(['' => '\Drupal\Core\Field\FormatterInterface|bool']));
  registerArgumentsSet('plugin.manager.field.formatter__plugin_ids',
    'author',
    'basic_string',
    'boolean',
    'comment_default',
    'comment_permalink',
    'comment_username',
    'datetime_custom',
    'datetime_default',
    'datetime_plain',
    'datetime_time_ago',
    'email_mailto',
    'entity_reference_entity_id',
    'entity_reference_entity_view',
    'entity_reference_label',
    'entity_reference_rss_category',
    'file_audio',
    'file_default',
    'file_extension',
    'file_filemime',
    'file_link',
    'file_rss_enclosure',
    'file_size',
    'file_table',
    'file_uri',
    'file_url_plain',
    'file_video',
    'image',
    'image_url',
    'language',
    'link',
    'link_separate',
    'list_default',
    'list_key',
    'number_decimal',
    'number_integer',
    'number_unformatted',
    'string',
    'text_default',
    'text_summary_or_trimmed',
    'text_trimmed',
    'timestamp',
    'timestamp_ago',
    'uri_link',
    'user_name',
  );
  expectedArguments(\Drupal\Core\Field\FormatterPluginManager::createInstance(), 0, argumentsSet('plugin.manager.field.formatter__plugin_ids'));
  expectedArguments(\Drupal\Core\Field\FormatterPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.field.formatter__plugin_ids'));
  expectedArguments(\Drupal\Core\Field\FormatterPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.field.formatter__plugin_ids'));
  expectedArguments(\Drupal\Core\Field\FormatterPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.field.formatter__plugin_ids'));

  // -- plugin.manager.field.widget.
  override(\Drupal\Core\Field\WidgetPluginManager::createInstance(), map(['' => '\Drupal\Core\Field\WidgetInterface']));
  override(\Drupal\Core\Field\WidgetPluginManager::getInstance(), map(['' => '\Drupal\Core\Field\WidgetInterface|bool']));
  registerArgumentsSet('plugin.manager.field.widget__plugin_ids',
    'boolean_checkbox',
    'comment_default',
    'datetime_datelist',
    'datetime_default',
    'datetime_timestamp',
    'email_default',
    'entity_reference_autocomplete',
    'entity_reference_autocomplete_tags',
    'file_generic',
    'image_image',
    'language_select',
    'link_default',
    'number',
    'options_buttons',
    'options_select',
    'path',
    'string_textarea',
    'string_textfield',
    'text_textarea',
    'text_textarea_with_summary',
    'text_textfield',
    'uri',
  );
  expectedArguments(\Drupal\Core\Field\WidgetPluginManager::createInstance(), 0, argumentsSet('plugin.manager.field.widget__plugin_ids'));
  expectedArguments(\Drupal\Core\Field\WidgetPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.field.widget__plugin_ids'));
  expectedArguments(\Drupal\Core\Field\WidgetPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.field.widget__plugin_ids'));
  expectedArguments(\Drupal\Core\Field\WidgetPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.field.widget__plugin_ids'));

  // -- plugin.manager.filter.
  override(\Drupal\filter\FilterPluginManager::createInstance(), map(['' => '\Drupal\filter\Plugin\FilterInterface']));
  override(\Drupal\filter\FilterPluginManager::getInstance(), map(['' => '\Drupal\filter\Plugin\FilterInterface|bool']));
  registerArgumentsSet('plugin.manager.filter__plugin_ids',
    'editor_file_reference',
    'filter_align',
    'filter_autop',
    'filter_caption',
    'filter_html',
    'filter_html_escape',
    'filter_html_image_secure',
    'filter_htmlcorrector',
    'filter_image_lazy_load',
    'filter_null',
    'filter_url',
  );
  expectedArguments(\Drupal\filter\FilterPluginManager::createInstance(), 0, argumentsSet('plugin.manager.filter__plugin_ids'));
  expectedArguments(\Drupal\filter\FilterPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.filter__plugin_ids'));
  expectedArguments(\Drupal\filter\FilterPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.filter__plugin_ids'));
  expectedArguments(\Drupal\filter\FilterPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.filter__plugin_ids'));

  // -- plugin.manager.help_section.
  override(\Drupal\help\HelpSectionManager::createInstance(), map(['' => '\Drupal\help\HelpSectionPluginInterface']));
  override(\Drupal\help\HelpSectionManager::getInstance(), map(['' => '\Drupal\help\HelpSectionPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.help_section__plugin_ids',
    'hook_help',
    'tour',
  );
  expectedArguments(\Drupal\help\HelpSectionManager::createInstance(), 0, argumentsSet('plugin.manager.help_section__plugin_ids'));
  expectedArguments(\Drupal\help\HelpSectionManager::getDefinition(), 0, argumentsSet('plugin.manager.help_section__plugin_ids'));
  expectedArguments(\Drupal\help\HelpSectionManager::hasDefinition(), 0, argumentsSet('plugin.manager.help_section__plugin_ids'));
  expectedArguments(\Drupal\help\HelpSectionManager::processDefinition(), 1, argumentsSet('plugin.manager.help_section__plugin_ids'));

  // -- plugin.manager.image.effect.
  override(\Drupal\image\ImageEffectManager::createInstance(), map(['' => '\Drupal\image\ImageEffectInterface']));
  override(\Drupal\image\ImageEffectManager::getInstance(), map(['' => '\Drupal\image\ImageEffectInterface|bool']));
  registerArgumentsSet('plugin.manager.image.effect__plugin_ids',
    'image_convert',
    'image_crop',
    'image_desaturate',
    'image_resize',
    'image_rotate',
    'image_scale',
    'image_scale_and_crop',
  );
  expectedArguments(\Drupal\image\ImageEffectManager::createInstance(), 0, argumentsSet('plugin.manager.image.effect__plugin_ids'));
  expectedArguments(\Drupal\image\ImageEffectManager::getDefinition(), 0, argumentsSet('plugin.manager.image.effect__plugin_ids'));
  expectedArguments(\Drupal\image\ImageEffectManager::hasDefinition(), 0, argumentsSet('plugin.manager.image.effect__plugin_ids'));
  expectedArguments(\Drupal\image\ImageEffectManager::processDefinition(), 1, argumentsSet('plugin.manager.image.effect__plugin_ids'));

  // -- plugin.manager.link_relation_type.
  override(\Drupal\Core\Http\LinkRelationTypeManager::createInstance(), map(['' => '\Drupal\Core\Http\LinkRelationTypeInterface']));
  override(\Drupal\Core\Http\LinkRelationTypeManager::getInstance(), map(['' => '\Drupal\Core\Http\LinkRelationTypeInterface|bool']));
  registerArgumentsSet('plugin.manager.link_relation_type__plugin_ids',
    'about',
    'add-form',
    'add-page',
    'alternate',
    'appendix',
    'archives',
    'author',
    'blocked-by',
    'bookmark',
    'break-lock-form',
    'cancel-form',
    'canonical',
    'chapter',
    'collection',
    'contents',
    'copyright',
    'create',
    'create-form',
    'current',
    'customize-form',
    'delete-form',
    'delete-multiple-form',
    'derivedfrom',
    'describedby',
    'describes',
    'disable',
    'disclosure',
    'dns-prefetch',
    'duplicate',
    'duplicate-form',
    'edit',
    'edit-display-form',
    'edit-form',
    'edit-media',
    'edit-permissions-form',
    'enable',
    'enclosure',
    'entity-permissions-form',
    'first',
    'flush-form',
    'glossary',
    'help',
    'hosts',
    'hub',
    'icon',
    'index',
    'item',
    'last',
    'latest-version',
    'license',
    'lrdd',
    'memento',
    'monitor',
    'monitor-group',
    'next',
    'next-archive',
    'nofollow',
    'noreferrer',
    'original',
    'overview-form',
    'payment',
    'pingback',
    'preconnect',
    'predecessor-version',
    'prefetch',
    'preload',
    'prerender',
    'prev',
    'prev-archive',
    'preview',
    'preview-form',
    'previous',
    'privacy-policy',
    'profile',
    'related',
    'replies',
    'reset-form',
    'revision',
    'revision-delete-form',
    'revision-revert-form',
    'search',
    'section',
    'self',
    'service',
    'set-default',
    'start',
    'stylesheet',
    'subsection',
    'successor-version',
    'tag',
    'terms-of-service',
    'timegate',
    'timemap',
    'type',
    'up',
    'version-history',
    'via',
    'webmention',
    'working-copy',
    'working-copy-of',
  );
  expectedArguments(\Drupal\Core\Http\LinkRelationTypeManager::createInstance(), 0, argumentsSet('plugin.manager.link_relation_type__plugin_ids'));
  expectedArguments(\Drupal\Core\Http\LinkRelationTypeManager::getDefinition(), 0, argumentsSet('plugin.manager.link_relation_type__plugin_ids'));
  expectedArguments(\Drupal\Core\Http\LinkRelationTypeManager::hasDefinition(), 0, argumentsSet('plugin.manager.link_relation_type__plugin_ids'));
  expectedArguments(\Drupal\Core\Http\LinkRelationTypeManager::processDefinition(), 1, argumentsSet('plugin.manager.link_relation_type__plugin_ids'));

  // -- plugin.manager.mail.
  override(\Drupal\Core\Mail\MailManager::createInstance(), map(['' => '\Drupal\Core\Mail\MailInterface']));
  override(\Drupal\Core\Mail\MailManager::getInstance(), map(['' => '\Drupal\Core\Mail\MailInterface|bool']));
  override(\Drupal\Core\Mail\MailManagerInterface::createInstance(), map(['' => '\Drupal\Core\Mail\MailInterface']));
  override(\Drupal\Core\Mail\MailManagerInterface::getInstance(), map(['' => '\Drupal\Core\Mail\MailInterface|bool']));
  registerArgumentsSet('plugin.manager.mail__plugin_ids',
    'php_mail',
    'test_mail_collector',
  );
  expectedArguments(\Drupal\Core\Mail\MailManager::createInstance(), 0, argumentsSet('plugin.manager.mail__plugin_ids'));
  expectedArguments(\Drupal\Core\Mail\MailManager::getDefinition(), 0, argumentsSet('plugin.manager.mail__plugin_ids'));
  expectedArguments(\Drupal\Core\Mail\MailManager::hasDefinition(), 0, argumentsSet('plugin.manager.mail__plugin_ids'));
  expectedArguments(\Drupal\Core\Mail\MailManager::processDefinition(), 1, argumentsSet('plugin.manager.mail__plugin_ids'));
  expectedArguments(\Drupal\Core\Mail\MailManagerInterface::createInstance(), 0, argumentsSet('plugin.manager.mail__plugin_ids'));
  expectedArguments(\Drupal\Core\Mail\MailManagerInterface::getDefinition(), 0, argumentsSet('plugin.manager.mail__plugin_ids'));
  expectedArguments(\Drupal\Core\Mail\MailManagerInterface::hasDefinition(), 0, argumentsSet('plugin.manager.mail__plugin_ids'));
  expectedArguments(\Drupal\Core\Mail\MailManagerInterface::processDefinition(), 1, argumentsSet('plugin.manager.mail__plugin_ids'));

  // -- plugin.manager.menu.contextual_link.
  registerArgumentsSet('plugin.manager.menu.contextual_link__plugin_ids',
    'block_configure',
    'block_content.block_edit',
    'block_remove',
    'entity.menu.edit_form',
    'entity.node.delete_form',
    'entity.node.edit_form',
    'entity.taxonomy_term.delete_form',
    'entity.taxonomy_term.edit_form',
    'entity.taxonomy_vocabulary.delete_form',
    'entity.user_role.delete_form',
    'entity.view.edit_form',
    'entity.view.preview_form',
  );
  expectedArguments(\Drupal\Core\Menu\ContextualLinkManager::createInstance(), 0, argumentsSet('plugin.manager.menu.contextual_link__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\ContextualLinkManager::getDefinition(), 0, argumentsSet('plugin.manager.menu.contextual_link__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\ContextualLinkManager::hasDefinition(), 0, argumentsSet('plugin.manager.menu.contextual_link__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\ContextualLinkManager::processDefinition(), 1, argumentsSet('plugin.manager.menu.contextual_link__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\ContextualLinkManagerInterface::createInstance(), 0, argumentsSet('plugin.manager.menu.contextual_link__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\ContextualLinkManagerInterface::getDefinition(), 0, argumentsSet('plugin.manager.menu.contextual_link__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\ContextualLinkManagerInterface::hasDefinition(), 0, argumentsSet('plugin.manager.menu.contextual_link__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\ContextualLinkManagerInterface::processDefinition(), 1, argumentsSet('plugin.manager.menu.contextual_link__plugin_ids'));

  // -- plugin.manager.menu.local_action.
  registerArgumentsSet('plugin.manager.menu.local_action__plugin_ids',
    'block_content_add_action',
    'block_content_type_add',
    'comment_type_add',
    'contact.form_add',
    'entity.menu.add_form',
    'entity.menu.add_link_form',
    'entity.path_alias.add_form',
    'entity.taxonomy_term.add_form',
    'entity.taxonomy_vocabulary.add_form',
    'field_ui.entity_form_mode_add',
    'field_ui.entity_view_mode_add',
    'field_ui.field_storage_config_add:field_storage_config_add_block_content',
    'field_ui.field_storage_config_add:field_storage_config_add_comment',
    'field_ui.field_storage_config_add:field_storage_config_add_contact_message',
    'field_ui.field_storage_config_add:field_storage_config_add_node',
    'field_ui.field_storage_config_add:field_storage_config_add_taxonomy_term',
    'field_ui.field_storage_config_add:field_storage_config_add_user',
    'filter_format_add_local_action',
    'image_style_add_action',
    'node.add_page',
    'node.type_add',
    'shortcut.link_add',
    'shortcut_set_add_local_action',
    'system.date_format_add',
    'update.module_install',
    'update.report_install',
    'update.theme_install',
    'user.role_add',
    'user_admin_create',
    'views_add_local_action',
  );
  expectedArguments(\Drupal\Core\Menu\LocalActionManager::createInstance(), 0, argumentsSet('plugin.manager.menu.local_action__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalActionManager::getDefinition(), 0, argumentsSet('plugin.manager.menu.local_action__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalActionManager::hasDefinition(), 0, argumentsSet('plugin.manager.menu.local_action__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalActionManager::processDefinition(), 1, argumentsSet('plugin.manager.menu.local_action__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalActionManagerInterface::createInstance(), 0, argumentsSet('plugin.manager.menu.local_action__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalActionManagerInterface::getDefinition(), 0, argumentsSet('plugin.manager.menu.local_action__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalActionManagerInterface::hasDefinition(), 0, argumentsSet('plugin.manager.menu.local_action__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalActionManagerInterface::processDefinition(), 1, argumentsSet('plugin.manager.menu.local_action__plugin_ids'));

  // -- plugin.manager.menu.local_task.
  registerArgumentsSet('plugin.manager.menu.local_task__plugin_ids',
    'block.admin_display',
    'block.admin_display_theme:claro',
    'block.admin_display_theme:olivero',
    'comment.admin',
    'comment.admin_approval',
    'comment.admin_new',
    'config.export',
    'config.export_full',
    'config.export_single',
    'config.import',
    'config.import_full',
    'config.import_single',
    'config.sync',
    'dblog.clear_logs',
    'dblog.view_logs',
    'entity.block.edit_form',
    'entity.block_content.canonical',
    'entity.block_content.collection',
    'entity.block_content.delete_form',
    'entity.block_content_type.edit_form',
    'entity.bundle.permission_form:permissions_block_content_type',
    'entity.bundle.permission_form:permissions_comment_type',
    'entity.bundle.permission_form:permissions_contact_form',
    'entity.bundle.permission_form:permissions_node_type',
    'entity.bundle.permission_form:permissions_taxonomy_vocabulary',
    'entity.comment.canonical_tab',
    'entity.comment.delete_form_tab',
    'entity.comment.edit_form_tab',
    'entity.comment_type.edit_form',
    'entity.contact_form.canonical',
    'entity.contact_form.edit_form',
    'entity.date_format.collection',
    'entity.date_format.edit_form',
    'entity.entity_form_mode.collection',
    'entity.entity_form_mode.edit_form',
    'entity.entity_view_mode.collection',
    'entity.entity_view_mode.edit_form',
    'entity.field_storage_config.collection',
    'entity.filter_format.edit_form_tab',
    'entity.image_style.collection',
    'entity.image_style.edit_form',
    'entity.menu.collection',
    'entity.menu.edit_form',
    'entity.menu_link_content.canonical',
    'entity.node.canonical',
    'entity.node.delete_form',
    'entity.node.edit_form',
    'entity.node.version_history',
    'entity.node_type.collection',
    'entity.node_type.edit_form',
    'entity.path_alias.collection',
    'entity.shortcut.canonical',
    'entity.shortcut_set.customize_form',
    'entity.shortcut_set.edit_form',
    'entity.taxonomy_term.canonical',
    'entity.taxonomy_term.delete_form',
    'entity.taxonomy_term.edit_form',
    'entity.taxonomy_vocabulary.edit_form',
    'entity.taxonomy_vocabulary.overview_form',
    'entity.user.canonical',
    'entity.user.collection',
    'entity.user.contact_form',
    'entity.user.edit_form',
    'entity.user_role.collection',
    'entity.user_role.edit_form',
    'entity.version_history:block_content.version_history',
    'entity.view.edit_form',
    'field_ui.fields:display_overview_block_content',
    'field_ui.fields:display_overview_comment',
    'field_ui.fields:display_overview_contact_message',
    'field_ui.fields:display_overview_node',
    'field_ui.fields:display_overview_taxonomy_term',
    'field_ui.fields:display_overview_user',
    'field_ui.fields:field_display_compact_user',
    'field_ui.fields:field_display_default_block_content',
    'field_ui.fields:field_display_default_comment',
    'field_ui.fields:field_display_default_contact_message',
    'field_ui.fields:field_display_default_node',
    'field_ui.fields:field_display_default_taxonomy_term',
    'field_ui.fields:field_display_default_user',
    'field_ui.fields:field_display_full_block_content',
    'field_ui.fields:field_display_full_comment',
    'field_ui.fields:field_display_full_node',
    'field_ui.fields:field_display_full_taxonomy_term',
    'field_ui.fields:field_display_full_user',
    'field_ui.fields:field_display_rss_node',
    'field_ui.fields:field_display_search_index_node',
    'field_ui.fields:field_display_search_result_node',
    'field_ui.fields:field_display_teaser_node',
    'field_ui.fields:field_edit_block_content',
    'field_ui.fields:field_edit_comment',
    'field_ui.fields:field_edit_contact_message',
    'field_ui.fields:field_edit_node',
    'field_ui.fields:field_edit_taxonomy_term',
    'field_ui.fields:field_edit_user',
    'field_ui.fields:field_form_display_default_block_content',
    'field_ui.fields:field_form_display_default_comment',
    'field_ui.fields:field_form_display_default_contact_message',
    'field_ui.fields:field_form_display_default_node',
    'field_ui.fields:field_form_display_default_taxonomy_term',
    'field_ui.fields:field_form_display_default_user',
    'field_ui.fields:field_form_display_register_user',
    'field_ui.fields:field_storage_block_content',
    'field_ui.fields:field_storage_comment',
    'field_ui.fields:field_storage_contact_message',
    'field_ui.fields:field_storage_node',
    'field_ui.fields:field_storage_taxonomy_term',
    'field_ui.fields:field_storage_user',
    'field_ui.fields:form_display_overview_block_content',
    'field_ui.fields:form_display_overview_comment',
    'field_ui.fields:form_display_overview_contact_message',
    'field_ui.fields:form_display_overview_node',
    'field_ui.fields:form_display_overview_taxonomy_term',
    'field_ui.fields:form_display_overview_user',
    'field_ui.fields:overview_block_content',
    'field_ui.fields:overview_comment',
    'field_ui.fields:overview_contact_message',
    'field_ui.fields:overview_node',
    'field_ui.fields:overview_taxonomy_term',
    'field_ui.fields:overview_user',
    'filter.admin_overview',
    'search.plugins:node_search',
    'search.plugins:user_search',
    'shortcut.set_switch',
    'system.admin',
    'system.admin_content',
    'system.admin_index',
    'system.modules_list',
    'system.modules_uninstall',
    'system.performance_settings',
    'system.rss_feeds_settings_tab',
    'system.site_information_settings_tab',
    'system.site_maintenance_mode_tab',
    'system.theme_settings',
    'system.theme_settings_global',
    'system.theme_settings_theme:claro',
    'system.theme_settings_theme:olivero',
    'system.themes_page',
    'update.module_update',
    'update.report_update',
    'update.settings',
    'update.status',
    'update.theme_update',
    'user.account_settings_tab',
    'user.admin_permissions',
    'user.login',
    'user.pass',
    'user.register',
    'user.role.settings',
    'views_ui.list_tab',
    'views_ui.reports_fields',
    'views_ui.settings_advanced_tab',
    'views_ui.settings_basic_tab',
    'views_ui.settings_tab',
    'views_view:view.files.page_1',
  );
  expectedArguments(\Drupal\Core\Menu\LocalTaskManager::createInstance(), 0, argumentsSet('plugin.manager.menu.local_task__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalTaskManager::getDefinition(), 0, argumentsSet('plugin.manager.menu.local_task__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalTaskManager::hasDefinition(), 0, argumentsSet('plugin.manager.menu.local_task__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalTaskManager::processDefinition(), 1, argumentsSet('plugin.manager.menu.local_task__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalTaskManagerInterface::createInstance(), 0, argumentsSet('plugin.manager.menu.local_task__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalTaskManagerInterface::getDefinition(), 0, argumentsSet('plugin.manager.menu.local_task__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalTaskManagerInterface::hasDefinition(), 0, argumentsSet('plugin.manager.menu.local_task__plugin_ids'));
  expectedArguments(\Drupal\Core\Menu\LocalTaskManagerInterface::processDefinition(), 1, argumentsSet('plugin.manager.menu.local_task__plugin_ids'));

  // -- plugin.manager.queue_worker.
  override(\Drupal\Core\Queue\QueueWorkerManager::createInstance(), map(['' => '\Drupal\Core\Queue\QueueWorkerInterface']));
  override(\Drupal\Core\Queue\QueueWorkerManager::getInstance(), map(['' => '\Drupal\Core\Queue\QueueWorkerInterface|bool']));
  override(\Drupal\Core\Queue\QueueWorkerManagerInterface::createInstance(), map(['' => '\Drupal\Core\Queue\QueueWorkerInterface']));
  override(\Drupal\Core\Queue\QueueWorkerManagerInterface::getInstance(), map(['' => '\Drupal\Core\Queue\QueueWorkerInterface|bool']));

  // -- plugin.manager.search.
  override(\Drupal\search\SearchPluginManager::createInstance(), map(['' => '\Drupal\search\Plugin\SearchInterface']));
  override(\Drupal\search\SearchPluginManager::getInstance(), map(['' => '\Drupal\search\Plugin\SearchInterface|bool']));
  registerArgumentsSet('plugin.manager.search__plugin_ids',
    'node_search',
    'user_search',
  );
  expectedArguments(\Drupal\search\SearchPluginManager::createInstance(), 0, argumentsSet('plugin.manager.search__plugin_ids'));
  expectedArguments(\Drupal\search\SearchPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.search__plugin_ids'));
  expectedArguments(\Drupal\search\SearchPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.search__plugin_ids'));
  expectedArguments(\Drupal\search\SearchPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.search__plugin_ids'));

  // -- plugin.manager.tour.tip.
  override(\Drupal\tour\TipPluginManager::createInstance(), map(['' => '\Drupal\tour\TipPluginInterface']));
  override(\Drupal\tour\TipPluginManager::getInstance(), map(['' => '\Drupal\tour\TipPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.tour.tip__plugin_ids',
    'text',
  );
  expectedArguments(\Drupal\tour\TipPluginManager::createInstance(), 0, argumentsSet('plugin.manager.tour.tip__plugin_ids'));
  expectedArguments(\Drupal\tour\TipPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.tour.tip__plugin_ids'));
  expectedArguments(\Drupal\tour\TipPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.tour.tip__plugin_ids'));
  expectedArguments(\Drupal\tour\TipPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.tour.tip__plugin_ids'));

  // -- plugin.manager.views.access.
  override(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface']));
  override(\Drupal\views\Plugin\ViewsPluginManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.views.access__plugin_ids',
    'none',
    'perm',
    'role',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), 0, argumentsSet('plugin.manager.views.access__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.views.access__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.access__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.views.access__plugin_ids'));

  // -- plugin.manager.views.area.
  override(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsHandlerInterface']));
  override(\Drupal\views\Plugin\ViewsHandlerManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsHandlerInterface|bool']));
  registerArgumentsSet('plugin.manager.views.area__plugin_ids',
    'block_content_listing_empty',
    'broken',
    'display_link',
    'entity',
    'http_status_code',
    'messages',
    'node_listing_empty',
    'result',
    'text',
    'text_custom',
    'title',
    'view',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), 0, argumentsSet('plugin.manager.views.area__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::getDefinition(), 0, argumentsSet('plugin.manager.views.area__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.area__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::processDefinition(), 1, argumentsSet('plugin.manager.views.area__plugin_ids'));

  // -- plugin.manager.views.argument.
  override(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsHandlerInterface']));
  override(\Drupal\views\Plugin\ViewsHandlerManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsHandlerInterface|bool']));
  registerArgumentsSet('plugin.manager.views.argument__plugin_ids',
    'argument_comment_user_uid',
    'broken',
    'date',
    'date_day',
    'date_fulldate',
    'date_month',
    'date_week',
    'date_year',
    'date_year_month',
    'datetime',
    'datetime_day',
    'datetime_full_date',
    'datetime_month',
    'datetime_week',
    'datetime_year',
    'datetime_year_month',
    'file_fid',
    'formula',
    'groupby_numeric',
    'language',
    'many_to_one',
    'node_nid',
    'node_type',
    'node_uid_revision',
    'node_vid',
    'null',
    'number_list_field',
    'numeric',
    'search',
    'standard',
    'string',
    'string_list_field',
    'taxonomy',
    'taxonomy_index_tid',
    'taxonomy_index_tid_depth',
    'taxonomy_index_tid_depth_modifier',
    'user__roles_rid',
    'user_uid',
    'vocabulary_vid',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), 0, argumentsSet('plugin.manager.views.argument__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::getDefinition(), 0, argumentsSet('plugin.manager.views.argument__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.argument__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::processDefinition(), 1, argumentsSet('plugin.manager.views.argument__plugin_ids'));

  // -- plugin.manager.views.argument_default.
  override(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface']));
  override(\Drupal\views\Plugin\ViewsPluginManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.views.argument_default__plugin_ids',
    'current_user',
    'fixed',
    'node',
    'query_parameter',
    'raw',
    'taxonomy_tid',
    'user',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), 0, argumentsSet('plugin.manager.views.argument_default__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.views.argument_default__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.argument_default__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.views.argument_default__plugin_ids'));

  // -- plugin.manager.views.argument_validator.
  override(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface']));
  override(\Drupal\views\Plugin\ViewsPluginManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.views.argument_validator__plugin_ids',
    'entity:action',
    'entity:base_field_override',
    'entity:block',
    'entity:block_content',
    'entity:block_content_type',
    'entity:comment',
    'entity:comment_type',
    'entity:contact_form',
    'entity:contact_message',
    'entity:date_format',
    'entity:editor',
    'entity:entity_form_display',
    'entity:entity_form_mode',
    'entity:entity_view_display',
    'entity:entity_view_mode',
    'entity:field_config',
    'entity:field_storage_config',
    'entity:file',
    'entity:filter_format',
    'entity:image_style',
    'entity:menu',
    'entity:menu_link_content',
    'entity:node',
    'entity:node_type',
    'entity:path_alias',
    'entity:search_page',
    'entity:shortcut',
    'entity:shortcut_set',
    'entity:taxonomy_term',
    'entity:taxonomy_vocabulary',
    'entity:tour',
    'entity:user',
    'entity:user_role',
    'entity:view',
    'none',
    'numeric',
    'taxonomy_term_name',
    'user_name',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), 0, argumentsSet('plugin.manager.views.argument_validator__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.views.argument_validator__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.argument_validator__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.views.argument_validator__plugin_ids'));

  // -- plugin.manager.views.cache.
  override(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface']));
  override(\Drupal\views\Plugin\ViewsPluginManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.views.cache__plugin_ids',
    'none',
    'tag',
    'time',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), 0, argumentsSet('plugin.manager.views.cache__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.views.cache__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.cache__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.views.cache__plugin_ids'));

  // -- plugin.manager.views.display.
  override(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface']));
  override(\Drupal\views\Plugin\ViewsPluginManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.views.display__plugin_ids',
    'attachment',
    'block',
    'default',
    'embed',
    'entity_reference',
    'feed',
    'page',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), 0, argumentsSet('plugin.manager.views.display__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.views.display__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.display__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.views.display__plugin_ids'));

  // -- plugin.manager.views.display_extender.
  override(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface']));
  override(\Drupal\views\Plugin\ViewsPluginManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.views.display_extender__plugin_ids',
    'default',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), 0, argumentsSet('plugin.manager.views.display_extender__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.views.display_extender__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.display_extender__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.views.display_extender__plugin_ids'));

  // -- plugin.manager.views.exposed_form.
  override(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface']));
  override(\Drupal\views\Plugin\ViewsPluginManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.views.exposed_form__plugin_ids',
    'basic',
    'input_required',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), 0, argumentsSet('plugin.manager.views.exposed_form__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.views.exposed_form__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.exposed_form__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.views.exposed_form__plugin_ids'));

  // -- plugin.manager.views.field.
  override(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsHandlerInterface']));
  override(\Drupal\views\Plugin\ViewsHandlerManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsHandlerInterface|bool']));
  registerArgumentsSet('plugin.manager.views.field__plugin_ids',
    'boolean',
    'broken',
    'bulk_form',
    'comment_bulk_form',
    'comment_ces_last_comment_name',
    'comment_ces_last_updated',
    'comment_depth',
    'comment_entity_link',
    'comment_last_timestamp',
    'comment_link_approve',
    'comment_link_reply',
    'commented_entity',
    'contact_link',
    'contextual_links',
    'counter',
    'custom',
    'date',
    'dblog_message',
    'dblog_operations',
    'dropbutton',
    'entity_label',
    'entity_link',
    'entity_link_delete',
    'entity_link_edit',
    'entity_operations',
    'field',
    'file',
    'file_size',
    'history_user_timestamp',
    'language',
    'machine_name',
    'markup',
    'node',
    'node_bulk_form',
    'node_new_comments',
    'node_revision_link',
    'node_revision_link_delete',
    'node_revision_link_revert',
    'numeric',
    'rendered_entity',
    'search_score',
    'serialized',
    'standard',
    'taxonomy_index_tid',
    'term_name',
    'time_interval',
    'url',
    'user_bulk_form',
    'user_data',
    'user_permissions',
    'user_roles',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), 0, argumentsSet('plugin.manager.views.field__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::getDefinition(), 0, argumentsSet('plugin.manager.views.field__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.field__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::processDefinition(), 1, argumentsSet('plugin.manager.views.field__plugin_ids'));

  // -- plugin.manager.views.filter.
  override(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsHandlerInterface']));
  override(\Drupal\views\Plugin\ViewsHandlerManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsHandlerInterface|bool']));
  registerArgumentsSet('plugin.manager.views.filter__plugin_ids',
    'boolean',
    'boolean_string',
    'broken',
    'bundle',
    'combine',
    'comment_ces_last_updated',
    'comment_user_uid',
    'date',
    'datetime',
    'dblog_types',
    'equality',
    'file_status',
    'groupby_numeric',
    'history_user_timestamp',
    'in_operator',
    'language',
    'latest_revision',
    'latest_translation_affected_revision',
    'list_field',
    'many_to_one',
    'node_access',
    'node_comment',
    'node_status',
    'node_uid_revision',
    'numeric',
    'search_keywords',
    'standard',
    'string',
    'taxonomy_index_tid',
    'taxonomy_index_tid_depth',
    'user_current',
    'user_name',
    'user_permissions',
    'user_roles',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), 0, argumentsSet('plugin.manager.views.filter__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::getDefinition(), 0, argumentsSet('plugin.manager.views.filter__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.filter__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::processDefinition(), 1, argumentsSet('plugin.manager.views.filter__plugin_ids'));

  // -- plugin.manager.views.join.
  override(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\join\JoinPluginInterface']));
  override(\Drupal\views\Plugin\ViewsHandlerManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\join\JoinPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.views.join__plugin_ids',
    'field_or_language_join',
    'standard',
    'subquery',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), 0, argumentsSet('plugin.manager.views.join__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::getDefinition(), 0, argumentsSet('plugin.manager.views.join__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.join__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::processDefinition(), 1, argumentsSet('plugin.manager.views.join__plugin_ids'));

  // -- plugin.manager.views.pager.
  override(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface']));
  override(\Drupal\views\Plugin\ViewsPluginManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.views.pager__plugin_ids',
    'full',
    'mini',
    'none',
    'some',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), 0, argumentsSet('plugin.manager.views.pager__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.views.pager__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.pager__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.views.pager__plugin_ids'));

  // -- plugin.manager.views.query.
  override(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface']));
  override(\Drupal\views\Plugin\ViewsPluginManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.views.query__plugin_ids',
    'views_query',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), 0, argumentsSet('plugin.manager.views.query__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.views.query__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.query__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.views.query__plugin_ids'));

  // -- plugin.manager.views.relationship.
  override(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsHandlerInterface']));
  override(\Drupal\views\Plugin\ViewsHandlerManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsHandlerInterface|bool']));
  registerArgumentsSet('plugin.manager.views.relationship__plugin_ids',
    'broken',
    'entity_reverse',
    'groupwise_max',
    'node_term_data',
    'standard',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), 0, argumentsSet('plugin.manager.views.relationship__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::getDefinition(), 0, argumentsSet('plugin.manager.views.relationship__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.relationship__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::processDefinition(), 1, argumentsSet('plugin.manager.views.relationship__plugin_ids'));

  // -- plugin.manager.views.row.
  override(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface']));
  override(\Drupal\views\Plugin\ViewsPluginManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.views.row__plugin_ids',
    'comment_rss',
    'entity:block_content',
    'entity:comment',
    'entity:file',
    'entity:node',
    'entity:taxonomy_term',
    'entity:user',
    'entity_reference',
    'fields',
    'node_rss',
    'opml_fields',
    'rss_fields',
    'search_view',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), 0, argumentsSet('plugin.manager.views.row__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.views.row__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.row__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.views.row__plugin_ids'));

  // -- plugin.manager.views.sort.
  override(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsHandlerInterface']));
  override(\Drupal\views\Plugin\ViewsHandlerManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsHandlerInterface|bool']));
  registerArgumentsSet('plugin.manager.views.sort__plugin_ids',
    'broken',
    'comment_ces_last_comment_name',
    'comment_ces_last_updated',
    'comment_thread',
    'date',
    'datetime',
    'groupby_numeric',
    'random',
    'search_score',
    'standard',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::createInstance(), 0, argumentsSet('plugin.manager.views.sort__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::getDefinition(), 0, argumentsSet('plugin.manager.views.sort__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.sort__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsHandlerManager::processDefinition(), 1, argumentsSet('plugin.manager.views.sort__plugin_ids'));

  // -- plugin.manager.views.style.
  override(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface']));
  override(\Drupal\views\Plugin\ViewsPluginManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.views.style__plugin_ids',
    'default',
    'default_summary',
    'entity_reference',
    'grid',
    'grid_responsive',
    'html_list',
    'opml',
    'rss',
    'table',
    'unformatted_summary',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), 0, argumentsSet('plugin.manager.views.style__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.views.style__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.style__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.views.style__plugin_ids'));

  // -- plugin.manager.views.wizard.
  override(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface']));
  override(\Drupal\views\Plugin\ViewsPluginManager::getInstance(), map(['' => '\Drupal\views\Plugin\views\ViewsPluginInterface|bool']));
  registerArgumentsSet('plugin.manager.views.wizard__plugin_ids',
    'block_content',
    'comment',
    'file_managed',
    'node',
    'node_revision',
    'standard:block_content_field_revision',
    'standard:taxonomy_term_field_revision',
    'taxonomy_term',
    'users',
    'watchdog',
  );
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::createInstance(), 0, argumentsSet('plugin.manager.views.wizard__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::getDefinition(), 0, argumentsSet('plugin.manager.views.wizard__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::hasDefinition(), 0, argumentsSet('plugin.manager.views.wizard__plugin_ids'));
  expectedArguments(\Drupal\views\Plugin\ViewsPluginManager::processDefinition(), 1, argumentsSet('plugin.manager.views.wizard__plugin_ids'));

  // -- typed_data_manager.
  registerArgumentsSet('typed_data_manager__plugin_ids',
    'any',
    'binary',
    'boolean',
    'datetime_iso8601',
    'duration_iso8601',
    'email',
    'entity',
    'entity:action',
    'entity:base_field_override',
    'entity:block',
    'entity:block_content',
    'entity:block_content:basic',
    'entity:block_content_type',
    'entity:comment',
    'entity:comment:comment',
    'entity:comment_type',
    'entity:contact_form',
    'entity:contact_message',
    'entity:contact_message:feedback',
    'entity:contact_message:personal',
    'entity:date_format',
    'entity:editor',
    'entity:entity_form_display',
    'entity:entity_form_mode',
    'entity:entity_view_display',
    'entity:entity_view_mode',
    'entity:field_config',
    'entity:field_storage_config',
    'entity:file',
    'entity:filter_format',
    'entity:image_style',
    'entity:menu',
    'entity:menu_link_content',
    'entity:menu_link_content:menu_link_content',
    'entity:node',
    'entity:node:article',
    'entity:node:page',
    'entity:node_type',
    'entity:path_alias',
    'entity:search_page',
    'entity:shortcut',
    'entity:shortcut:default',
    'entity:shortcut_set',
    'entity:taxonomy_term',
    'entity:taxonomy_term:tags',
    'entity:taxonomy_vocabulary',
    'entity:tour',
    'entity:user',
    'entity:user_role',
    'entity:view',
    'entity_reference',
    'field_item:boolean',
    'field_item:changed',
    'field_item:comment',
    'field_item:created',
    'field_item:datetime',
    'field_item:decimal',
    'field_item:email',
    'field_item:entity_reference',
    'field_item:file',
    'field_item:file_uri',
    'field_item:float',
    'field_item:image',
    'field_item:integer',
    'field_item:language',
    'field_item:link',
    'field_item:list_float',
    'field_item:list_integer',
    'field_item:list_string',
    'field_item:map',
    'field_item:password',
    'field_item:path',
    'field_item:string',
    'field_item:string_long',
    'field_item:text',
    'field_item:text_long',
    'field_item:text_with_summary',
    'field_item:timestamp',
    'field_item:uri',
    'field_item:uuid',
    'filter_format',
    'float',
    'integer',
    'language',
    'language_reference',
    'list',
    'map',
    'string',
    'timespan',
    'timestamp',
    'uri',
  );
  expectedArguments(\Drupal\Core\TypedData\TypedDataManager::createInstance(), 0, argumentsSet('typed_data_manager__plugin_ids'));
  expectedArguments(\Drupal\Core\TypedData\TypedDataManager::getDefinition(), 0, argumentsSet('typed_data_manager__plugin_ids'));
  expectedArguments(\Drupal\Core\TypedData\TypedDataManager::hasDefinition(), 0, argumentsSet('typed_data_manager__plugin_ids'));
  expectedArguments(\Drupal\Core\TypedData\TypedDataManager::processDefinition(), 1, argumentsSet('typed_data_manager__plugin_ids'));
  expectedArguments(\Drupal\Core\TypedData\TypedDataManagerInterface::createInstance(), 0, argumentsSet('typed_data_manager__plugin_ids'));
  expectedArguments(\Drupal\Core\TypedData\TypedDataManagerInterface::getDefinition(), 0, argumentsSet('typed_data_manager__plugin_ids'));
  expectedArguments(\Drupal\Core\TypedData\TypedDataManagerInterface::hasDefinition(), 0, argumentsSet('typed_data_manager__plugin_ids'));
  expectedArguments(\Drupal\Core\TypedData\TypedDataManagerInterface::processDefinition(), 1, argumentsSet('typed_data_manager__plugin_ids'));

  // -- validation.constraint.
  registerArgumentsSet('validation.constraint__plugin_ids',
    'AllowedValues',
    'Blank',
    'BlockContentEntityChanged',
    'Bundle',
    'CKEditor5Element',
    'CKEditor5EnabledConfigurablePlugins',
    'CKEditor5FundamentalCompatibility',
    'CKEditor5MediaAndFilterSettingsInSync',
    'CKEditor5ToolbarItem',
    'CKEditor5ToolbarItemConditionsMet',
    'CKEditor5ToolbarItemDependencyConstraint',
    'Callback',
    'Choice',
    'CommentName',
    'ComplexData',
    'ConfigExists',
    'Count',
    'DateTimeFormat',
    'Email',
    'EntityChanged',
    'EntityHasField',
    'EntityType',
    'EntityUntranslatableFields',
    'ExtensionExists',
    'ExtensionName',
    'FileUriUnique',
    'FileValidation',
    'Length',
    'LinkAccess',
    'LinkExternalProtocols',
    'LinkNotExistingInternal',
    'LinkType',
    'MenuSettings',
    'MenuTreeHierarchy',
    'NotBlank',
    'NotNull',
    'Null',
    'PathAlias',
    'PluginExists',
    'PrimitiveType',
    'ProtectedUserField',
    'Range',
    'ReferenceAccess',
    'Regex',
    'RequiredConfigDependencies',
    'SourceEditingPreventSelfXssConstraint',
    'SourceEditingRedundantTags',
    'StyleSensibleElement',
    'TaxonomyHierarchy',
    'UniqueField',
    'UniqueLabelInList',
    'UniquePathAlias',
    'UserMailRequired',
    'UserMailUnique',
    'UserName',
    'UserNameUnique',
    'Uuid',
    'ValidKeys',
    'ValidPath',
    'ValidReference',
  );
  expectedArguments(\Drupal\Core\Validation\ConstraintManager::createInstance(), 0, argumentsSet('validation.constraint__plugin_ids'));
  expectedArguments(\Drupal\Core\Validation\ConstraintManager::getDefinition(), 0, argumentsSet('validation.constraint__plugin_ids'));
  expectedArguments(\Drupal\Core\Validation\ConstraintManager::hasDefinition(), 0, argumentsSet('validation.constraint__plugin_ids'));
  expectedArguments(\Drupal\Core\Validation\ConstraintManager::processDefinition(), 1, argumentsSet('validation.constraint__plugin_ids'));
  expectedArguments(\Drupal\Core\Entity\EntityTypeInterface::addConstraint(), 0, argumentsSet('validation.constraint__plugin_ids'));
  expectedArguments(\Drupal\Core\TypedData\DataDefinitionInterface::addConstraint(), 0, argumentsSet('validation.constraint__plugin_ids'));

}
