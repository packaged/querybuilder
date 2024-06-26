<?php
namespace Packaged\Tests\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\Traits\WhereTrait;
use Packaged\QueryBuilder\Statement\AbstractStatement;

class WhereTraitTest extends \PHPUnit\Framework\TestCase
{
  public function testCreate()
  {
    $class = new FinalWhereTrait();
    $class->where(['username' => 'test', 'status' => 'pending']);
    $this->assertEquals(
      'WHERE username = "test" AND status = "pending"',
      QueryAssembler::stringify($class)
    );

    $class->orWhere(['username' => 'testing', 'status' => 'active']);
    $this->assertEquals(
      'WHERE (username = "test" AND status = "pending") '
      . 'OR (username = "testing" AND status = "active")',
      QueryAssembler::stringify($class)
    );

    $class->andWhere(['username' => 'tested', 'status' => 'disabled']);
    $this->assertEquals(
      'WHERE ((username = "test" AND status = "pending") '
      . 'OR (username = "testing" AND status = "active")) '
      . 'AND (username = "tested" AND status = "disabled")',
      QueryAssembler::stringify($class)
    );
  }

  public function testException()
  {
    $class = new FinalWhereTrait();
    $this->expectException(
      'RuntimeException',
      'You can only use andWhere and orWhere after specifying a where clause'
    );
    $class->orWhere();
  }
}

class FinalWhereTrait extends AbstractStatement
{
  use WhereTrait;

  protected function _getOrder()
  {
    return ["WHERE"];
  }
}
