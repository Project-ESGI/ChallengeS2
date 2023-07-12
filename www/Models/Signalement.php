<?php

namespace App\Models;

use App\Core\Sql;

class Signalement extends Sql
{

    protected int $id = 0;
    protected int $comment_id;
    protected int $user_id;
    protected $date_inserted;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->comment_id;
    }

    /**
     * @param int $comment_id
     */
    public function setCommentId(int $comment_id): void
    {
        $this->comment_id = $comment_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getDateInserted()
    {
        return $this->date_inserted;
    }

    /**
     * @param mixed $date_inserted
     */
    public function setDateInserted($date_inserted): void
    {
        $this->date_inserted = $date_inserted;
    }

}
