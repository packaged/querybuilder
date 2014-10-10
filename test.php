<?php
include_once('vendor/autoload.php');

$query = \Packaged\QueryBuilder\Builder\QueryBuilder::select('username', 'name')
  ->from('here')
  ->join('there', 'user_id')
  ->where(['name' => 'Brooke'])
  ->orderBy(['userid' => 'ASC'])
  ->groupBy('role')
  ->having(['apples' => 4])
  ->limitWithOffset(10, 12);

$assemble = new \Packaged\QueryBuilder\Assembler\QueryAssembler($query);
echo $assemble->assemble();

echo "\n";

$assemble = new \Packaged\QueryBuilder\Assembler\MySQL\MySQLAssembler($query);
echo $assemble->assemble();

echo "\n";
