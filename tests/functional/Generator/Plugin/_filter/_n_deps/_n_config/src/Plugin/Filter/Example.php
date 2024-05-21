<?php

declare(strict_types=1);

namespace Drupal\foo\Plugin\Filter;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\filter\Attribute\Filter;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\filter\Plugin\FilterInterface;

/**
 * @todo Add filter description here.
 */
#[Filter(
  id: 'foo_example',
  title: new TranslatableMarkup('Example'),
  type: FilterInterface::TYPE_MARKUP_LANGUAGE,
)]
final class Example extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode): FilterProcessResult {
    // @todo Process text here.
    return new FilterProcessResult($text);
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE): string {
    return (string) $this->t('@todo Provide filter tips here.');
  }

}
