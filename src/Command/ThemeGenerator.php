<?php

namespace DrupalCodeGenerator\Command;

/**
 * Base class for theme generators.
 */
abstract class ThemeGenerator extends DrupalGenerator {

  protected $nameQuestion = 'Theme name';
  protected $machineNameQuestion = 'Theme machine name';

}
