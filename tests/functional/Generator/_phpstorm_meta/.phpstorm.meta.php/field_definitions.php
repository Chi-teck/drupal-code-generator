<?php declare(strict_types = 1);

namespace PHPSTORM_META {

  registerArgumentsSet('display_context',
    'view',
    'form',
  );
  expectedArguments(\Drupal\Core\Field\FieldDefinitionInterface::getDisplayOptions(), 0, argumentsSet('display_context'));
  expectedArguments(\Drupal\Core\Field\BaseFieldDefinition::setDisplayOptions(), 0, argumentsSet('display_context'));
  expectedArguments(\Drupal\Core\Field\BaseFieldDefinition::getDisplayOptions(), 0, argumentsSet('display_context'));
  expectedArguments(\Drupal\Core\Field\BaseFieldDefinition::setDisplayConfigurable(), 0, argumentsSet('display_context'));
  expectedArguments(\Drupal\Core\Field\BaseFieldDefinition::isDisplayConfigurable(), 0, argumentsSet('display_context'));

  registerArgumentsSet('entity_types',
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
  expectedReturnValues(\Drupal\Core\Field\FieldDefinitionInterface::getTargetEntityTypeId(), argumentsSet('entity_types'));

  registerArgumentsSet('field_types',
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
  expectedArguments(\Drupal\Core\Field\BaseFieldDefinition::create(), 0, argumentsSet('field_types'));
  expectedReturnValues(\Drupal\Core\Field\FieldDefinitionInterface::getType(), argumentsSet('field_types'));

  expectedArguments(\Drupal\Core\Field\BaseFieldDefinition::setCardinality(), 0,  \Drupal\Core\Field\FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED);
  expectedReturnValues(\Drupal\Core\Field\BaseFieldDefinition::getCardinality(), \Drupal\Core\Field\FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED);

}
