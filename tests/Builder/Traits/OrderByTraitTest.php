<?php
namespace Packaged\Tests\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Builder\Traits\OrderByTrait;
use Packaged\QueryBuilder\Clause\OrderByClause;
use Packaged\QueryBuilder\Statement\AbstractStatement;

class OrderByTraitTest extends \PHPUnit_Framework_TestCase
{
  public function testCreate()
  {
    $class = new FinalOrderByTrait();
    $class->orderBy('one');
    $this->assertEquals("ORDER BY one", $this->_getClause($class)->assemble());

    $class->orderBy('one', 'two');
    $this->assertEquals(
      "ORDER BY one, two",
      $this->_getClause($class)->assemble()
    );

    $class->orderBy(['one', 'two', 'three' => 'ASC']);
    $this->assertEquals(
      "ORDER BY one, two, three ASC",
      $this->_getClause($class)->assemble()
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
