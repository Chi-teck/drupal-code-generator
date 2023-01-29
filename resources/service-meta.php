<?php declare(strict_types = 1);

use Drupal\Core\Entity\EntityTypeManagerInterface;

return [
  'entity_type.manager' => [
    'name' => 'entityTypeManager',
    'type' => EntityTypeManagerInterface::class,
  ],
];
