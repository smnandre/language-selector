<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class FooBarFilter
{
    use DefaultActionTrait;
    use ComponentToolsTrait;
    
    use LoggerTrait;
    
    #[LiveProp]
    // Observe we need to store the languages here,
    // as we need to keep track of them to remove them
    // and/or re-render the inputs for instance
        
    // And you cannot garantee that this component
    // will be rendered before the Selector one
    public array $languages = [];
    
    // A prefix to distinguish the two instances of this component
    // (shown to prove both are independant and listen each the event
    #[LiveProp]
    public string $prefix;
    
    public function mount()
    {
        $this->log('mount');
    }
    
    #[LiveListener('languageAdded')]
    public function addFilter(#[LiveArg] string $language): void
    {
        $this->log('event: languageAdded: '.$language);
        $this->log('action: addFilter: '.$language);
        $this->languages[$language] = $language;
    }
    
    #[LiveListener('languageRemoved')]
    public function removeFilter(#[LiveArg] string $language): void
    {
        $this->log('event: languageRemoved: '.$language);
        $this->log('action: removeFilter: '.$language);
        unset($this->languages[$language]);
    }
}
