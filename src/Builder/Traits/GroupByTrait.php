<?php
namespace Packaged\QueryBuilder\Builder\Traits;

use Packaged\QueryBuilder\Clause\GroupByClause;
use Packaged\QueryBuilder\Expression\FieldExpression;
use Packaged\QueryBuilder\Statement\StatementInterface;

trait GroupByTrait
{
  public function groupBy($fields)
  {
    /**
     * @var $this StatementInterface
     */

    $groupClause = new GroupByClause();
    if(func_num_args() > 1)
    {
      foreach(func_get_args() as $field)
      {
        $groupClause->addField(FieldExpression::create($field));
      }
    }
    else if(is_array($fields))
    {
      foreach($fields as $field)
      {
        $groupClause->addField(FieldExpression::create($field));
      }
    }
    else if(is_scalar($fields))
    {
      $groupClause->addField(FieldExpression::create($fields));
    }

    $this->addClause($groupClause);
    return $this;
  }
}
