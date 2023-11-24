<?php


	class AlignerModule implements Modulable {

		protected $file;
		public static $cssOutput = false;

		public function uiImports() {
			return '<script src="'.AppPath::getPath().'/modules/Aligner/Aligner.js"></script>';
		}

		public function replaceCSS() {
			return 'AlignerCSS';
		}

		public function replaceHTML() {
		}

		public function replaceJS() {
		}

		public function getCSS() {
			return '.am.aligner-modules.std{left:0}';
		}

		public function getHTML() {
		}

		public function getJS() {
		}

		public function file($f) {
			$this -> file = $f;
		}

		public function script(Project $p) {
			$cnt = '';
			$data = $p -> obtainData();

			$e = "
			var f = true;
			$(document).ready(function() {
					var iframe = document.getElementById('iframe').contentWindow || document.getElementById('iframe').contentWindow;

					var t = setInterval(function() {
					var container = iframe.document.getElementById('container');
					if(container !== null) {
						if(iframe.getComputedStyle(container, null).getPropertyValue('width')){
							alignInIframe('#iframe');
							clearInterval(t);
							";

							if($this -> file) {
								 $e.= FormatContent::formattedContent($this -> file, $data);
							}
				  			$e.="var e = AlignerStylesheetRules.css();
				  			$.ajax({
				  			  cache: false,
							  method: 'POST',
							  url: '".appPath::getPath()."/modules/Aligner/replace.php',
							  data: { export: '".($p->getAbsExport())."', exportDir: '".($p->getAbsExportDir())."', zipDir: '".($p->getAbsExportZip())."', by:e }
							}).done(function( msg ) {
								console.log(msg);
								f = false;
								document.getElementById('iframe').src = '".$p->getExport().'?i='.uniqid()."';
								if(typeof document.getElementById('iframe_clone') != "undefined") {
									document.getElementById('iframe_clone').src = '".$p->getExport().'?i='.uniqid()."';
								}
								console.log('Aligner Success');
								".(self::$cssOutput == true ? 'console.log(AlignerStylesheetRules.formated_scss());' : '')."
							}).fail(function( msg ) {
								console.log('Aligner Failed');
							});
  				}
			}
  		}, 50); });

		function loading() {
			if(f) return;
			document.getElementById('iframe').style.visibility = 'visible';
		}
";
			return $e;
		}

	}


?>
