<?php

declare(strict_types=1);

namespace Drupal\foo\Entity;

use Drupal\Core\Entity\Attribute\ContentEntityType;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\Entity\Form\DeleteMultipleForm;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\foo\ExampleInterface;
use Drupal\foo\ExampleListBuilder;
use Drupal\foo\Form\ExampleForm;
use Drupal\foo\Routing\ExampleHtmlRouteProvider;
use Drupal\views\EntityViewsData;

/**
 * Defines the example entity class.
 */
#[ContentEntityType(
  id: 'foo_example',
  label: new TranslatableMarkup('Example'),
  label_collection: new TranslatableMarkup('Examples'),
  label_singular: new TranslatableMarkup('example'),
  label_plural: new TranslatableMarkup('examples'),
  entity_keys: [
    'id' => 'id',
    'label' => 'id',
    'uuid' => 'uuid',
  ],
  handlers: [
    'list_builder' => ExampleListBuilder::class,
    'views_data' => EntityViewsData::class,
    'form' => [
      'add' => ExampleForm::class,
      'edit' => ExampleForm::class,
      'delete' => ContentEntityDeleteForm::class,
      'delete-multiple-confirm' => DeleteMultipleForm::class,
    ],
    'route_provider' => [
      'html' => ExampleHtmlRouteProvider::class,
    ],
  ],
  links: [
    'collection' => '/admin/content/example',
    'add-form' => '/example/add',
    'canonical' => '/example/{foo_example}',
    'edit-form' => '/example/{foo_example}',
    'delete-form' => '/example/{foo_example}/delete',
    'delete-multiple-form' => '/admin/content/example/delete-multiple',
  ],
  admin_permission: 'administer foo_example',
  base_table: 'foo_example',
  label_count: [
    'singular' => '@count examples',
    'plural' => '@count examples',
  ],
)]
class Example extends ContentEntityBase implements ExampleInterface {

}
