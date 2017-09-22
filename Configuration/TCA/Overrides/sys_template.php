<?php

// TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Solr/', 'Search - Base Configuration');

// StyleSheets
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/StyleSheets/', 'Search - Default Stylesheets');

// OpenSearch
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/OpenSearch/', 'Search - OpenSearch');

// Extension Pre-Configuration
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/IndexQueueNews/',
    'Search - Index Queue Configuration for news');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/IndexQueueNewsContentElements/',
    'Search - Index Queue Configuration for news with content elements');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/IndexQueueTtNews/',
    'Search - Index Queue Configuration for tt_news');

// Examples
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/BoostQueries/',
    'Search - (Example) Boost more recent results');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/EverythingOn/',
    'Search - (Example) Everything On');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/FilterPages/',
    'Search - (Example) Filter to only show page results');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/IntroPackageSearchBox/',
    'Search - (Example) Replace Introduction Package search box');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/ConnectionFromConfVars/',
    'Search - (Example) Use connection settings from TYPO3_CONF_VARS');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/Suggest/',
    'Search - (Example) Suggest/autocomplete with jquery');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/Facets/OptionsToggle/',
    'Search - (Example) Options with on/off toggle');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/Facets/QueryGroup/',
    'Search - (Example) QueryGroup facet on the created field');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/Facets/Hierarchy/',
    'Search - (Example) Hierarchy facet on the rootline field');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/Facets/DateRange/',
    'Search - (Example) DateRange facet with jquery ui datepicker on created field');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/Facets/NumericRange/',
    'Search - (Example) NumericRange facet with jquery ui slider on pid field');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('solr',
    'Configuration/TypoScript/Examples/Ajaxify/',
    'Search - Ajaxify the search results with jQuery');