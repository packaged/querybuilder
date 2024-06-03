<?php
namespace Packaged\Tests\QueryBuilder\SelectExpression;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\SelectExpression\CustomSelectExpression;

class CustomSelectExpressionTest extends \PHPUnit\Framework\TestCase
{
  public function testCustomSelectExpression()
  {
    $this->assertEquals(
      'MY_CUSTOM_FUNCTION(doodads,foobar) AS custom',
      QueryAssembler::stringify(
        CustomSelectExpression::createWithAlias(
          'MY_CUSTOM_FUNCTION(doodads,foobar)',
          'custom'
        )
      )
    );
  }
}
