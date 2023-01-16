<?php declare(strict_types = 1);

namespace Drupal\foo\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\foo\FooExampleInterface;

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
 *     "list_builder" = "Drupal\foo\FooExampleListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\foo\Form\FooExampleForm",
 *       "edit" = "Drupal\foo\Form\FooExampleForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\foo\Routing\FooExampleHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "foo_example",
 *   admin_permission = "administer foo example",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/foo-example",
 *     "add-form" = "/example/add",
 *     "canonical" = "/example/{foo_example}",
 *     "edit-form" = "/example/{foo_example}",
 *     "delete-form" = "/example/{foo_example}/delete",
 *   },
 * )
 */
final class FooExample extends ContentEntityBase implements FooExampleInterface {

}
