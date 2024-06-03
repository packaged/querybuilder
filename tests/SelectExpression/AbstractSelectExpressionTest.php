<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\Segments\SelectExpressionAssembler;
use Packaged\QueryBuilder\SelectExpression\ISelectExpression;

class AbstractSelectExpressionTest extends \PHPUnit\Framework\TestCase
{
  /**
   * @expectedException \RuntimeException
   * @expectedExceptionMessage Unsupported segment
   */
  public function testUnknown()
  {
    $assembler = new SelectExpressionAssembler(new UnknownSelectExpression());
    $assembler->assemble();
  }
}

class UnknownSelectExpression implements ISelectExpression
{
}
