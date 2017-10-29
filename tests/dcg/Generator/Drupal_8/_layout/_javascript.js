/**
 * @file
 * Custom behaviors for foo bar layout.
 */

(function (Drupal) {

  'use strict';

  Drupal.behaviors.fooBar = {
    attach: function (context, settings) {

      console.log('It works!');

    }
  };

} (Drupal));
