<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	final class ProjectFactory {

		public static function get($pName, Campaign &$pCampaign, AnimationManager &$pAm, &$pInDexVersion, &$pCSSVersion, $default_css = null, $default_js = null){
			$ret = NULL;
			switch($pName){
				case "normal" :
					$ret = new NormalProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "classic-link" :
					$ret = new ClassicLINKProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "dcm" :
					$ret = new DCMProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "overlayer" :
					$ret = new DCMOverLayerProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "hpto" :
					$ret = new DCMHPTOProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "himedia" :
					$ret = new HiMediaProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "adform" :
					$ret = new AdFormProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "adform-overlayer" :
					$ret = new AdFormOverLayerProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "gdn" :
					$ret = new GDNProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "dcrm" :
					$ret = new DCRMProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "dcrm-dynamic" :
					$ret = new DCRMDYNAMICProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "dcrm-expandable" :
					$ret = new DCRMEXPANDABLEProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "dcrm-lightbox" :
					$ret = new DCRMLightboxProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "dcrm-video" :
					$ret = new DCRMVideoProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "dcrm-overlayer" :
					$ret = new DCRMOverlayerVideoProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "sizmek" :
					$ret = new SizmekProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "sizmek-interstitial" :
					$ret = new SizmekInterstitialProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "sizmek-expandable" :
					$ret = new SizmekExpandableProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "weborama" :
					$ret = new WeboramaGSAPProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "weborama-billboard" :
					$ret = new WeboramaBillboardGSAPProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "weborama-skins" :
					$ret = new WeboramaSkinsGSAPProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "weborama-header" :
					$ret = new WeboramaHeaderGSAPProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
				case "weborama-interscroller" :
					$ret = new WeboramaInterscrollerGSAPProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
					break;
        case "xandr" :
          $ret = new XANDRProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
          break;
        case "gamned" :
          $ret = new GAMNEDProject($pCampaign, $pAm, $pInDexVersion, $pCSSVersion, $default_css, $default_js);
          break;

			}
			return $ret;
		}
	}
?>
