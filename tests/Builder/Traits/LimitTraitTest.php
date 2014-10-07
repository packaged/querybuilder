<?php
namespace Packaged\Tests\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Builder\Traits\LimitTrait;
use Packaged\QueryBuilder\Statement\AbstractStatement;

class LimitTraitTest extends \PHPUnit_Framework_TestCase
{
  public function testCreate()
  {
    $class = new FinalLimitTrait();
    $class->limit(1);
    $this->assertEquals('LIMIT 1', $class->assemble());
    $class->limitWithOffset(10, 1);
    $this->assertEquals('LIMIT 10,1', $class->assemble());
  }
}

class FinalLimitTrait extends AbstractStatement
{
  use LimitTrait;

  protected function _getOrder()
  {
    return ["LIMIT"];
  }
}
