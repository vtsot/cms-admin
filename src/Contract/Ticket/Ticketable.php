<?php

declare(strict_types=1);

namespace App\Contract\Ticket;

use App\DTO\HG\Support\TicketDTO;
use App\Entity\SupportRequest;

interface Ticketable
{
    public function submitTicket(SupportRequest $supportRequest): TicketDTO;
}
