<?php /** @noinspection ALL */

namespace PHPSTORM_META {
  registerArgumentsSet('state_names',
    'comment.maintain_entity_statistics',
    'comment.node_comment_statistics_scale',
    'install_task',
    'install_time',
    'node.min_max_update_time',
    'router.path_roots',
    'routing.menu_masks.router',
    'routing.non_admin_routes',
    'system.cron_key',
    'system.cron_last',
    'system.css_js_query_string',
    'system.private_key',
    'system.profile.files',
    'system.theme.files',
    'twig_extension_hash_prefix',
    'update.last_check',
    'views.view_route_names',
  );
  expectedArguments(\Drupal\Core\State\StateInterface::get(), 0, argumentsSet('state_names'));
  expectedArguments(\Drupal\Core\State\StateInterface::set(), 0, argumentsSet('state_names'));
  expectedArguments(\Drupal\Core\State\StateInterface::delete(), 0, argumentsSet('state_names'));
}

