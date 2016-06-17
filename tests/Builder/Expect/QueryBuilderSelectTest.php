<?php
namespace Packaged\Tests\QueryBuilder\Builder\Expect;

use Packaged\QueryBuilder\Assembler\QueryAssembler;
use Packaged\QueryBuilder\Builder\QueryBuilder;

class QueryBuilderSelectTest extends \PHPUnit_Framework_TestCase
{
  public function testSelect()
  {
    $query = QueryBuilder::select('field', 'field2');

    $this->assertEquals(
      'SELECT field, field2',
      QueryAssembler::stringify($query)
    );
  }

  public function testSelectDistinct()
  {
    $query = QueryBuilder::selectDistinct('field', 'field2');

    $this->assertEquals(
      'SELECT DISTINCT field, field2',
      QueryAssembler::stringify($query)
    );
  }

  public function testFrom()
  {
    $query = QueryBuilder::select('field', 'field2');
    $query->from('table');

    $this->assertEquals(
      'SELECT field, field2'
      . ' FROM table',
      QueryAssembler::stringify($query)
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
      . ' INNER JOIN details ON table.id = details.user_id',
      QueryAssembler::stringify($query)
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
      . ' INNER JOIN details ON table.id = details.user_id'
      . ' INNER JOIN emails ON table.email = emails.email',
      QueryAssembler::stringify($query)
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
      . ' INNER JOIN details ON table.id = details.user_id'
      . ' INNER JOIN emails ON table.email = emails.email'
      . ' INNER JOIN comments ON table.id = comments.author AND comments.active = 1',
      QueryAssembler::stringify($query)
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
      . ' INNER JOIN details ON table.id = details.user_id'
      . ' INNER JOIN emails ON table.email = emails.email'
      . ' INNER JOIN comments ON table.id = comments.author AND comments.active = 1'
      . ' WHERE username = "test"',
      QueryAssembler::stringify($query)
    );
  }

  public function testWhereEmpty()
  {
    $query = QueryBuilder::select();
    $query->from('table');
    $query->where([]);

    $this->assertEquals(
      'SELECT * FROM table',
      QueryAssembler::stringify($query)
    );

    $query = QueryBuilder::select();
    $query->from('table');
    $query->where();

    $this->assertEquals(
      'SELECT * FROM table',
      QueryAssembler::stringify($query)
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
      . ' INNER JOIN details ON table.id = details.user_id'
      . ' INNER JOIN emails ON table.email = emails.email'
      . ' INNER JOIN comments ON table.id = comments.author AND comments.active = 1'
      . ' WHERE username = "test" OR username = "tester"',
      QueryAssembler::stringify($query)
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
      . ' INNER JOIN details ON table.id = details.user_id'
      . ' INNER JOIN emails ON table.email = emails.email'
      . ' INNER JOIN comments ON table.id = comments.author AND comments.active = 1'
      . ' WHERE username = "test" OR username = "tester"'
      . ' GROUP BY role',
      QueryAssembler::stringify($query)
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
      . ' INNER JOIN details ON table.id = details.user_id'
      . ' INNER JOIN emails ON table.email = emails.email'
      . ' INNER JOIN comments ON table.id = comments.author AND comments.active = 1'
      . ' WHERE username = "test" OR username = "tester"'
      . ' GROUP BY role'
      . ' ORDER BY id DESC',
      QueryAssembler::stringify($query)
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
      . ' INNER JOIN details ON table.id = details.user_id'
      . ' INNER JOIN emails ON table.email = emails.email'
      . ' INNER JOIN comments ON table.id = comments.author AND comments.active = 1'
      . ' WHERE username = "test" OR username = "tester"'
      . ' GROUP BY role'
      . ' HAVING count = 23'
      . ' ORDER BY id DESC',
      QueryAssembler::stringify($query)
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
      . ' INNER JOIN details ON table.id = details.user_id'
      . ' INNER JOIN emails ON table.email = emails.email'
      . ' INNER JOIN comments ON table.id = comments.author AND comments.active = 1'
      . ' WHERE username = "test" OR username = "tester"'
      . ' GROUP BY role'
      . ' HAVING count = 23'
      . ' ORDER BY id DESC'
      . ' LIMIT 10',
      QueryAssembler::stringify($query)
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
          ['type' => 'internal'],
        ],
        [
          'OR' => [
            ['status' => 'active'],
            'NOT' => [
              ['status' => ['inactive', 'suspended']],
            ],
          ],
        ],
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
      QueryAssembler::stringify($query)
    );
  }
}
