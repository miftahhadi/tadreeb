<?php 

namespace App;

class DataTable
{
    protected static $defaultHeading = [
        [
            'name' => 'ID',
            'widht' => null
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

    protected static $userHeading = [
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

    protected static $defaultProps = ['id', 'judul', 'slug'];

    protected static $userProps = ['id', 'nama', 'username', 'jenis_kelamin'];

    public static function heading($parameter = null)
    {
        if ($parameter == 'user') {
            return self::$userHeading;
        } else {
            return self::$defaultHeading;
        }
    }

    public static function props($parameter = null)
    {
        if ($parameter == 'user') {
            return self::$userProps;
        } else {
            return self::$defaultProps;
        }
    }

}