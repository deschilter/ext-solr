<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace ApacheSolrForTypo3\Solr\System\Records;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class RecordRepository
{
    protected ConnectionPool $connectionPool;

    public function __construct(
        ?ConnectionPool $connectionPool = null
    ) {
        $this->connectionPool = $connectionPool ?? GeneralUtility::makeInstance(ConnectionPool::class);
    }

    public function getLanguageOverlay(string $table, array $originalRow, int $targetLanguageId): ?array
    {
        $tableControl = $GLOBALS['TCA'][$table]['ctrl'] ?? [];

        if (!isset($tableControl['languageField'])) {
            return $originalRow;
        }

        if ($targetLanguageId > 0 && ((int)$originalRow[$tableControl['languageField']] ?? 0) === 0) {
            return $this->getLocalizedRecord($table, $tableControl, $targetLanguageId, $originalRow['uid']);
        }

        return $originalRow;
    }

    private function getLocalizedRecord(string $table, array $tableControl, int $languageId, int $originalRecordUid): ?array
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable($table);

        $result = $queryBuilder->select('*')
            ->from($table)
            ->where(
                $queryBuilder->expr()->eq(
                    $tableControl['languageField'],
                    $queryBuilder->createNamedParameter($languageId, Connection::PARAM_INT)
                ),
                $queryBuilder->expr()->eq(
                    $tableControl['transOrigPointerField'],
                    $queryBuilder->createNamedParameter($originalRecordUid, Connection::PARAM_INT)
                )
            )
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchAssociative();

        return $result ?: null;
    }
}
