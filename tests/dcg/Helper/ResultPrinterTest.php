<?php

namespace DrupalCodeGenerator\Tests\Helper;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Helper\ResultPrinter;
use DrupalCodeGenerator\Style\GeneratorStyle;
use DrupalCodeGenerator\Tests\QuestionHelper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A test for output handler.
 */
class ResultPrinterTest extends TestCase {

  /**
   * Test callback.
   */
  public function testResultPrinter() :void {

    $input = new ArgvInput();
    $output = new BufferedOutput();

    $helper_set = new HelperSet();
    $helper_set->set(new QuestionHelper());

    $question_helper = new QuestionHelper();
    $io = new GeneratorStyle($input, $output, $question_helper);

    $printer = new ResultPrinter();
    $printer->setHelperSet($helper_set);

    self::assertEquals('result_printer', $printer->getName());

    $printer->io($io);

    $assets = new AssetCollection();
    $assets[] = (new File('bbb/eee/ggg.php'));
    $assets[] = (new File('aaa/ddd.txt'))->content('123');
    $assets[] = (new File('ccc'))->content("123\n456\789");
    $assets[] = (new File('aaa'))->content('123');
    $assets[] = (new File('bbb/fff.module'));

    // -- Default output.
    $printer->printResult($assets);
    $expected_output = "\n";
    $expected_output .= " The following directories and files have been created or updated:\n";
    $expected_output .= "–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––\n";
    $expected_output .= implode([
      " • aaa\n",
      " • ccc\n",
      " • aaa/ddd.txt\n",
      " • bbb/fff.module\n",
      " • bbb/eee/ggg.php\n",
      "\n",
    ]);
    self::assertEquals($expected_output, $output->fetch());

    // -- Output with base path.
    $printer->printResult($assets, 'project/root/');
    $expected_output = "\n";
    $expected_output .= " The following directories and files have been created or updated:\n";
    $expected_output .= "–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––\n";
    $expected_output .= implode([
      " • project/root/aaa\n",
      " • project/root/ccc\n",
      " • project/root/aaa/ddd.txt\n",
      " • project/root/bbb/fff.module\n",
      " • project/root/bbb/eee/ggg.php\n",
      "\n",
    ]);
    self::assertEquals($expected_output, $output->fetch());

    // Empty output.
    $printer->printResult(new AssetCollection());
    self::assertEquals('', $output->fetch());

    // Verbose output.
    $output->setVerbosity(OutputInterface::VERBOSITY_VERBOSE);
    $printer->printResult($assets);
    $expected_output = "\n";
    $expected_output .= " The following directories and files have been created or updated:\n";
    $expected_output .= "–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––\n";
    $expected_output .= implode([
      " ------ ----------------- ------- ------ \n",
      "  Type   Path              Lines   Size  \n",
      " ------ ----------------- ------- ------ \n",
      "  file   aaa                   1      3  \n",
      "  file   ccc                   2     10  \n",
      "  file   aaa/ddd.txt           1      3  \n",
      "  file   bbb/fff.module        0      0  \n",
      "  file   bbb/eee/ggg.php       0      0  \n",
      " ------ ----------------- ------- ------ \n",
      "         Total: 5 assets       4   16 B  \n",
      " ------ ----------------- ------- ------ \n",
      "\n",
    ]);
    self::markTestSkipped('TODO: Figure out appropriate sort order first');
    // self::assertEquals($expected_output, $output->fetch());
  }

}
