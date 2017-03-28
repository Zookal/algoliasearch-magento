<?php

class Algolia_Algoliasearch_Helper_Config extends Mage_Core_Helper_Abstract
{
    const IS_INSTANT_ENABLED = 'algoliasearch/credentials/is_instant_enabled';
    const MAKE_SEO_REQUEST = 'algoliasearch/advanced/make_seo_request';

    public function makeSeoRequest($storeId = null)
    {
        return Mage::getStoreConfigFlag(self::MAKE_SEO_REQUEST, $storeId);
    }

    public function isInstantEnabled($storeId = null)
    {
        return Mage::getStoreConfigFlag(self::IS_INSTANT_ENABLED, $storeId);
    }
}