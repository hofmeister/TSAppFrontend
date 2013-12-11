<?php
require_once 'bootstrap.php';
?>


    <!DOCTYPE html>
    <html version="XHTML+RDFa 1.0" xmlns="http://www.w3.org/1999/xhtml"
          xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
          xmlns:ts="http://go.tradeshift.com/ns/ts#"
          xmlns:doc="http://go.tradeshift.com/ns/doc#"
          xmlns:ui="http://go.tradeshift.com/ns/ui#"
          xmlns:vcard="http://www.w3.org/2006/vcard/ns#"
          xmlns:ng="http://angularjs.org"
          lang="en_US">
    <head>
        <title>App</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="gui.mode" content="jquery"/>
        <meta name="gui.debug" content="false"/>
        <meta name="gui.flexmode" content="emulated"/>

        <meta name="Tradeshift-TenantId" content="<?=TS::instance()->getCompanyId()?>" typeof="ts:CompanyAccount" property="ts:id" about="https://ap-sandbox.tradeshift.com/tenant/view/d2c482b7-e078-423d-9117-6fdec004f157"/>

        <meta name="Tradeshift-ActorId" content="<?=TS::instance()->getUserId()?>" about="urn:tradeshift:Actor" typeof="ts:Actor" property="ts:id"/>
        <meta name="Tradeshift-Nonce" content="IcKZ4GwMxv9v5VCxv2gO"/>

        <link rel="stylesheet" type="text/css" href="https://d5wfroyti11sa.cloudfront.net/prod/b/ts3all-77145e04f8c9e7f6b2ec30ce1a07d386437a3d3f.gz.css"/>
        <link rel="stylesheet" type="text/css" href="https://d5wfroyti11sa.cloudfront.net/prod/b/ts3sub-dcf7a6f1f6e0120da08d718029b694a5a9026e77.gz.css"/>

    </head>
    <body id="ui-page" about="urn:tradeshift:Page" typeof="ui:Page">



    <div id="scripts">

        <script type="text/javascript" src="https://d5wfroyti11sa.cloudfront.net/prod/b/en_US-d25929a2116a60e34cc7e9d431c8e91b90a7ac21.gz.js"></script>

        <script type="text/javascript" src="https://d5wfroyti11sa.cloudfront.net/prod/b/ts3-all-53e5d9a39bd36b844e9dc3ada17644211791f488.gz.js"></script>
        <script type="text/javascript" src="https://d5wfroyti11sa.cloudfront.net/prod/b/ts3-top-ab257ea0fa28e802e8f9e60d8323f5e5dbbce689.gz.js"></script>
        <script type="text/javascript" src="https://d5wfroyti11sa.cloudfront.net/prod/b/ts3-sub-e65f4d09fc2664add7c776e851af088cdad2214f.gz.js"></script>

        <script>
            Tradeshift.url.base = "https://ap-sandbox.tradeshift.com";
            Tradeshift.url.prefix = "";
            Tradeshift.url.controller = "ts3";
            Tradeshift.url.action = "frame";

            Tradeshift.user.completeProfile = true;


            Tradeshift.options = $.extend(Tradeshift.options,{
                language: 'en',
                locale: 'en_US',
                failedDispatchesUpdateInterval: 60000,
                dashboardUpdateInterval: 10000,
                updateInterval: 10000,
                currencyFractionDigits: 2,
                decimalSeparator: '.',

                groupingSeparator: ",",
                enableWebsockets: true,


                dateFormats:{
                    date:"m/d/y",
                    dateTime:"m/d/y h:ii a",
                    time:"h:ii a",
                    firstDayOfWeek:0,
                    iso: {
                        date: "M/d/yy",
                        dateTime: "M/d/yy h:mm a",
                        time: "h:mm a"
                    }
                },
                showErrors: false,
                skipFailedDispatchPolling: false
            });


        </script>


<?
$appService = TS::instance()->getAppService();
$bundle = $appService->getActivationBundle();


if ($bundle->CssUrl) {
    echo '<link rel="stylesheet" type="text/css" href="';
    echo $bundle->CssUrl;
    echo '" />';
}
if ($bundle->DevCss) {
    echo '<style type="text/css">';
    echo $bundle->DevCss;
    echo '</style>';
}

if ($bundle->DevIncludes) {
    echo "\n";
    echo "\n<!-- Dev Bundles Start -->\n\n";
    foreach ($bundle->DevIncludes as $it) {
        echo '<link rel="stylesheet" type="text/css" href="';
        echo $it;
        echo '.css" />';
        echo "\n";
    }
    echo "\n<!-- Dev Bundles End -->\n";
    echo "\n";
}


if ($bundle->JsonUrl) {
    echo '<script type="text/javascript" src="';
    echo $bundle->JsonUrl;
    echo '"></script>';
}

if ($bundle->JsUrl) {
    echo '<script type="text/javascript" src="';
    echo $bundle->JsUrl;
    echo '"></script>';
}

if ($bundle->DevJs) {
    echo '<script type="text/javascript">';
    echo $bundle->DevJs;
    echo '</script>';
}

if ($bundle->DevJson) {
    echo '<script type="text/javascript">';
    echo $bundle->DevJson;
    echo '</script>';
}

if ($bundle->DevIncludes) {
    echo "\n";
    echo "\n<!-- Dev Bundles Start -->\n\n";
    foreach ($bundle->DevIncludes as $it) {

        echo '<script type="text/javascript" src="';
        echo $it;
        echo '.js"></script>';
        echo "\n";

        echo '<script type="text/javascript" src="';
        echo $it;
        echo '.json.js"></script>';
        echo "\n\n\n";
    }
    echo "\n<!-- Dev Bundles End -->\n";
    echo "\n";
}

if ($bundle->T9nUrl) {

    echo '<script type="text/javascript" src="';
    echo $bundle->T9nUrl;
    echo '"></script>';
}

if ($bundle->DevT9n) {
    echo '<script type="text/javascript">ts.locales.init(';
    echo $bundle->DevT9n;
    echo ')</script>';
}


session_commit();

?>



        <script type="text/javascript" >
            window.app = top.app;
        </script>

    </div>
    </body>
</html>
