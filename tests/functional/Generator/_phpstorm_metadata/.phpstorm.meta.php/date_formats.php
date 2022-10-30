<?php /** @noinspection ALL */

namespace PHPSTORM_META {
  registerArgumentsSet('date_formats',
    'fallback',
    'html_date',
    'html_datetime',
    'html_month',
    'html_time',
    'html_week',
    'html_year',
    'html_yearless_date',
    'long',
    'medium',
    'olivero_medium',
    'short',
    'custom',
  );
  expectedArguments(\Drupal\Core\Datetime\DateFormatter::format(), 1, argumentsSet('date_formats'));
}
