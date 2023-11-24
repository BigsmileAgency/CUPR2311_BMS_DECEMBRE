<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class DCMHPTOProject extends Project {


		public function __construct(Campaign &$pCampaign, AnimationManager &$pAm, &$pInDexVersion, &$pCSSVersion, $default_css = null, $default_js = null){
			$template = TemplateFactory::get("dcm-hpto");
			parent::__construct($pCampaign, $template, $pAm, $default_css, $default_js);
			$this -> _css_file = $pCSSVersion;
			$this -> _data_template = new Template($pInDexVersion);
			$this -> _data_template -> add(new Asset("style", $pCSSVersion, AssetType::CSS));
			$this -> _data_template -> add(new Asset("customStyle", $this -> _default_custom_css, AssetType::CSS));
			$this -> _data_template -> add(new Asset("customScript", $this -> _default_custom_js, AssetType::JS));
			$this -> _folder = 'hpto';

		}

	
		public function apply(){

			$enginegsap = new GSAPEngine($this -> _animation_manager , new GSAPFormatEngine());
			$pos = $enginegsap -> isTweenMax() ? 'i2' : 'i1';


			$this -> importEngineLibraries($enginegsap, $pos);


			$this -> addProcess($p1 = new TemplateSaveProcess($this -> _template, "export/".$this -> _folder."/".$this -> _campaign -> getFullName(), AppPath::getPath()."/temporary/uiview/".$this -> _campaign -> getFullName()));
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
			$this -> addProcess($p2f = new GetFileContentProcess($this -> _template, $this -> _campaign));
			$p2f -> passData($this -> obtainData());
				$p2 -> get("left");
				$p2 -> get("top");
				$p2 -> get("right");
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

			$p3 -> replace("clicktag",$this -> _default_clicktag);
			$p3 -> replace("title",$this -> _campaign -> getFullName());
			$p3 -> replace("width",$this -> _campaign -> getFormat() -> getWidth());
			$p3 -> replace("height",$this -> _campaign -> getFormat() -> getHeight());
			$p3 -> replace("borderWidth",$this -> _campaign -> getFormat() -> getWidth() -2);
			$p3 -> replace("borderHeight",$this -> _campaign -> getFormat() -> getHeight() -2);
			$p3 -> replace("import", $this -> _template -> getImports($pos).$arr["import"]);
			$p3 -> replace("style",$arr["style"]);
			$p3 -> replace("extImport", $this -> _template -> getExternalImport());


			$result_gsap = $enginegsap -> initResult();
			$p3 -> replace("gsapinstance",$result_gsap -> getResult());
			$result_gsap = $enginegsap -> resetResult();
			$p3 -> replace("gsapinit",$result_gsap -> getResult());
			$result_gsap = $enginegsap -> instanceResult();
			$p3 -> replace("gsapinstance_null",$result_gsap -> getResult());
			$result_gsap = $enginegsap -> animationResult();
			$p3 -> replace("gsapanimation",$result_gsap -> getResult());
			$result_gsap = $enginegsap -> playResult();
			$p3 -> replace("gsapplay",$result_gsap -> getResult());

			if(isset($arr["customStyle"]))
				$p3 -> replace("custom-style", $arr["customStyle"]);
			else
				$p3 -> replace("custom-style",'');

			if(isset($arr["custom"]))
				$p3 -> replace("custom-script", $arr["custom"]);
			else
				$p3 -> replace("custom-script",'');
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


			$p3 -> replace("left",$arr["left"]);
			$p3 -> replace("top",$arr["top"]);
			$p3 -> replace("right",$arr["right"]);
			
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
