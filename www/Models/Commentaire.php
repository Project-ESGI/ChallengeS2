<?php

namespace App\Models;

use App\Core\Sql;

class Commentaire extends Sql
{

    protected int $id = 0;
    protected string $content;
    protected string $answer;
    protected int $author;
    protected $date_inserted;
    protected $date_updated;
    protected int $report = 0;

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

    /**
     * @return mixed
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }

    /**
     * @param mixed $date_updated
     */
    public function setDateUpdated($date_updated): void
    {
        $this->date_updated = $date_updated;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        if ($this->author !== 0) {
            $user = new User();
            $user->getById($this->author);
            return $user;
        }
        return null;
    }

    /**
     * @param int $author
     */
    public function setAuthorId(int $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     */
    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    /**
     * @return int
     */
    public function getReport(): int
    {
        return $this->report;
    }

    /**
     * @param int $report
     */
    public function setReport(int $report): void
    {
        $this->report = $report;
    }
}
