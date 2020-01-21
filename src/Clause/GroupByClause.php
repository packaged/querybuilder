<?php
namespace Packaged\QueryBuilder\Clause;

class GroupByClause extends AbstractFieldClause
{
  /**
   * @return string
   */
  public function getAction()
  {
    return 'GROUP BY';
  }

  public static function create($fields)
  {
    $groupClause = new static();
    if(func_num_args() > 1)
    {
      foreach(func_get_args() as $field)
      {
        $groupClause->addField($field);
      }
    }
    else if(is_array($fields))
    {
      foreach($fields as $field)
      {
        $groupClause->addField($field);
      }
    }
    else
    {
      $groupClause->addField($fields);
    }
    return $groupClause;
  }
}
