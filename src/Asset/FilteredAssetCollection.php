<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset;

/**
 * Filters assets by type
 */
final class FilteredAssetCollection extends \FilterIterator {

  public function __construct(
    AssetCollection $assets,
    private readonly string $interface,
  ) {
    parent::__construct($assets->getIterator());
  }

  /**
   * @inheritDoc
   */
  public function accept(): bool {
    return $this->getInnerIterator()->current() instanceof $this->interface;
  }

}
\class_alias(FilteredAssetCollection::class, '\DrupalCodeGenerator\Asset\FilteredAssets');
