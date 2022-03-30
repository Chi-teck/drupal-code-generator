<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Compatibility;

if (\PHP_VERSION_ID >= 80000) {
  \class_alias(
    '\DrupalCodeGenerator\Compatibility\Php8\AskQuestionTrait',
    '\DrupalCodeGenerator\Compatibility\AskQuestionTrait'
  );
}
else {
  \class_alias(
    '\DrupalCodeGenerator\Compatibility\Php7\AskQuestionTrait',
    '\DrupalCodeGenerator\Compatibility\AskQuestionTrait'
  );
}
