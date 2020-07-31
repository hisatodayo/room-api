<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = ['id'];

    /**
     * メッセージを所有するUserを取得
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
