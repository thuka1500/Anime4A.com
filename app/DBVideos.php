<?php
/**
 * Created by PhpStorm.
 * User: Azure Cloud
 * Date: 11/12/2016
 * Time: 8:08 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class DBVideos extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'anime4a_videos';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
}