<?php declare(strict_types = 1);

namespace Drupal\foo\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\foo\ExampleInterface;

/**
 * Defines the example entity class.
 *
 * @ContentEntityType(
 *   id = "foo_example",
 *   label = @Translation("Example"),
 *   label_collection = @Translation("Examples"),
 *   label_singular = @Translation("example"),
 *   label_plural = @Translation("examples"),
 *   label_count = @PluralTranslation(
 *     singular = "@count examples",
 *     plural = "@count examples",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\foo\ExampleListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\foo\Form\ExampleForm",
 *       "edit" = "Drupal\foo\Form\ExampleForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "delete-multiple-confirm" = "Drupal\Core\Entity\Form\DeleteMultipleForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\foo\Routing\ExampleHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "foo_example",
 *   admin_permission = "administer examples",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/example",
 *     "add-form" = "/example/add",
 *     "canonical" = "/example/{foo_example}",
 *     "edit-form" = "/example/{foo_example}",
 *     "delete-form" = "/example/{foo_example}/delete",
 *     "delete-multiple-form" = "/admin/content/example/delete-multiple",
 *   },
 * )
 */
final class Example extends ContentEntityBase implements ExampleInterface {

}
