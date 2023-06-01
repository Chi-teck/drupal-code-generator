<?php declare(strict_types = 1);

namespace Drupal\foo\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Example type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "foo_example_type",
 *   label = @Translation("Example type"),
 *   label_collection = @Translation("Example types"),
 *   label_singular = @Translation("example type"),
 *   label_plural = @Translation("examples types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count examples type",
 *     plural = "@count examples types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\foo\Form\FooExampleTypeForm",
 *       "edit" = "Drupal\foo\Form\FooExampleTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\foo\FooExampleTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer foo_example types",
 *   bundle_of = "foo_example",
 *   config_prefix = "foo_example_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/foo_example_types/add",
 *     "edit-form" = "/admin/structure/foo_example_types/manage/{foo_example_type}",
 *     "delete-form" = "/admin/structure/foo_example_types/manage/{foo_example_type}/delete",
 *     "collection" = "/admin/structure/foo_example_types",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   },
 * )
 */
final class FooExampleType extends ConfigEntityBundleBase {

  /**
   * The machine name of this example type.
   */
  protected string $id;

  /**
   * The human-readable name of the example type.
   */
  protected string $label;

}
