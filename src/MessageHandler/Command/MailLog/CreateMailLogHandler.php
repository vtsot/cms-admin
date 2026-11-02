<?php

declare(strict_types=1);

namespace App\MessageHandler\Command\MailLog;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Entity\MailLog;
use App\Entity\Site\Site;
use App\Message\Command\MailLog\CreateMailLogCommand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;

readonly class CreateMailLogHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    /**
     * @throws ORMException
     */
    public function __invoke(CreateMailLogCommand $command): MailLog
    {
        $mailLog = (new MailLog())
            ->setMessageId($command->id)
            ->setStatus($command->status)
            ->setDebug($command->debug)
            ->setSender($command->from)
            ->setReplyTo($command->replyTo)
            ->setReturnPath($command->returnPath)
            ->setRecipient($command->to)
            ->setCc($command->cc)
            ->setBcc($command->bcc)
            ->setSubject($command->subject)
            ->setText($command->text)
            ->setHtml($command->html);

        if ($command->siteId !== null) {
            $mailLog->setSite($this->em->getReference(Site::class, $command->siteId));
        }

        $this->em->persist($mailLog);
        $this->em->flush();

        return $mailLog;
    }
}
