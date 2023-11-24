<?php
	
	class BasicMinifier {
		
		// HTML Minifier
		public static function minify_html($input) {
			if(trim($input) === "") return $input;
			// Remove extra white-spaces between HTML attributes
			$input = preg_replace_callback('#<([^\/\s<>!]+)(?:\s+([^<>]*?)\s*|\s*)(\/?)>#s', function($matches) {
				return '<' . $matches[1] . preg_replace('#([^\s=]+)(\=([\'"]?)(.*?)\3)?(\s+|$)#s', ' $1$2', $matches[2]) . $matches[3] . '>';
			}, $input);
			// Minify inline CSS declarations
			if(strpos($input, ' style=') !== false) {
				$input = preg_replace_callback('#\s+style=([\'"]?)(.*?)\1(?=[\/\s>])#s', function($matches) {
					return ' style=' . $matches[1] . BasicMinifier::minify_css($matches[2]) . $matches[1];
				}, $input);
			}
			return preg_replace(
				array(
					// Remove HTML comments except IE comments
					'#\s*(<\!--(?=\[if).*?-->)\s*|\s*<\!--.*?-->\s*#s',
					'#(?:\s+&nbsp;)|(?:&nbsp;\s+)#s',
					// Do not remove white-space after image and
					// input tag that is followed by a tag open
					'#(<(?:img|input)(?:\/?>|\s[^<>]*?\/?>))\s+(?=\<[^\/])#s',
					// Remove two or more white-spaces between tags
					'#(<\!--.*?-->)|(>)\s{2,}|\s{2,}(<)|(>)\s{2,}(<)#s',
					// Proofing ...
					// o: tag open, c: tag close, t: text
					// If `<tag> </tag>` remove white-space
					// If `</tag> <tag>` keep white-space
					// If `<tag> <tag>` remove white-space
					// If `</tag> </tag>` remove white-space
					// If `<tag>    ...</tag>` remove white-spaces
					// If `</tag>    ...<tag>` remove white-spaces
					// If `<tag>    ...<tag>` remove white-spaces
					// If `</tag>    ...</tag>` remove white-spaces
					// If `abc <tag>` keep white-space
					// If `<tag> abc` remove white-space
					// If `abc </tag>` remove white-space
					// If `</tag> abc` keep white-space
					// TODO: If `abc    ...<tag>` keep one white-space
					// If `<tag>    ...abc` remove white-spaces
					// If `abc    ...</tag>` remove white-spaces
					// TODO: If `</tag>    ...abc` keep one white-space
					'#(<\!--.*?-->)|(<(?:img|input)(?:\/?>|\s[^<>]*?\/?>))\s+(?!\<\/)#s', // o+t | o+o
					'#(<\!--.*?-->)|(<[^\/\s<>]+(?:>|\s[^<>]*?>))\s+(?=\<[^\/])#s', // o+o
					'#(<\!--.*?-->)|(<\/[^\/\s<>]+?>)\s+(?=\<\/)#s', // c+c
					'#(<\!--.*?-->)|(<([^\/\s<>]+)(?:>|\s[^<>]*?>))\s+(<\/\3>)#s', // o+c
					'#(<\!--.*?-->)|(<[^\/\s<>]+(?:>|\s[^<>]*?>))\s+(?!\<)#s', // o+t
					'#(<\!--.*?-->)|(?!\>)\s+(<\/[^\/\s<>]+?>)#s', // t+c
					'#(<\!--.*?-->)|(?!\>)\s+(?=\<[^\/])#s', // t+o
					'#(<\!--.*?-->)|(<\/[^\/\s<>]+?>)\s+(?!\<)#s', // c+t
					'#(<\!--.*?-->)|(\/>)\s+(?!\<)#', // o+t
					// Replace `&nbsp;&nbsp;&nbsp;` with `&nbsp; &nbsp;`
					'#(?<=&nbsp;)(&nbsp;){2}#',
					// Proofing ...
					'#(?<=\>)&nbsp;(?!\s|&nbsp;|<\/)#',
					'#(?<=--\>)(?:\s|&nbsp;)+(?=\<)#',
					
				),
				array(
					'$1',
					'&nbsp;',
					'$1&nbsp;',
					'$1$2$3$4$5',
					'$1$2&nbsp;', // o+t | o+o
					'$1$2', // o+o
					'$1$2', //c+c
					'$1$2$4', // o+c
					'$1$2', // o+t
					'$1$2', // t+c
					'$1$2 ', // t+o
					'$1$2 ', // c+t
					'$1$2 ', // o+t
					' $1',
					' ',
					""
					
				),
			trim($input));
		}
		// https://github.com/GaryJones/Simple-PHP-CSS-Minification/blob/master/minify.php
    public static function minify_css($input) {
      if(trim($input) === "") return $input;
      // Normalize whitespace
      $input = preg_replace( '/\s+/', ' ', $input );
      
      // Remove spaces before and after comment
      $input = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $input );

      // Remove comment blocks, everything between /* and */, unless
      // preserved with /*! ... */ or /** ... */
      $input = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $input );

      // Remove ; before }
      $input = preg_replace( '/;(?=\s*})/', '', $input );

      // Remove space after , : ; { } */ >
      $input = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $input );

      // Remove space before , ; { } ( ) >
      $input = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $input );

      // Strips leading 0 on decimal values (converts 0.5px into .5px)
      $input = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $input );

      // Strips units if value is 0 (converts 0px to 0)
      $input = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $input );

      // Converts all zeros value into short-hand
      $input = preg_replace( '/0 0 0 0/', '0', $input );

      // Shortern 6-character hex color codes to 3-character where possible
      $input = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $input );

      return trim( $input );
    }
		// JavaScript Minifier
		public static function minify_js($input) {
			if(trim($input) === "") return $input;
			return preg_replace(
				array(
					// '#(?<!\\\)\\\\\"#',
					// '#(?<!\\\)\\\\\'#',
					// Remove comments
					'#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*\s*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*[\n\r]*#',
					// Remove unused white-space characters outside the string and regex
					'#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\.,;]|[gimuy]))|\s*([+\-\=\/%\(\)\{\}\[\]<>\|&\?\!\:;\.,])\s*#s',
					// Remove the last semicolon
					'#;+\}#',
					// Replace `true` with `!0`
					// '#\btrue\b#',
					// Replace `false` with `!1`
					// '#\bfalse\b#',
					// Minify object attribute except JSON attribute. From `{'foo':'bar'}` to `{foo:'bar'}`
					'#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
					// --ibid. From `foo['bar']` to `foo.bar`
					'#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
				),
				array(
					// '\\u0022',
					// '\\u0027',
					'$1',
					'$1$2',
					'}',
					// '!0',
					// '!1',
					'$1$3',
					'$1.$3'
				),
			trim($input));
		}
		
		// Space Minifier
		public static function minify_all($input) {
			if(trim($input) === "") return $input;
			
			
			if(strpos($input, '<style') !== false) {
				$input = preg_replace_callback("#(\<style(?:.*?)>)(.*?)(?:<\/)#s", function($matches) {
					return $matches[1]. BasicMinifier::minify_css($matches[2]).'</';
				}, $input);
			}
			
			if(strpos($input, '<script') !== false) {
				$input = preg_replace_callback("#(\<script(?:.*?)>)(.*?)(?:<\/)#s", function($matches) {
					return $matches[1]. BasicMinifier::minify_js($matches[2]).'</';
				}, $input);
			}
			
			
			
			return  preg_replace_callback("#^(.*?)$#s", function($matches) {
					return preg_replace("#(?:\t|\n|\r)*#", '', BasicMinifier::minify_html($matches[1]));
				}, trim($input));
			
		}
		
	}
?>