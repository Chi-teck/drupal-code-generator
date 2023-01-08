<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Miscellaneous;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\Chained;
use DrupalCodeGenerator\Validator\Required;

#[Generator(
  name: 'misc:apache-virtual-host',
  description: 'Generates an Apache site configuration file',
  aliases: ['apache-virtual-host'],
  templatePath: Application::TEMPLATE_PATH . '/Miscellaneous/_apache-virtual-host',
  type: GeneratorType::OTHER,
)]
final class ApacheVirtualHost extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $vars['hostname'] = $this->io()->ask('Host name', 'example.local', self::getDomainValidator());
    $vars['docroot'] = $this->io()->ask('Document root', \DRUPAL_ROOT);
    $assets->addFile('{hostname}.conf', 'host.twig');
    $assets->addFile('{hostname}-ssl.conf', 'host-ssl.twig');
  }

  /**
   * Builds domain validator.
   */
  private static function getDomainValidator(): callable {
    return new Chained(
      new Required(),
      static function (string $value): string {
        if (!\filter_var($value, \FILTER_VALIDATE_DOMAIN, \FILTER_FLAG_HOSTNAME)) {
          throw new \UnexpectedValueException('The value is not correct domain name.');
        }
        return $value;
      },
    );
  }

}
