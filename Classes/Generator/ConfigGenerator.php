<?php

declare(strict_types=1);

namespace SFC\Staticfilecache\Generator;

use Psr\Http\Message\ResponseInterface;
use SFC\Staticfilecache\Service\ConfigurationService;
use SFC\Staticfilecache\Service\RemoveService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * ConfigGenerator.
 */
class ConfigGenerator extends AbstractGenerator
{
    /**
     * Generate file.
     */
    public function generate(string $entryIdentifier, string $fileName, ResponseInterface $response, int $lifetime): void
    {
        $config = [
            'generated' => date('r'),
            'headers' => GeneralUtility::makeInstance(ConfigurationService::class)
                ->getValidHeaders($response->getHeaders(), 'validFallbackHeaders'),
        ];
        GeneralUtility::writeFile($fileName.'.config.json', json_encode($config, JSON_PRETTY_PRINT));
    }

    /**
     * Remove file.
     */
    public function remove(string $entryIdentifier, string $fileName): void
    {
        $removeService = GeneralUtility::makeInstance(RemoveService::class);
        $removeService->file($fileName.'.config.json');
    }
}
