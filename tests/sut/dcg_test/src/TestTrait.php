<?php declare(strict_types = 1);

namespace Drupal\dcg_test;

use Behat\Mink\Element\NodeElement;

/**
 * Helper methods for browser tests.
 */
trait TestTrait {

  /**
   * Checks that an element exists on the current page.
   *
   * @param string $selector
   *   The XPath identifying the element to check.
   */
  protected function assertXpath(string $selector): void {
    // Add some syntactic sugar.
    $selector = \preg_replace('/next::([a-z]+)/', 'following-sibling::\1[1]', $selector);
    $this->assertSession()->elementExists('xpath', $selector);
  }

  /**
   * Checks that an element does not exist on the current page.
   *
   * @param string $selector
   *   The XPath identifying the element to check.
   */
  protected function assertNoXpath(string $selector): void {
    $this->assertSession()->elementNotExists('xpath', $selector);
  }

  /**
   * Finds Drupal messages on the page.
   *
   * @param string $type
   *   A message type (e.g. status, warning, error).
   *
   * @return string[]
   *   List of found messages.
   */
  protected function getMessages(string $type): array {
    $messages = [];
    $get_message = static function (NodeElement $element): string {
      // Remove hidden heading.
      $message = \preg_replace('#<h2[^>]*>.*</h2>#', '', $element->getHtml());
      $message = \strip_tags($message, '<em>');
      return \trim(\preg_replace('#\s+#', ' ', $message));
    };
    $xpath = '//div[@aria-label="' . \ucfirst($type) . ' message"]';
    // Error messages have one more wrapper.
    if ($type == 'error') {
      $xpath .= '/div[@role = "alert"]';
    }
    $wrapper = $this->xpath($xpath);
    if (!empty($wrapper[0])) {
      unset($wrapper[0]->h2);
      $items = $wrapper[0]->findAll('xpath', '/ul/li');
      // Multiple messages are rendered with an HTML list.
      $messages = \count($items) > 0 ?
        \array_map($get_message, $items) : [$get_message($wrapper[0])];
    }
    return $messages;
  }

  /**
   * Passes if a given error message was found on the page.
   */
  protected function assertErrorMessage(string|\Stringable $message): void {
    $messages = $this->getMessages('error');
    self::assertContains((string) $message, $messages, 'Error message was found.');
  }

  /**
   * Passes if a given warning message was found on the page.
   */
  protected function assertWarningMessage(string|\Stringable $message): void {
    $messages = $this->getMessages('warning');
    self::assertContains((string) $message, $messages, 'Warning message was found.');
  }

  /**
   * Passes if a given status message was found on the page.
   */
  protected function assertStatusMessage(string|\Stringable $message): void {
    $messages = $this->getMessages('status');
    self::assertContains((string) $message, $messages, 'Status message was found.');
  }

  /**
   * Passes if expected page title was found.
   */
  protected function assertPageTitle(string|\Stringable $title): void {
    $title_element = $this->xpath('//h1');
    if (\count($title_element) === 0) {
      self::fail('Page title was not found.');
    }
    self::assertSame((string) $title, \trim(\strip_tags($title_element[0]->getHtml(), '<em>')));
  }

}
