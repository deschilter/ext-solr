<?php
namespace ApacheSolrForTypo3\Solr\Controller;

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

use ApacheSolrForTypo3\Solr\Domain\Search\ResultSet\SearchResultSet;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Response;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\TemplateView;

/**
 * Class SearchController
 *
 * @author Frans Saris <frans@beech.it>
 * @author Timo Hund <timo.hund@dkd.de>
 * @package ApacheSolrForTypo3\Solr\Controller
 */
class SearchController extends AbstractBaseController
{
    /**
     * @var TemplateView
     */
    protected $view;

    /**
     * Provide search query in extbase arguments.
     */
    protected function initializeAction()
    {
        parent::initializeAction();
        $this->mapGlobalQueryStringWhenEnabled();
    }

    /**
     * @return void
     */
    protected function mapGlobalQueryStringWhenEnabled()
    {
        $query = GeneralUtility::_GET('q');

        $useGlobalQueryString = $query !== null && !$this->typoScriptConfiguration->getSearchIgnoreGlobalQParameter();

        if ($useGlobalQueryString) {
            $this->request->setArgument('q', $query);
        }
    }

    /**
     * @param ViewInterface $view
     */
    public function initializeView(ViewInterface $view)
    {
        if($view instanceof TemplateView) {
            $customTemplate = $this->getCustomTemplateFromConfiguration();
            if($customTemplate === '') {
                return;
            }

            if(strpos($customTemplate, 'EXT:') !== false) {
                $view->setTemplatePathAndFilename($customTemplate);
            } else {
                $view->setTemplate($customTemplate);
            }
        }
    }

    /**
     * @return string
     */
    protected function getCustomTemplateFromConfiguration()
    {
        $templateKey = str_replace('Action', '', $this->actionMethodName);
        $customTemplate = $this->typoScriptConfiguration->getViewTemplateByFileKey($templateKey);
        return $customTemplate;
    }

    /**
     * Results
     */
    public function resultsAction()
    {
        if (!$this->searchService->getIsSolrAvailable()) {
            $this->forward('solrNotAvailable');
        }

        $arguments = (array)$this->request->getArguments();
        $pageId = $this->typoScriptFrontendController->getRequestedId();
        $languageId = $this->typoScriptFrontendController->sys_language_uid;
        $searchRequest = $this->getSearchRequestBuilder()->buildForSearch($arguments, $pageId, $languageId);

        $searchResultSet = $this->searchService->search($searchRequest);


        // we pass the search result set to the controller context, to have the possibility
        // to access it without passing it from partial to partial
        $this->controllerContext->setSearchResultSet($searchResultSet);

        $this->view->assignMultiple(
            [
                'hasSearched' => $this->searchService->getHasSearched(),
                'additionalFilters' => $this->searchService->getAdditionalFilters(),
                'resultSet' => $searchResultSet,
                'pluginNamespace' => $this->typoScriptConfiguration->getSearchPluginNamespace()
            ]
        );
    }

    /**
     * Form
     */
    public function formAction()
    {
        $this->view->assignMultiple(
            [
                'search' => $this->searchService->getSearch(),
                'additionalFilters' => $this->searchService->getAdditionalFilters(),
                'pluginNamespace' => $this->typoScriptConfiguration->getSearchPluginNamespace()
            ]
        );
    }

    /**
     * Frequently Searched
     */
    public function frequentlySearchedAction()
    {
        /** @var  $searchResultSet SearchResultSet */
        $searchResultSet = GeneralUtility::makeInstance(SearchResultSet::class);

        $pageId = $this->typoScriptFrontendController->getRequestedId();
        $languageId = $this->typoScriptFrontendController->sys_language_uid;
        $searchRequest = $this->getSearchRequestBuilder()->buildForFrequentSearches($pageId, $languageId);
        $searchResultSet->setUsedSearchRequest($searchRequest);

        $this->controllerContext->setSearchResultSet($searchResultSet);
        $this->view->assignMultiple(
            [
                'hasSearched' => $this->searchService->getHasSearched(),
                'additionalFilters' => $this->searchService->getAdditionalFilters(),
                'resultSet' => $searchResultSet
            ]
        );
    }

    /**
     * This action allows to render a detailView with data from solr.
     *
     * @param string $documentId
     */
    public function detailAction($documentId = '')
    {
        if (!$this->searchService->getIsSolrAvailable()) {
            $this->forward('solrNotAvailable');
        }

        $document = $this->searchService->getDocumentById($documentId);
        $this->view->assign('document', $document);
    }

    /**
     * Rendered when no search is available.
     * @return string
     */
    public function solrNotAvailableAction()
    {
        if ($this->response instanceof Response) {
            $this->response->setStatus(503);
        }
    }
}
