<?php

class AppService extends RestService {

    function __construct() {
        parent::__construct('http://localhost:8868/tradeshift-app-service/rest');
    }


    public function getActivationBundle() {
        if (!$_SESSION['appbundle'] || !$_SESSION['appbundle']->LastChanged) {
            $url = $this->url('/app/active/bundle',null,array('locale' => 'en,da'));
            $_SESSION['appbundle'] = $this->httpGet($url);
        }

        return $_SESSION['appbundle'];
    }

    /**

    def getActivationBundle() {
        def cacheKey = securityService.securityContext.User.Id + getLanguagePrefs()
        def entry = appCache.get(cacheKey)
        def ifModifiedSince = -1
        if (entry?.objectValue?.LastChanged) {
        ifModifiedSince = new DateTime(entry.objectValue.LastChanged).getMillis()
        }
        def res = appClient.requestWithParms("/app/active/bundle", [locale: getLanguagePrefs()], HttpMethod.GET, MediaType.APPLICATION_JSON, null, MediaType.APPLICATION_JSON, ifModifiedSince)
        if (res?.notModified) {
        return entry.objectValue
        } else if (res) {
        entry = new Element(cacheKey, res)
        appCache.put(entry)
        return res
        }
    }

     */
}