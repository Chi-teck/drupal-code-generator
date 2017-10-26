/**
 * @file
 * Example CKEditor plugin.
 *
 * Basic plugin inserting abbreviation elements into the CKEditor editing area.
 *
 * @DCG The code is based on an example from CKEditor Plugin SDK tutorial.
 *
 * @see http://docs.ckeditor.com/#!/guide/plugin_sdk_sample_1
 */
(function (Drupal) {

  'use strict';

  CKEDITOR.plugins.add('foo_example', {

    // Register the icons.
    icons: 'example',

    // The plugin initialization logic goes inside this method.
    init: function(editor) {

      // Define an editor command that opens our dialog window.
      editor.addCommand('example', new CKEDITOR.dialogCommand('exampleDialog'));

      // Create a toolbar button that executes the above command.
      editor.ui.addButton('example', {

        // The text part of the button (if available) and the tooltip.
        label: Drupal.t('Insert abbreviation'),

        // The command to execute on click.
        command: 'example',

        // The button placement in the toolbar (toolbar group name).
        toolbar: 'insert'
      });

      // Register our dialog file, this.path is the plugin folder path.
      CKEDITOR.dialog.add('exampleDialog', this.path + 'dialogs/example.js');
    }
  });

} (Drupal));
