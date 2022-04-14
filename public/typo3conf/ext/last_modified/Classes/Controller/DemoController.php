<?php

declare(strict_types=1);

namespace Causal\LastModified\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class DemoController extends ActionController
{
    public function incompleteAction(): void
    {
        $records = $this->getRecords();

        // Often forgotten by extension authors: TYPO3 does not know about date/time of records...

        $this->view->assign('records', $records);
    }

    public function cachedAction(): void
    {
        $records = $this->getRecords();

        // Inform TYPO3 about date/time of records we show
        foreach ($records as $record) {
            $this->getTypoScriptFrontendController()->cObj->lastChanged($record['tstamp']);
        }

        $this->view->assign('records', $records);
    }

    public function uncachedAction(): void
    {
        $records = $this->getRecords();

        // Inform TYPO3 about date/time of records we show
        foreach ($records as $record) {
            $this->getTypoScriptFrontendController()->cObj->lastChanged($record['tstamp']);
        }

        $this->view->assign('records', $records);
    }

    protected function getRecords(): array
    {
        return [
            [
                'title' => 'Record #1',
                'tstamp' => strtotime('2050/01/01 10:30:00'),
            ],
            [
                'title' => 'Record #2',
                'tstamp' => strtotime('2050/01/03 14:30:00'),
            ],
            [
                'title' => 'Record #3',
                'tstamp' => strtotime('2050/01/02 12:30:00'),
            ],
        ];
    }

    protected function getTypoScriptFrontendController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
