/**
 * @file
 * Foo behaviors.
 */
(function (Drupal) {

  'use strict';

  Drupal.behaviors.foo = {
    attach: function (context, settings) {

      console.log('It works!');

    }
  };

} (Drupal));
