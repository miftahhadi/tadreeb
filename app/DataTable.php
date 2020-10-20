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

    public static function heading(string $parameter = 'default', string $title = 'judul')
    {
        $heading = ($parameter == 'user') ? self::$userHeading : self::$defaultHeading;

        if ($title != strtolower('judul')) {
            $heading[1]['name'] =  ucfirst($title);
        }

        return $heading;
    }

    public static function props(string $parameter = 'default', string $title = 'judul')
    {
        $props = ($parameter == 'user') ? self::$userProps : self::$defaultProps;

        if ($title != 'judul') {
            $props[1] = $title;
        }

        return $props;

    }

}