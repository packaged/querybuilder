Query Builder
===

[![Latest Stable Version](https://poser.pugx.org/packaged/querybuilder/version.png)](https://packagist.org/packages/packaged/querybuilder)
[![Total Downloads](https://poser.pugx.org/packaged/querybuilder/d/total.png)](https://packagist.org/packages/packaged/querybuilder)
[![Build Status](https://travis-ci.org/packaged/querybuilder.png)](https://travis-ci.org/packaged/querybuilder)
[![Dependency Status](https://www.versioneye.com/php/packaged:querybuilder/badge.png)](https://www.versioneye.com/php/packaged:querybuilder)
[![HHVM Status](http://hhvm.h4cc.de/badge/packaged/querybuilder.png)](http://hhvm.h4cc.de/package/packaged/querybuilder)
[![Coverage Status](https://coveralls.io/repos/packaged/querybuilder/badge.png)](https://coveralls.io/r/packaged/querybuilder)

Reason
==
This library exists as a standalone query builder designed to split every single element of a query to allow packages using the library to convert the query into a more performant query, or supporting functionality not available in the original database layer.

Examples
---

CQL (Cassandra) does not support CONCAT, so this can be pulled from the original query, the fields gathered and then concatinated in PHP.

When running a sharded database, the query can be rebuilt to execute across multiple nodes with the correct partitioning keys, and then presented back to the user as a single result.

Terms
==

Base on information found on wikipedia - http://en.wikipedia.org/wiki/SQL

Clauses
---
Are constituent components of statements and queries.

Expressions
---
which can produce either scalar values, or tables consisting of columns and rows of data

Predicates
---
Specify conditions that can be evaluated to SQL three-valued logic (3VL) (true/false/unknown) or Boolean truth values and are used to limit the effects of statements and queries, or to change program flow.

Statements
---
May have a persistent effect on schemata and data, or may control transactions, program flow, connections, sessions, or diagnostics.

Query Statement
---
Retrieve data based on specific criteria.

Select Expression
---
Columns and Functions used to build the returning data
