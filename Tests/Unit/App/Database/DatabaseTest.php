<?php

namespace Test\Unit\App\Database;

class DatabaseTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider query_dataprovider
     */
    public function test_valid_mount_query($table, $params, $expected): void
    {
        $ret = \App\Database\Database::mountQuery($table, $params);

        $this->assertEquals($expected, $ret);
    }

    public function query_dataprovider()
    {
        return [
            'should_get_mounted_query_with_one_select_field_and_one_where_field' =>[
                'table' => 'users',
                'params' => [
                    'fields' => [
                        'email'
                    ],
                    'where' => [
                        'email' => 'john.doe@gmail.com'
                    ]
                ], 'expected' => "SELECT email FROM users WHERE email='john.doe@gmail.com'"
            ],
            'should_get_mounted_query_with_one_select_field_and_two_where_fields' =>[
                'table' => 'users',
                'params' => [
                    'fields' => [
                        'email'
                    ],
                    'where' => [
                        'email' => 'john.doe@gmail.com',
                        'name' => 'John Doe'
                    ]
                ], 'expected' => "SELECT email FROM users WHERE email='john.doe@gmail.com' AND name='John Doe'"
            ],
            'should_get_mounted_query_with_two_select_fields_and_one_where_field' =>[
                'table' => 'users',
                'params' => [
                    'fields' => [
                        'email',
                        'name'
                    ],
                    'where' => [
                        'email' => 'john.doe@gmail.com'
                    ]
                ], 'expected' => "SELECT email, name FROM users WHERE email='john.doe@gmail.com'"
            ],
            'should_get_mounted_query_with_two_select_fields_and_two_where_fields' =>[
                'table' => 'users',
                'params' => [
                    'fields' => [
                        'email',
                        'name'
                    ],
                    'where' => [
                        'email' => 'john.doe@gmail.com',
                        'name' => 'John Doe'
                    ]
                ], 'expected' => "SELECT email, name FROM users WHERE email='john.doe@gmail.com' AND name='John Doe'"
            ],
            'should_get_mounted_query_with_all_select_fields' =>[
                'table' => 'users',
                'params' => [
                    'fields' => [
                        '*',
                    ],
                    'where' => [],
                ], 'expected' => "SELECT * FROM users"
            ],
        ];
    }
}