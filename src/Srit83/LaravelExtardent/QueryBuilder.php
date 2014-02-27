<?php
/**
 * @created 24.02.14 - 11:54
 * @author stefanriedel
 */

namespace Srit83\LaravelExtardent;

use Illuminate\Database\Query\Builder as BaseQueryBuilder;

class QueryBuilder extends  BaseQueryBuilder{

    protected $_oModel = null;

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

    public function aggregate($function, $columns = array('*'))
    {
        return $this->_cachedCallback('aggregate', array($function, $columns));
    }

    public function getModel() {
        return $this->_oModel;
    }

    public function setModel($oModel) {
        $this->_oModel = $oModel;
        return $this;
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

    /**
     * @return \Cache
     */
    protected function _getCache()
    {
        if ($this->_oCache == null) {
            $sClassName = get_class($this->getModel());
            $sBindings = serialize($this->getBindings());
            $sExtend = '';
            if(count(func_get_args()) > 0) {
                $sExtend = serialize(func_get_args());
            }

            $this->_sCacheKey = md5($sClassName.$sBindings.$sExtend);
            $this->_aCacheTags = array($sClassName, $this->_sCacheKey);


            $this->_oCache = \Cache::tags($this->_aCacheTags);
        }
        return $this->_oCache;
    }

} 