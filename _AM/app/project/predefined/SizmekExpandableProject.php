<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class SizmekExpandableProject extends Project {

		protected $_expand;
		protected $_expand_width;
		protected $_expand_height;
		protected $_expand_offset_x = 0;
		protected $_expand_offset_y = 0;
		protected $_single_exp = false;
		protected $_close_text = "X";
		

		public function __construct(Campaign &$pCampaign, AnimationManager &$pAm, &$pInDexVersion, &$pCSSVersion, $default_css = null, $default_js = null){
			$template = TemplateFactory::get("sizmek-expandable");
			parent::__construct($pCampaign, $template, $pAm, $default_css, $default_js);
			$this -> _css_file = $pCSSVersion;
			$this -> _data_template = new Template($pInDexVersion);
			$this -> _data_template -> add(new Asset("style", $pCSSVersion, AssetType::CSS));
			$this -> _data_template -> add(new Asset("customStyle", $this -> _default_custom_css, AssetType::CSS));
			$this -> _data_template -> add(new Asset("customScript", $this -> _default_custom_js, AssetType::JS));
			$this -> _folder = 'sizmek-expandable';

		}

		public function closeText($close){
			$this -> _close_text = strval($close);
		}

		public function singleExpandable(){
			$this -> _single_exp = true;
		}

		public function expandable(){
			$this -> _single_exp = false;
		}

		public function isSingleExpandable(){
			return($this -> _single_exp);
		}

		

		public function attachExpandable(AnimationManager &$pAm, $width, $height){
			$this -> _expand = $pAm;

			if($this -> _campaign -> getFormat() -> getWidth() > $width)
				$this -> _expand_offset_x = intval($this -> _campaign -> getFormat() -> getWidth() - $width);
			if($this -> _campaign -> getFormat() -> getHeight() > $height)
				$this -> _expand_offset_y = intval($this -> _campaign -> getFormat() -> getHeight() - $height);

			$this -> _expand_width = intval($width);
			$this -> _expand_height = intval($height);
		}

		public function apply(){

			$enginegsap = new GSAPEngine($this -> _animation_manager , new GSAPFormatEngine(), NULL, "collapse");
			$pos = $enginegsap -> isTweenMax() ? 'i2' : 'i1';

			$enginegsapexp = new GSAPEngine($this -> _expand , new GSAPFormatEngine(), NULL, "expand");

			if($pos == 'i1'){
				$pos = $enginegsapexp -> isTweenMax() ? 'i2' : 'i1';

				if($pos == 'i2')
					$enginegsap -> toTweenMax();

			} else {
				$enginegsapexp -> toTweenMax();
			}

			$this -> importEngineLibraries($enginegsap, $pos);

			if($this -> isSingleExpandable())
				$this -> _template -> add($this -> _template -> getAssetsScheme('i2'));
			else
				$this -> _template -> add($this -> _template -> getAssetsScheme('i1'));

			$this -> addProcess($p1 = new TemplateSaveProcess($this -> _template, "export/".$this -> _folder."/".$this -> _campaign -> getFullName()));
			$udata = $this -> obtainData();
			$udata['data_template'] = $this -> _data_template;
			$udata['assets'] = $this -> _assets;
			$udata['meta'] = self::$accept_meta;
			$udata['devMode'] =  $this -> _dev_mode;
			$udata['testComputedStyleForFirefox'] =  $this -> _testComputedStyleForFirefox;
			//$udata['allowEvents'] = $this -> _has_events;

			$p1 -> passData($udata);
			$p1 ->apply();
			$this -> _template  = $p1 -> getNewTemplate();
			$this -> addProcess($p2 = new GetValueProcess($this -> _data_template, $this -> _campaign));
			$p2 -> passData($this -> obtainData());

				$p2 -> get("collapseContent");
				$p2 -> get("expandContent");
				$p2 -> get("CollapseJS");
				$p2 -> get("ExpandJS");
				$p2 -> get("import");
				$p2 -> get("style");
				$p2 -> get("customStyle");
				$p2 -> get("custom");
				$p2 -> get("loaded");
				$p2 -> get("functions");
				$p2 -> get("events");
				$p2 -> get("init");
				$p2 -> get("vars");
				
			$arr = $p2 -> apply();

			$this -> addProcess($p3 = new ReplaceValueProcess($this -> _template));

			$p3 -> replace("lang",$this -> _language);
			$p3 -> replace("author",$this -> _author);
			$p3 -> replace("description",$this -> _description);
			$p3 -> replace("keywords",$this -> _keywords);

			$p3 -> replace("title",$this -> _campaign -> getFullName());
			$p3 -> replace("width",$this -> _campaign -> getFormat() -> getWidth());
			$p3 -> replace("height",$this -> _campaign -> getFormat() -> getHeight());
			$p3 -> replace("borderWidth",$this -> _campaign -> getFormat() -> getWidth() -2);
			$p3 -> replace("borderHeight",$this -> _campaign -> getFormat() -> getHeight() -2);


			if($this -> isSingleExpandable())
				$import_exp_plugin = '<script type="text/javascript" src="single_expandable.js"></script>';
			else
				$import_exp_plugin = '<script type="text/javascript" src="expandable_banner.js"></script>';


			$p3 -> replace("import", $import_exp_plugin. $this -> _template -> getImports($pos).$arr["import"]);

			$p3 -> replace("style",$arr["style"]);
			$p3 -> replace("extImport",$this -> _template -> getExternalImport());
			$p3 -> replace("close_text",$this -> _close_text);
			$p3 -> replace("dev_mode",$this -> _dev_mode);

			$p3 -> replace("expand-width",$this -> _expand_width);
			$p3 -> replace("expand-height",$this -> _expand_height);

			$p3 -> replace("expand-offset-x",$this -> _expand_offset_x);
			$p3 -> replace("expand-offset-y",$this -> _expand_offset_y);

			$result_gsap = $enginegsap -> initResult();
			$p3 -> replace("collapse-gsapinstance",$result_gsap -> getResult());
			$result_gsap = $enginegsap -> resetResult();
			$p3 -> replace("collapse-gsapinit",$result_gsap -> getResult());
			$result_gsap = $enginegsap -> instanceResult();
			$p3 -> replace("collapse-gsapinstance_null",$result_gsap -> getResult());
			$result_gsap = $enginegsap -> animationResult();
			$p3 -> replace("collapse-gsapanimation",$result_gsap -> getResult());
			$result_gsap = $enginegsap -> playResult();
			$p3 -> replace("collapse-gsapplay",$result_gsap -> getResult());
			$result_gsap = $enginegsap -> stopResult();
			$p3 -> replace("collapse-gsapstop",$result_gsap -> getResult());
			$result_gsap = $enginegsap -> stopAtEndResult();
			$p3 -> replace("collapse-gsapstopatend",$result_gsap -> getResult());
			$result_gsap = $enginegsapexp -> initResult();
			$p3 -> replace("expand-gsapinstance",$result_gsap -> getResult());
			$result_gsap = $enginegsapexp -> resetResult();
			$p3 -> replace("expand-gsapinit",$result_gsap -> getResult());
			$result_gsap = $enginegsapexp -> instanceResult();
			$p3 -> replace("expand-gsapinstance_null",$result_gsap -> getResult());
			$result_gsap = $enginegsapexp -> animationResult();
			$p3 -> replace("expand-gsapanimation",$result_gsap -> getResult());
			$result_gsap = $enginegsapexp -> playResult();
			$p3 -> replace("expand-gsapplay",$result_gsap -> getResult());
			$result_gsap = $enginegsapexp -> stopAtEndResult();
			$p3 -> replace("expand-gsapstop",$result_gsap -> getResult());

			$result_gsap = $enginegsapexp -> stopResult();
			$p3 -> replace("expand-gsapstopatend",$result_gsap -> getResult());

			if(isset($arr["customStyle"]))
				$p3 -> replace("custom-style",$arr["customStyle"]);
			else
				$p3 -> replace("custom-style",'');
			if(isset($arr["custom"]))
				$p3 -> replace("custom-script", $arr["custom"]);
			else
				$p3 -> replace("custom-script",'');

			if(isset($arr["CollapseJS"]))
				$p3 -> replace("collapse-custom", $arr["CollapseJS"]);
			else
				$p3 -> replace("collapse-custom",'');


			if(isset($arr["ExpandJS"]))
				$p3 -> replace("expand-custom", $arr["ExpandJS"]);
			else
				$p3 -> replace("expand-custom",'');

			if(isset($arr["loaded"]))
					$p3 -> replace("loaded-script", $arr["loaded"]);
			else
					$p3 -> replace("loaded-script",'init();');
			if(isset($arr["functions"]))
				$p3 -> replace("custom-function", $arr["functions"]);
			else
				$p3 -> replace("custom-function",'');

			if(isset($arr["events"]))
				$p3 -> replace("custom-events", $arr["events"]);
			else
				$p3 -> replace("custom-events",'');
			if(isset($arr["init"]))
				$p3 -> replace("custom-init", $arr["init"]);
			else
				$p3 -> replace("custom-init",'launch();');
			if(isset($arr["vars"]))
				$p3 -> replace("custom-vars", $arr["vars"]);
			else
				$p3 -> replace("custom-vars",'');


			$p3 -> replace("collapse-content",$arr["collapseContent"]);
			$p3 -> replace("expand-content",$arr["expandContent"]);

			if(count(Module::all())){
				$ms = Module::all();
				foreach($ms as $mod){
					if(!is_null($mod -> replaceCSS()))
						$p3 -> replace($mod -> replaceCSS(),$mod -> getCSS());	

					if(!is_null($mod -> replaceHTML()))
						$p3 -> replace($mod -> replaceHTML(),$mod -> getHTML());

					if(!is_null($mod -> replaceJS()))	
						$p3 -> replace($mod -> replaceJS(),$mod -> getJS());	
				}
			}
			
			$p3 -> apply();
			$this -> addProcess($p5 = new CompileProcess($this -> _template));
			$p5 -> apply();
			if(self::$minify){$this -> addProcess($p4 = new MinifierProcess($this -> _template));
			$p4 -> apply();}

			$this -> addProcess($pZip = new ZipArchiveProcess($this -> _template, "export/".$this -> _folder."/".$this -> _campaign -> getFullName(), "export/".$this -> _folder."/ziparchives/".$this -> _campaign -> getFullName()));
			$pZip -> apply();

			$this -> addProcess($pProt = new ProtocolProcess($this -> _template, "export/".$this -> _folder."/".$this -> _campaign -> getFullName()."/index.html"));
			$pProt -> apply();

			if(count(Module::all()))
				$p1 -> copy();


		}
	}


?>
