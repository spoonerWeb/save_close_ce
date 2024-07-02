<?php
declare(strict_types=1);
namespace Goran\SaveCloseCe\Service;

use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\Components\Buttons\InputButton;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ButtonBarService
{
    /**
     * @var array<string,mixed>
     */
    protected $extConfArray = [];

    protected IconFactory $iconFactory;

    public function __construct(?ExtensionConfiguration $extensionConfiguration = null, ?IconFactory $iconFactory = null)
    {
        if (!$extensionConfiguration) {
            $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
        }
        $this->extConfArray = $extensionConfiguration->get('save_close_ce');
        if (!$iconFactory) {
            $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        }
        $this->iconFactory = $iconFactory;
    }

    /**
     * @param array $buttons
     * @param ButtonBar $buttonBar
     * @return array Retuns the buttons
     */
    public function addSaveCloseButton(array $buttons, ButtonBar $buttonBar): array
    {
        $showButton = (bool)($this->extConfArray['saveAndClose']['button'] ?? false);
        $showLabel = (bool)($this->extConfArray['saveAndClose']['label'] ?? false);

        if ($showButton === false) {
            return $buttons;
        }

        $saveButton = $buttons[ButtonBar::BUTTON_POSITION_LEFT][2][0] ?? null;
        if ($saveButton instanceof InputButton) {
            $saveCloseButton = $buttonBar->makeInputButton()
                ->setName('_saveandclosedok')
                ->setValue('1')
                ->setForm($saveButton->getForm())
                ->setTitle($this->getLanguageService()->sL('LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:rm.saveCloseDoc'))
                ->setIcon($this->iconFactory->getIcon('actions-document-save-close', Icon::SIZE_SMALL))
                ->setShowLabelText($showLabel);

            $buttons[ButtonBar::BUTTON_POSITION_LEFT][2][] = $saveCloseButton;
        }
        return $buttons;
    }

    /**
     * @param array $buttons
     * @param ButtonBar $buttonBar
     * @return array Return buttons
     */
    public function addSaveViewButton(array $buttons, ButtonBar $buttonBar): array
    {
        $showButton = (bool)($this->extConfArray['saveAndView']['button'] ?? false);
        $showLabel = (bool)($this->extConfArray['saveAndView']['label'] ?? false);

        if ($showButton === false) {
            return $buttons;
        }

        $button = $buttons[ButtonBar::BUTTON_POSITION_LEFT][2][0] ?? null;
        if ($button instanceof InputButton) {
            $saveAndViewButton = $buttonBar->makeInputButton()
                ->setName('_savedokview')
                ->setValue('1')
                ->setForm($button->getForm())
                ->setTitle($this->getLanguageService()->sL('LLL:EXT:core/Resources/Private/Language/locallang_core.xlf:rm.saveDocShow'))
                ->setIcon($this->iconFactory->getIcon('actions-document-save-view', Icon::SIZE_SMALL))
                ->setShowLabelText($showLabel);

            $buttons[ButtonBar::BUTTON_POSITION_LEFT][2][] = $saveAndViewButton;
        }
        return $buttons;
    }

    /**
     * Returns the language service
     * @return LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }
}
