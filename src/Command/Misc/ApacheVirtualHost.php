<?php

namespace DrupalCodeGenerator\Command\Misc;

use DrupalCodeGenerator\Command\Generator;

/**
 * Implements misc:apache-virtual-host command.
 */
final class ApacheVirtualHost extends Generator {

  protected $name = 'misc:apache-virtual-host';
  protected $description = 'Generates an Apache site configuration file';
  protected $alias = 'apache-virtual-host';
  protected $destination = '/etc/apache2/sites-available';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $this->vars['hostname'] = $this->ask('Host name', 'example.com');
    $this->vars['docroot'] = $this->ask('Document root', '/var/www/{hostname}/public');
    $this->addFile('{hostname}.conf', 'misc/apache-virtual-host');
  }

}
