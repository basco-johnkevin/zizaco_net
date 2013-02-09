<?php

use LaravelBook\Ardent\Ardent;

class Comment extends Ardent
{
    /**
     * Table
     */
    protected $table = 'comments';

    /**
     * Ardent validation rules
     */
    public static $rules = array(
        'name' => 'required',
        'email' => 'required|email',
        'content' => 'required',
        'approved' => 'required',
        'post_id' => 'required|numeric',
    );   

    /**
     * Factory
     */
    public static $factory = array(
        'name' => 'string',
        'email' => 'email',
        'website' => 'http://www.testwebsite.com',
        'content' => 'text',
        'approved' => true,
        'post_id' => 'factory|Post',
    );

    /**
     * Belongs to post
     */
    public function post()
    {
        return $this->belongsTo( 'Post' );
    }

    /**
     * Gets the gravatar from the author email
     *
     * @return string
     */
    public function authorGravatar()
    {
        $default = 'http://www.thesolutionsjournal.com/sites/default/files/imagecache/front_page_user/pictures/user_default.png';
        $size = 68;

        $gravatar = "http://www.gravatar.com/avatar/".
            md5( strtolower( trim( $this->email ) ) ).
            "?d=" . urlencode( $default ) .
            "&s=" . $size;

        return $gravatar;
    }

    /**
     * Post date
     *
     * @return string
     */
    public function postedAt()
    {
        $date_obj =  $this->created_at;

        if (is_string($this->created_at))
            $date_obj =  DateTime::createFromFormat('Y-m-d H:i:s', $date_obj);

        return $date_obj->format('d/m/Y');
    }
}