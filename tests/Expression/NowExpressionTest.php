<?php
namespace Packaged\Tests\QueryBuilder\Expression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Expression\NowExpression;

class NowExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testAssemble()
  {
    $expression = new NowExpression();
    $this->assertEquals('NOW()', QueryAssembler::stringify($expression));
  }
}
