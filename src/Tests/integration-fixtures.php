<?php
return [
  [
    'answers' => [
      '<comment>Drupal 6</comment>',
      '<comment>Component</comment>',
      'MODULE.info',
      'Example',
      'example',
    ],
    'output' => [
      'Command: d6:component:module-info',
      '---------------------------------',
      'The following files have been created:',
      '- example.info',
    ],
  ],
  [
    'answers' => [
      '<comment>Drupal 7</comment>',
      '<comment>Component</comment>',
      '<comment>Ctools plugin</comment>',
      'Content type',
      'Example',
      'example',
    ],
    'output' => [
      'Command: d7:component:ctools-plugin:content-type',
      '------------------------------------------------',
      'The following files have been created:',
      '- example.inc',
    ],
  ],
  [
    'answers' => [
      '<comment>Drupal 7</comment>',
      '<comment>Component</comment>',
      'MODULE.module',
      'Example',
      'example',
    ],
    'output' => [
      'Command: d7:component:module-file',
      '---------------------------------',
      'The following files have been created:',
      '- example.module',
    ],
  ],
  [
    'answers' => [
      '<comment>Drupal 7</comment>',
      '<comment>Component</comment>',
      // Test jumping on upper menu level.
      '..',
      '<comment>Component</comment>',
      'settings.php',
    ],
    'output' => [
      'Command: d7:component:settings.php',
      '----------------------------------',
      'The following files have been created:',
      '- settings.php',
    ],
  ],

  [
    'answers' => [
      '<comment>Drupal 8</comment>',
      '<comment>Component</comment>',
      '<comment>Plugin</comment>',
      'Field formatter',
      'Foo',
      'foo',
      'Zoo',
    ],
    'output' => [
      'Command: d8:component:plugin:field-formatter',
      '--------------------------------------------',
      'The following files have been created:',
      '- ZooFormatter.php',
    ],
  ],
  [
    'answers' => [
      '<comment>Drupal 8</comment>',
      '<comment>Component</comment>',
      'Test',
      'Foo',
      'foo',
      'Example',
    ],
    'output' => [
      'Command: d8:component:test',
      '--------------------------',
      'The following files have been created:',
      '- ExampleTest.php',
    ],
  ]
];
