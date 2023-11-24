<?php
/*
 * Version: 2.01.6
 * Date: 2016-06-08
 *
 * @author: Big Smile Agency, info@bigsmile.be
*/

final class TemplateFactory
{

    public static function get($name)
    {
        $ret = NULL;
        switch ($name)
        {

            case "normal":
                $ret = new NormalGSAPTemplate();
            break;

            case "classic-link":
                $ret = new CLASSICGSAPTemplate();
            break;

            case "dcrm-lightbox":
                $ret = new DCRMGSAPLightboxTemplate();
            break;

            case "dcm":
                $ret = new DCMGSAPTemplate();
            break;

            case "overlayer":
                $ret = new DCMOverLayerGSAPTemplate();
            break;

            case "himedia":
                $ret = new HiMediaGSAPTemplate();
            break;

            case "adform":
                $ret = new AdFormGSAPTemplate();
            break;

            case "adform-overlayer":
                $ret = new AdFormOverLayerGSAPTemplate();
            break;

            case "dcm-hpto":
                $ret = new DCMGSAPHPTOTemplate();
            break;

            case "gdn":
                $ret = new GDNGSAPTemplate();
            break;

            case "dcrm":
                $ret = new DCRMGSAPTemplate();
            break;

            case "dcrm-dynamic":
                $ret = new DCRMDYNAMICGSAPTemplate();
            break;

            case "dcrm-expandable":
                $ret = new DCRMEXPANDABLETemplate();
            break;

            case "dcrm-video":
                $ret = new DCRMVideoGSAPTemplate();
            break;

            case "dcrm-overlayer":
                $ret = new DCRMOverlayerVideoGSAPTemplate();
            break;

            case "sizmek":
                $ret = new SizmekGSAPTemplate();
            break;

            case "sizmek-interstitial":
                $ret = new SizmekInterstitialGSAPTemplate();
            break;

            case "sizmek-expandable":
                $ret = new SizmekExpandableGSAPTemplate();
            break;

            case "weborama":
                $ret = new WeboramaGSAPTemplate();
            break;

            case "weborama-billboard":
                $ret = new WeboramaBillboardGSAPTemplate();
            break;

            case "weborama-skins":
                $ret = new WeboramaSkinsGSAPTemplate();
            break;

            case "weborama-header":
                $ret = new WeboramaHeaderGSAPTemplate();
            break;

            case "weborama-interscroller":
                $ret = new WeboramaInterscrollerGSAPTemplate();
            break;

            case "xandr":
                $ret = new XANDRGSAPTemplate();
            break;

            case "gamned":
                $ret = new GAMNEDGSAPTemplate();
            break;

        }

        return $ret;
    }

}

?>
