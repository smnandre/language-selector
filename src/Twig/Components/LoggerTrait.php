<?php

namespace App\Twig\Components;

use DateTimeImmutable;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

trait LoggerTrait {
    
    #[LiveProp('log')]
    public array $logger;
    
    protected function log(string $message): void
    {
        $this->logger ??= [];
        $this->logger[] = (new DateTimeImmutable())->format('H:i:s') . ': ' . $message;
    }
}
