<?php 

namespace App;

class DataTable
{
    protected static $headingOne = [
        [
            'name' => 'ID',
            'width' => '5%'
        ],
        [
            'name' => 'Judul',
            'width' => '40%'
        ], 
        
        [
            'name' => 'Slug',
            'width' => null
        ]
    ];

    protected static $headingTwo = [
        [
            'name' => 'ID',
            'width' => '5%'
        ],
        [
            'name' => 'Nama',
            'width' => null
        ]
    ];

    protected static $headingThree = [
        [
            'name' => 'ID',
            'width' => '5%'
        ],
        [
            'name' => 'Nama',
            'width' => '40%'
        ], 
        
        [
            'name' => 'Kode',
            'width' => null
        ]
    ];

    protected static $headingUser = [
        [
            'name' => 'ID',
            'width' => null
        ],
        [
            'name' => 'Nama',
            'width' => '40%'
        ],
        [
            'name' => 'Username',
            'width' => null
        ],
        [
            'name' => 'Jenis Kelamin',
            'width' => null
        ]
    ];

    protected static $propsOne = ['id', 'judul', 'slug'];

    protected static $propsTwo = ['id', 'nama'];
    
    protected static $propsThree = ['id', 'nama', 'kode'];
    
    protected static $propsUser = ['id', 'nama', 'username', 'gender'];

    public static function heading($parameter = null)
    {
        $heading = [];

        switch ($parameter) {
            case 2:
                $heading = self::$headingTwo;
                break;

            case 3:
                $heading = self::$headingThree;
                break;
            
            case 'user':
                $heading = self::$headingUser;
                break;

            default:
                $heading = self::$headingOne;
                break;
        }

        return $heading;
    }

    public static function props($parameter = null)
    {
        $props = [];

        switch ($parameter) {
            case 2:
                $props = self::$propsTwo;
                break;

            case 3:
                $props = self::$propsThree;
                break;                

            case 'user':
                $props = self::$propsUser;
                break;                

            default:
                $props = self::$propsOne;
                break;
        }

        return $props;

    }

}