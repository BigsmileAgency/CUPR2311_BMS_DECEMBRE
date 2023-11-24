<?php 

	
	interface Modulable {

		public function uiImports();

		public function replaceCSS();
		public function replaceHTML();
		public function replaceJS();

		public function getCSS();
		public function getHTML();
		public function getJS();

		public function script(Project $p);

	}


?>