<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Helper\Renderer;
use PHPUnit\Framework\TestCase;

/**
 * A test for renderer helper.
 */
class RendererTest extends TestCase {

  /**
   * Test callback.
   */
  public function testRenderer() {
    $twig = dcg_get_twig_environment(new \Twig_Loader_Filesystem());
    $renderer = new Renderer($twig);
    static::assertEquals($renderer->getName(), 'dcg_renderer');
    $renderer->addPath(__DIR__);
    $content = $renderer->render('_renderer-fixture.twig', ['value' => 'foo']);
    static::assertEquals($content, "The value is: foo\n");
  }

}
