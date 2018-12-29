<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @package App
 * @property string $title
 * @property string $body
 * @property int $author_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class Article extends Model
{
    protected $table = 'article';

    protected $fillable = [
        'title',
        'body',
        'author_id'
    ];
}
