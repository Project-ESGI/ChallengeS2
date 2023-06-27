<?php
namespace App\Models;
use App\Core\Sql;

class Page extends Sql {

    protected int $id = 0;
    protected string $title;
    protected $date_inserted;
    protected $date_updated;

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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
}
