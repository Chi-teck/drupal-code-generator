<?php

namespace Drush\Commands;

use Consolidation\AnnotatedCommand\CommandData;

/**
 * Site policy.
 */
class PolicyCommands extends DrushCommands {

  /**
   * Limit sql-sync operations to remote sites.
   *
   * @hook validate sql:sync
   *
   * @throws \Exception
   */
  public function sqlSyncValidate(CommandData $commandData) {
    $target = $commandData->input()->getArgument('target');
    if ($target != '@local') {
      throw new \Exception(dt('Per !file, you may never overwrite the remote database.', ['!file' => __FILE__]));
    }
  }

  /**
   * Limit rsync operations to remote sites.
   *
   * @hook validate core:rsync
   *
   * @throws \Exception
   */
  public function rsyncValidate(CommandData $commandData) {
    $target = $commandData->input()->getArgument('target');
    if (strpos($target, '@prod') == 0) {
      throw new \Exception(dt('Per !file, you may never rsync to the remote site.', ['!file' => __FILE__]));
    }
  }

}
