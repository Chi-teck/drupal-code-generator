<?php
return [
  [
    'answers' => [
      '<comment>Drupal 6</comment>',
      '<comment>Component</comment>',
      '.info file (module)',
      'Example',
      'example',
    ],
    'output' => [
      'Command: d6:component:module-info-file',
      '--------------------------------------',
      'The following files have been created:',
      '- example.info',
    ],
  ],
  [
    'answers' => [
      '<comment>Drupal 7</comment>',
      '<comment>Component</comment>',
      '<comment>Ctools plugin</comment>',
      'Access',
      'Example',
      'example',
    ],
    'output' => [
      'Command: d7:component:ctools-plugin:access',
      '------------------------------------------',
      'The following files have been created:',
      '- example.inc',
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
      '<comment>Ctools plugin</comment>',
      'Relationship',
      'Example',
      'example',
    ],
    'output' => [
      'Command: d7:component:ctools-plugin:relationship',
      '------------------------------------------------',
      'The following files have been created:',
      '- example.inc',
    ],
  ],
  [
    'answers' => [
      '<comment>Drupal 7</comment>',
      '<comment>Component</comment>',
      '.info file (module)',
      'Example',
      'example',
    ],
    'output' => [
      'Command: d7:component:module-info-file',
      '--------------------------------------',
      'The following files have been created:',
      '- example.info',
    ],
  ],
  [
    'answers' => [
      '<comment>Drupal 7</comment>',
      '<comment>Component</comment>',
      '.info file (theme)',
      'Example',
      'example',
      'example',
      'example',
    ],
    'output' => [
      'Command: d7:component:theme-info-file',
      '-------------------------------------',
      'The following files have been created:',
      '- example.info',
    ],
  ],
  [
    'answers' => [
      '<comment>Drupal 7</comment>',
      '<comment>Component</comment>',
      '.install file',
      'Example',
      'example',
    ],
    'output' => [
      'Command: d7:component:install-file',
      '----------------------------------',
      'The following files have been created:',
      '- example.install',
    ],
  ],
  [
    'answers' => [
      '<comment>Drupal 7</comment>',
      '<comment>Component</comment>',
      'Javascript file',
      'Example',
      'example',
    ],
    'output' => [
      'Command: d7:component:js-file',
      '-----------------------------',
      'The following files have been created:',
      '- example.js',
    ],
  ],
  [
    'answers' => [
      '<comment>Drupal 7</comment>',
      '<comment>Component</comment>',
      '.module file',
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
      '<comment>Drupal 7</comment>',
      '<comment>Component</comment>',
      // Test jumping on upper menu level.
      '..',
      '<comment>Component</comment>',
      'template.php',
    ],
    'output' => [
      'Command: d7:component:template.php',
      '----------------------------------',
      'The following files have been created:',
      '- template.php',
    ],
  ],
  [
    'answers' => [
      '<comment>Drupal 7</comment>',
      'Module',
      'Example',
      'example',
    ],
    'output' => [
      'Command: d7:module',
      '------------------',
      'The following files have been created:',
      '- example/example.info',
      '- example/example.module',
      '- example/example.install',
      '- example/example.admin.inc',
      '- example/example.pages.inc',
      '- example/example.test',
      '- example/example.js',
    ],
  ],
  [
    'answers' => [
      '<comment>Drupal 8</comment>',
      '<comment>Component</comment>',
      '<comment>Plugin</comment>',
      'Filter',
      'Example',
      'example',
    ],
    'output' => [
      'Command: d8:component:plugin:filter',
      '-----------------------------------',
      'The following files have been created:',
      '- Example.php',
    ],
  ],
  [
    'answers' => [
      '<comment>Drupal 8</comment>',
      'Module',
      'Example',
      'example',
    ],
    'output' => [
      'Command: d8:module',
      '------------------',
      'The following files have been created:',
      '- example/example.info.yml',
      '- example/example.module',
      '- example/example.install',
    ]
  ],
  [
    'answers' => [
      '<comment>Other</comment>',
      'Apache virtual host',
      'example.com',
    ],
    'output' => [
      'Command: other:apache-virtual-host',
      '----------------------------------',
      'The following files have been created:',
      '- example.com.conf',
    ],
  ],
  [
    'answers' => [
      '<comment>Other</comment>',
      'Drush command',
      'Example',
      'example',
    ],
    'output' => [
      'Command: other:drush-command',
      '----------------------------',
      'The following files have been created:',
      '- example.drush.inc',
    ],
  ],
  [
    'answers' => [
      '<comment>Other</comment>',
      'HTML page',
      'index.html',
    ],
    'output' => [
      'Command: other:html-page',
      '------------------------',
      'The following files have been created:',
      '- index.html',
      '- css/main.css',
      '- js/main.js',
    ],
  ],
];
