<?php
/**
 * @created 21.02.14 - 11:59
 * @author stefanriedel
 */

namespace Srit83\LaravelExtardent;

use LaravelBook\Ardent\Builder as BaseBuilder;

class Builder extends BaseBuilder
{

    protected $_sCacheKey = null;

    protected $_aCacheTags = array();

    /**
     * @var \Cache
     */
    protected $_oCache = null;

    /**
     * one day default cache
     * @var int
     */
    protected $_iDefaultCacheTime = 1440;

    /**public function rememberTags($iMinutes, $aTags, $sKey = null) {
     * return $this->remember($iMinutes, $sKey)->cacheTags($aTags);
     * }**/
    public function first($aColumns = array('*'))
    {
        return $this->_cachedCallback('first', $aColumns);
    }

    protected function ungroupedPaginate($paginator, $perPage, $columns)
    {
        $total = $this->query->getPaginationCount();

        // Once we have the paginator we need to set the limit and offset values for
        // the query so we can get the properly paginated items. Once we have an
        // array of items we can create the paginator instances for the items.
        $page = $paginator->getCurrentPage($total);

        $this->query->forPage($page, $perPage);

        return $paginator->make($this->get($columns)->all(), $total, $perPage);
    }


    protected function _cachedCallback($sMethod, $aArgs)
    {
        if (\Config::get('cache.driver') == 'memcached') {
            //only for memcached becaus we use tags


            if (($oRet = $this->_getCache($sMethod, $aArgs)->get($this->_sCacheKey)) == null) {
                $oRet = call_user_func_array(array('parent', $sMethod), $aArgs);
                $this->_getCache()->put($this->_sCacheKey, $oRet, $this->_iDefaultCacheTime);
            }
        } else {
            $oRet = call_user_func_array(array('parent', $sMethod), $aArgs);
        }

        return $oRet;
    }

    public function get($aColumns = array('*'))
    {
        return $this->_cachedCallback('get', $aColumns);
    }


    /**
     * @return \Cache
     */
    protected function _getCache()
    {
        if ($this->_oCache == null) {
            $sClassName = get_class($this->getModel());
            $sQuery = $this->getQuery()->toSql();
            $sAttributes = serialize($this->getQuery()->getBindings());

            $sExtend = '';
            if(count(func_get_args()) > 0) {
                $sExtend = serialize(func_get_args());
            }

            $sCacheKey = $this->_sCacheKey = md5($sQuery . $sAttributes . $sExtend);
            $aTags = $this->_aCacheTags = array($sClassName, $sCacheKey);

            $this->_oCache = \Cache::tags($aTags);
        }
        return $this->_oCache;
    }


}