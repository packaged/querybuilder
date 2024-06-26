<?php
namespace Packaged\Tests\QueryBuilder\Builder\Traits;

use Packaged\Helpers\Arrays;
use Packaged\QueryBuilder\Builder\Traits\GroupByTrait;
use Packaged\QueryBuilder\Clause\GroupByClause;
use Packaged\QueryBuilder\Statement\AbstractStatement;
use PHPUnit\Framework\TestCase;

class GroupByTraitTest extends TestCase
{
  public function testCreate()
  {
    $class = new FinalGroupByTrait();
    $class->groupBy('one', 'two', 'three');
    $this->assertTrue(
      $this->_verifyClause(
        $class->getClause('GROUPBY'),
        ['one', 'two', 'three']
      ),
      "Group by parameters"
    );

    $class->groupBy(['one', 'two', 'three']);
    $this->assertTrue(
      $this->_verifyClause(
        $class->getClause('GROUPBY'),
        ['one', 'two', 'three']
      ),
      "Group by Array of fields"
    );

    $class->groupBy('field');
    $this->assertTrue(
      $this->_verifyClause(
        $class->getClause('GROUPBY'),
        ['field']
      ),
      "Group By field"
    );
  }

  protected function _verifyClause(GroupByClause $clause, $fields)
  {
    $fields = Arrays::fuse($fields);
    foreach($clause->getFields() as $field)
    {
      unset($fields[$field->getField()]);
    }

    return empty($fields);
  }
}

class FinalGroupByTrait extends AbstractStatement
{
  use GroupByTrait;

  protected function _getOrder()
  {
    return [];
  }
}
