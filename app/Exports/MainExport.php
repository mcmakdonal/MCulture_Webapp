<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MainExport implements WithMultipleSheets
{
    use Exportable;

    protected $reply_status;
    protected $read_status;

    public function __construct(string $reply_status = "", string $read_status = "")
    {
        $this->reply_status = $reply_status;
        $this->read_status = $read_status;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $sheets[0] = new CommentExport($this->reply_status, $this->read_status);
        $sheets[1] = new ComplaintExport($this->reply_status, $this->read_status);
        $sheets[2] = new InformExport($this->reply_status, $this->read_status);

        return $sheets;
    }

}
