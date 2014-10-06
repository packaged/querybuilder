<?php
namespace Expect;

use Packaged\QueryBuilder\Builder\QueryBuilder;
use Packaged\QueryBuilder\Expression\IncrementExpression;
use Packaged\QueryBuilder\Expression\MultiplyExpression;
use Packaged\QueryBuilder\Expression\UnixTimestampExpression;
use Packaged\QueryBuilder\Predicate\LessThanPredicate;

//http://book.cakephp.org/2.0/en/models/retrieving-your-data.html#complex-find-conditions

QueryBuilder::select('field', 'field2')
  ->from('table')
  ->join('details', 'id', 'user_id')
  ->join('emails', 'email')//When one key specified, used key on both sides
  ->join('comments', 'id', 'author', ['active' => 1])//Where
  ->where(['username' => 'test'])
  ->orWhere(['username' => 'tester'])
  ->groupBy('role')
  ->orderBy(['id' => 'DESC'])
  ->having(['count' => 23])
  ->limit(10);
//SELECT field, field2 FROM table JOIN details ON table.id = details.user_id
//JOIN comments ON table.id = comments.author AND comments.active = 1
//WHERE username = "test" OR username = "tester" GROUP BY role
//HAVING count = 23 ORDER BY id DESC LIMIT 10

QueryBuilder::max('id')->from('table');
//SELECT MAX(id) FROM table

QueryBuilder::insert(['username' => 'test', 'age' => 123])
  ->into('users');
//INSERT INTO users (username, age) VALUES ("test", 123)

QueryBuilder::replace(['username' => 'test', 'age' => 123])
  ->into('users');
//REPLACE INTO users (username, age) VALUES ("test", 123)

QueryBuilder::update('users')
  ->set(['username' => 'test'])
  ->where(['age' => 123]);
//UPDATE users SET username = "test" WHERE age = 123

QueryBuilder::deleteFrom('users')->where(['username' => 'test']);

//DELETE FROM users WHERE username = "test"

//UPDATE export_ranges SET locked_by=%s WHERE locked_by IS NULL
//AND ( last_processed IS NULL OR (last_processed + (60 * `interval`)) <= UNIX_TIMESTAMP())
//ORDER BY last_processed + (60 * `interval`) ASC LIMIT 1

$lpPredicate = IncrementExpression::create(
  'last_processed',
  MultiplyExpression::create('interval', 60)
);

QuerBuilder::update('export_ranges')
  ->set(['locked_by' => 'abc'])
  ->where(['locked_by' => null])
  //multiple arrays passed to where should imply OR
  ->andWhere(
    ['last_processed' => null],
    [LessThanPredicate::create($lpPredicate, new UnixTimestampExpression())]
  )
  ->orderBy($lpPredicate, 'ASC')
  ->limit(1);
