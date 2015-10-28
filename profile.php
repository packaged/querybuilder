<?php
use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Predicate\EqualPredicate;
use Packaged\QueryBuilder\SelectExpression\AllSelectExpression;

include_once('vendor/autoload.php');

for($i = 0; $i < 100; $i++)
{
  $start = microtime(true);

  $query = QueryBuilder::select(new AllSelectExpression());
  $query->from('table');
  $query->where(['a' => 'b', 'c' => 'd']);
  $query->andWhere(
    [EqualPredicate::create('e', 'f'), EqualPredicate::create('g', 'h')]
  );

  QueryAssembler::stringify($query);
  echo "Completed In: " . (microtime(true) - $start);
  echo PHP_EOL;
}
