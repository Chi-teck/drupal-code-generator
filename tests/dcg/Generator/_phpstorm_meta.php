<?php

namespace PHPSTORM_META {

  override(
    \Drupal::service(0),
    map([
      'foo' => '\Foo',
    ])
  );

  override(
    \Drupal\Core\Entity\EntityTypeManagerInterface::getStorage(0),
    map([
      'example' => '\StorageExample',
    ])
  );

  override(
    \Drupal\Core\Entity\EntityTypeManagerInterface::getViewBuilder(0),
    map([
      'example' => '\Foo\BarViewBuilder',
    ])
  );

  override(
    \Drupal\Core\Entity\EntityTypeManagerInterface::getListBuilder(0),
    map([
      'example' => '\Bar\FooListBuilder',
    ])
  );

  override(
    \Drupal\Core\Entity\EntityTypeManagerInterface::getAccessControlHandler(0),
    map([
     'example' => '\AccessControlExample',
    ])
  );

  override(\EntityTypeExample::loadMultiple(), map(['' => '\EntityTypeExample[]']));
  override(\EntityTypeExample::load(), map(['' => '\EntityTypeExample']));
  override(\EntityTypeExample::create(), map(['' => '\EntityTypeExample']));

  expectedReturnValues(
    \Drupal\Core\Entity\EntityInterface::save(),
    \SAVED_NEW,
    \SAVED_UPDATED
  );

  expectedArguments(
    \Drupal\Core\Entity\EntityViewBuilderInterface::view(),
    2,
    \Drupal\Core\Language\LanguageInterface::LANGCODE_NOT_SPECIFIED,
    \Drupal\Core\Language\LanguageInterface::LANGCODE_NOT_APPLICABLE,
    \Drupal\Core\Language\LanguageInterface::LANGCODE_DEFAULT,
    \Drupal\Core\Language\LanguageInterface::LANGCODE_SITE_DEFAULT
  );

  expectedArguments(
    \Drupal\Core\Messenger\MessengerInterface::addMessage(),
    1,
    \Drupal\Core\Messenger\MessengerInterface::TYPE_STATUS,
    \Drupal\Core\Messenger\MessengerInterface::TYPE_WARNING,
    \Drupal\Core\Messenger\MessengerInterface::TYPE_ERROR
  );

  expectedArguments(
    \Drupal\Core\File\FileSystemInterface::prepareDirectory(),
    1,
    \Drupal\Core\File\FileSystemInterface::CREATE_DIRECTORY,
    \Drupal\Core\File\FileSystemInterface::MODIFY_PERMISSIONS
  );

  expectedArguments(
    \Drupal\Core\File\FileSystemInterface::copy(),
    2,
    \Drupal\Core\File\FileSystemInterface::EXISTS_RENAME,
    \Drupal\Core\File\FileSystemInterface::EXISTS_REPLACE,
    \Drupal\Core\File\FileSystemInterface::EXISTS_ERROR
  );

  expectedArguments(
    \Drupal\Core\File\FileSystemInterface::move(),
    2,
    \Drupal\Core\File\FileSystemInterface::EXISTS_RENAME,
    \Drupal\Core\File\FileSystemInterface::EXISTS_REPLACE,
    \Drupal\Core\File\FileSystemInterface::EXISTS_ERROR
  );

  expectedArguments(
    \Drupal\Core\File\FileSystemInterface::saveData(),
    2,
    \Drupal\Core\File\FileSystemInterface::EXISTS_RENAME,
    \Drupal\Core\File\FileSystemInterface::EXISTS_REPLACE,
    \Drupal\Core\File\FileSystemInterface::EXISTS_ERROR
  );

  expectedArguments(
    \Drupal\Core\File\FileSystemInterface::getDestinationFilename(),
    1,
    \Drupal\Core\File\FileSystemInterface::EXISTS_RENAME,
    \Drupal\Core\File\FileSystemInterface::EXISTS_REPLACE,
    \Drupal\Core\File\FileSystemInterface::EXISTS_ERROR
  );

}
