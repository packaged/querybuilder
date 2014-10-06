<?php
namespace Packaged\Tests\QueryBuilder\Builder\Expect;

use Packaged\QueryBuilder\Builder\QueryBuilder;

class QueryBuilderSelectTest extends \PHPUnit_Framework_TestCase
{
  public function testSelect()
  {
    $query = QueryBuilder::select('field', 'field2');

    $this->assertEquals(
      'SELECT field, field2',
      $query->assemble()
    );
  }

  public function testFrom()
  {
    $query = QueryBuilder::select('field', 'field2');
    $query->from('table');

    $this->assertEquals(
      'SELECT field, field2'
      . ' FROM table',
      $query->assemble()
    );
  }

  public function testJoin()
  {
    $query = QueryBuilder::select('field', 'field2');
    $query->from('table');
    $query->join('details', 'id', 'user_id');

    $this->assertEquals(
      'SELECT field, field2'
      . ' FROM table'
      . ' JOIN details ON table.id = details.user_id',
      $query->assemble()
    );
  }

  public function testJoinSameKey()
  {
    $query = QueryBuilder::select('field', 'field2');
    $query->from('table');
    $query->join('details', 'id', 'user_id');
    //When one key specified, used key on both sides
    $query->join('emails', 'email');

    $this->assertEquals(
      'SELECT field, field2'
      . ' FROM table'
      . ' JOIN details ON table.id = details.user_id'
      . ' JOIN emails ON table.email = emails.email',
      $query->assemble()
    );
  }

  public function testJoinWhere()
  {
    $query = QueryBuilder::select('field', 'field2');
    $query->from('table');
    $query->join('details', 'id', 'user_id');
    $query->join('emails', 'email');
    //Join Where
    $query->join('comments', 'id', 'author', ['active' => 1]);

    $this->assertEquals(
      'SELECT field, field2'
      . ' FROM table'
      . ' JOIN details ON table.id = details.user_id'
      . ' JOIN emails ON table.email = emails.email'
      . ' JOIN comments ON table.id = comments.author AND comments.active = 1',
      $query->assemble()
    );
  }

  public function testWhere()
  {
    $query = QueryBuilder::select('field', 'field2');
    $query->from('table');
    $query->join('details', 'id', 'user_id');
    $query->join('emails', 'email');
    $query->join('comments', 'id', 'author', ['active' => 1]);
    $query->where(['username' => 'test']);

    $this->assertEquals(
      'SELECT field, field2'
      . ' FROM table'
      . ' JOIN details ON table.id = details.user_id'
      . ' JOIN emails ON table.email = emails.email'
      . ' JOIN comments ON table.id = comments.author AND comments.active = 1'
      . ' WHERE username = "test"',
      $query->assemble()
    );
  }

  public function testOrWhere()
  {
    $query = QueryBuilder::select('field', 'field2');
    $query->from('table');
    $query->join('details', 'id', 'user_id');
    $query->join('emails', 'email');
    $query->join('comments', 'id', 'author', ['active' => 1]);
    $query->where(['username' => 'test']);
    $query->orWhere(['username' => 'tester']);

    $this->assertEquals(
      'SELECT field, field2'
      . ' FROM table'
      . ' JOIN details ON table.id = details.user_id'
      . ' JOIN emails ON table.email = emails.email'
      . ' JOIN comments ON table.id = comments.author AND comments.active = 1'
      . ' WHERE username = "test" OR username = "tester"',
      $query->assemble()
    );
  }

  public function testGroupBy()
  {
    $query = QueryBuilder::select('field', 'field2');
    $query->from('table');
    $query->join('details', 'id', 'user_id');
    $query->join('emails', 'email');
    $query->join('comments', 'id', 'author', ['active' => 1]);
    $query->where(['username' => 'test']);
    $query->orWhere(['username' => 'tester']);
    $query->groupBy('role');

    $this->assertEquals(
      'SELECT field, field2'
      . ' FROM table'
      . ' JOIN details ON table.id = details.user_id'
      . ' JOIN emails ON table.email = emails.email'
      . ' JOIN comments ON table.id = comments.author AND comments.active = 1'
      . ' WHERE username = "test" OR username = "tester"'
      . ' GROUP BY role',
      $query->assemble()
    );
  }

  public function testOrderBy()
  {
    $query = QueryBuilder::select('field', 'field2');
    $query->from('table');
    $query->join('details', 'id', 'user_id');
    $query->join('emails', 'email');
    $query->join('comments', 'id', 'author', ['active' => 1]);
    $query->where(['username' => 'test']);
    $query->orWhere(['username' => 'tester']);
    $query->groupBy('role');
    $query->orderBy(['id' => 'DESC']);

    $this->assertEquals(
      'SELECT field, field2'
      . ' FROM table'
      . ' JOIN details ON table.id = details.user_id'
      . ' JOIN emails ON table.email = emails.email'
      . ' JOIN comments ON table.id = comments.author AND comments.active = 1'
      . ' WHERE username = "test" OR username = "tester"'
      . ' GROUP BY role'
      . ' ORDER BY id DESC',
      $query->assemble()
    );
  }

  public function testHaving()
  {
    $query = QueryBuilder::select('field', 'field2');
    $query->from('table');
    $query->join('details', 'id', 'user_id');
    $query->join('emails', 'email');
    $query->join('comments', 'id', 'author', ['active' => 1]);
    $query->where(['username' => 'test']);
    $query->orWhere(['username' => 'tester']);
    $query->groupBy('role');
    $query->orderBy(['id' => 'DESC']);
    $query->having(['count' => 23]);

    $this->assertEquals(
      'SELECT field, field2'
      . ' FROM table'
      . ' JOIN details ON table.id = details.user_id'
      . ' JOIN emails ON table.email = emails.email'
      . ' JOIN comments ON table.id = comments.author AND comments.active = 1'
      . ' WHERE username = "test" OR username = "tester"'
      . ' GROUP BY role'
      . ' HAVING count = 23'
      . ' ORDER BY id DESC',
      $query->assemble()
    );
  }

  public function testLimit()
  {
    $query = QueryBuilder::select('field', 'field2');
    $query->from('table');
    $query->join('details', 'id', 'user_id');
    $query->join('emails', 'email');
    $query->join('comments', 'id', 'author', ['active' => 1]);
    $query->where(['username' => 'test']);
    $query->orWhere(['username' => 'tester']);
    $query->groupBy('role');
    $query->orderBy(['id' => 'DESC']);
    $query->having(['count' => 23]);
    $query->limit(10);

    $this->assertEquals(
      'SELECT field, field2'
      . ' FROM table'
      . ' JOIN details ON table.id = details.user_id'
      . ' JOIN emails ON table.email = emails.email'
      . ' JOIN comments ON table.id = comments.author AND comments.active = 1'
      . ' WHERE username = "test" OR username = "tester"'
      . ' GROUP BY role'
      . ' HAVING count = 23'
      . ' ORDER BY id DESC'
      . ' LIMIT 10',
      $query->assemble()
    );
  }

  public function testAdvancedWhere()
  {
    $query = QueryBuilder::select('id', 'name');
    $query->from('companies');
    $query->where(
      [
        'OR' => [
          ['name' => 'acme'],
          ['type' => 'internal']
        ],
        [
          'OR' => [
            ['status' => 'active'],
            'NOT' => [
              ['status' => ['inactive', 'suspended']]
            ]
          ]
        ]
      ]
    );

    $this->assertEquals(
      'SELECT id, name'
      . ' FROM companies'
      . ' WHERE'
      . ' (name = "acme" OR type = "internal")'
      . ' AND'
      . ' (status = "active" OR status NOT IN ("inactive","suspended"))'
      ,
      $query->assemble()
    );
  }
}
