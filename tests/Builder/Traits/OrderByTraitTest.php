<?php
namespace Packaged\Tests\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\Traits\OrderByTrait;
use Packaged\QueryBuilder\Clause\OrderByClause;
use Packaged\QueryBuilder\Statement\AbstractStatement;

class OrderByTraitTest extends \PHPUnit\Framework\TestCase
{
  public function testCreate()
  {
    $class = new FinalOrderByTrait();
    $class->orderBy('one');
    $this->assertEquals(
      "ORDER BY one",
      QueryAssembler::stringify($this->_getClause($class))
    );

    $class->orderBy('one', 'two');
    $this->assertEquals(
      "ORDER BY one, two",
      QueryAssembler::stringify($this->_getClause($class))
    );

    $class->orderBy(['one', 'two', 'three' => 'ASC']);
    $this->assertEquals(
      "ORDER BY one, two, three ASC",
      QueryAssembler::stringify($this->_getClause($class))
    );
  }

  /**
   * @param FinalOrderByTrait $class
   *
   * @return OrderByClause
   */
  protected function _getClause(FinalOrderByTrait $class)
  {
    return $class->getClause("ORDERBY");
  }
}

class FinalOrderByTrait extends AbstractStatement
{
  use OrderByTrait;

  protected function _getOrder()
  {
    return [];
  }
}
