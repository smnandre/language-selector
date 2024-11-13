<?php

namespace App\Twig\Components;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\PostMount;

#[AsLiveComponent]
class LanguageSelector extends AbstractController
{
    use DefaultActionTrait;
    use ComponentToolsTrait;
    
    // Custom trait for live logs
    use LoggerTrait;
    
    #[LiveProp]
    public array $selectedLanguages = [];

    // This is the main method that will be called when the component is rendered
    // You normally don't need to call this method directly
    // It's in the DefaultActionTrait
    public function __invoke()
    {
        $this->log('render');
        
        // This event will not be sent to the client
        $this->emit('languageAdded', ['language' => 'ES']);
    }
    
    public function mount(): void
    {
        $this->log('mount');        
    }

    #[PostMount]
    public function postMount(): void
    {
        $this->log('postMount');
    }
    
    #[LiveAction]
    public function select(#[LiveArg] string $language): void
    {
        $this->log(sprintf('select "%s"', $language));
        
        if (!isset($this->selectedLanguages[$language])) {
            $this->selectedLanguages[$language] = $language;
            $this->emit('languageAdded', ['language' => $language]);
            $this->log(sprintf('emit languageAdded "%s"', $language));
        }
    }
    
    #[LiveAction]
    public function deselect(#[LiveArg] string $language): void
    {
        $this->log(sprintf('select "%s"', $language));
        
        if (isset($this->selectedLanguages[$language])) {
            unset($this->selectedLanguages[$language]);
            $this->emit('languageRemoved', ['language' => $language]);
            $this->log(sprintf('emit languageRemoved "%s"', $language));
        }
    }
}
