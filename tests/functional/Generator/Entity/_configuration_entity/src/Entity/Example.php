<?php declare(strict_types = 1);

namespace Drupal\foo\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\foo\ExampleInterface;

/**
 * Defines the example entity type.
 *
 * @ConfigEntityType(
 *   id = "example",
 *   label = @Translation("Example"),
 *   label_collection = @Translation("Examples"),
 *   label_singular = @Translation("example"),
 *   label_plural = @Translation("examples"),
 *   label_count = @PluralTranslation(
 *     singular = "@count example",
 *     plural = "@count examples",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\foo\ExampleListBuilder",
 *     "form" = {
 *       "add" = "Drupal\foo\Form\ExampleForm",
 *       "edit" = "Drupal\foo\Form\ExampleForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *   },
 *   config_prefix = "example",
 *   admin_permission = "administer example",
 *   links = {
 *     "collection" = "/admin/structure/example",
 *     "add-form" = "/admin/structure/example/add",
 *     "edit-form" = "/admin/structure/example/{example}",
 *     "delete-form" = "/admin/structure/example/{example}/delete",
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *   },
 * )
 */
final class Example extends ConfigEntityBase implements ExampleInterface {

  /**
   * The example ID.
   */
  protected string $id;

  /**
   * The example label.
   */
  protected string $label;

  /**
   * The example description.
   */
  protected string $description;

}
