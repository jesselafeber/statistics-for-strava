<?php

declare(strict_types=1);

namespace App\Domain\Integration\AI\Chat;

use App\Domain\Integration\AI\Chat\AddChatMessage\AddChatMessage;
use App\Infrastructure\CQRS\Command\Bus\CommandBus;
use NeuronAI\Chat\Enums\MessageRole;
use NeuronAI\Chat\History\ChatHistoryInterface;
use NeuronAI\Chat\History\InMemoryChatHistory as BaseInMemoryChatHistory;
use NeuronAI\Chat\Messages\Message;

/**
 * @codeCoverageIgnore
 */
final class SFSChatHistory extends BaseInMemoryChatHistory
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
        parent::__construct();
    }

    #[\Override]
    public function setMessages(array $messages): ChatHistoryInterface
    {
        return $this;
    }

    #[\Override]
    protected function clear(): ChatHistoryInterface
    {
        return $this;
    }

    #[\Override]
    public function onNewMessage(Message $message): void
    {
        parent::onNewMessage($message);

        if (!in_array($message->getContent(), [null, '', '0'], true)) {
            $this->commandBus->dispatch(new AddChatMessage(
                message: $message->getContent(),
                messageRole: MessageRole::from($message->getRole()),
            ));
        }
    }
}
