<?php

	/*
 	 * Version: 2.01.6
 	 * Date: 2016-06-08
 	 *
 	 * @author: Big Smile Agency, info@bigsmile.be
 	 */

	class Feature {

		protected static $_categories = array('Nouveautés', 'Optimisation', 'Structure', 'Correction de bugs');
		protected static $_changes = array();
		protected static $_html;
		protected static $_archives = array();
		protected static $_version = 'v2.01.10';

		protected static function gen(){

			$v = self::$_version;

			self::$_changes['v2.01.10'][self::$_categories[1]] = array(
				"Mise à jour du template WEBORAMA",
			);

			self::$_changes['v2.01.9'][self::$_categories[1]] = array(
				"Mise à jour du template GDN",
			);

			self::$_changes['v2.01.8'][self::$_categories[0]] = array(
				"Ajout Weborama Template (Standard (weborama) | Skins (weborama-skins) | Billboard (weborama-billboard)). <a href='http://specs.weborama.nl/nl/html-standard-automatedtrading-apto' target='_blank' style='color:#ffffff; text-decoration:underline;'>Documentations</a>",
				"<span class=\"important\">Attention : Skins (check settings.php & common.js) | Billboard (check common.js)</span>",
			);

			self::$_changes['v2.01.7'][self::$_categories[0]] = array(
				'Ajout des helpers width($v) height($v) et asset($v) dans les vues.',

			);

			self::$_changes['v2.01.6'][self::$_categories[0]] = array(
				"<span class=\"important\">Ajout d'une commande cli pour créer un boilerplate vide (php _am/_am.php create-project).</span>",

			);


			self::$_changes['v2.01.5'][self::$_categories[0]] = array(
				"<span class=\"important\">Ajout de la nouvelle version 1.19.1 de GSAP.</span>",
				"<span class=\"ultra important\">Implémentation des ´Custom eases´ de GSAP v1.19.1.</span>",
				"<span class=\"important\">Implémentation des ´Custom wiggle eases´ de GSAP v1.19.1.</span>",
				"<span class=\"important\">Implémentation des ´Custom bounce eases´ de GSAP v1.19.1.</span>",
				"Ajout de l'helper ease() pour générer une ease.",
				"Création d'un système de module interne à L'AM pour l'Aligner et autres modules .",
			);



			self::$_changes['v2.01.1'][self::$_categories[1]] = array(
				"Alignement Désactivation de la fonction getComputedStyle dans le module d'alignement.",
				"Ajout du quantificateur minus lors pour les valeurs en relative des méthodes offset, x, y, size, zone, width, height au module d'alignement.",
			);

			self::$_changes['v2.01.0'][self::$_categories[0]] = array(
				"Ajout d'une classe ou module Javascript pour les alignements.",
			);

			self::$_changes['v2.01.0'][self::$_categories[3]] = array(
				"<span class=\"important\">Correctif sur le Template GDN (Import de TweenMax lors de la désactivation des bibliothèques partagées).</span>",
			);

			self::$_changes['v2.00.9'][self::$_categories[0]] = array(
				"Ajout d'un module sur le template Lumines (Ico photo).",
			);

			self::$_changes['v2.00.9'][self::$_categories[3]] = array(
				"<span class=\"important\">Correctif sur les matrices lors de sa multiplication. (Rotation initialisé avec le Scale à 0).</span>",
			);


			self::$_changes['v2.00.8'][self::$_categories[0]] = array(
				"Ajout d'un template DCRM Overlayer (dcrm-overlayer).",
			);
			self::$_changes['v2.00.8'][self::$_categories[1]] = array(
				"Changement de drm en dcrm.",
			);
			self::$_changes['v2.00.7'][self::$_categories[0]] = array(
				"Ajout d'un template Adform Overlayer (adform-overlayer).",
				"Choix du style d'export grâce à GSAPEngine::ExportAddStyle(), GSAPEngine::ExportClassicStyle(), GSAPEngine::ExportAppendStyle().",
				'Choix de l\'utilisation des bibliothèques partagées grâce à Template::usecdnLibraries($bool).',
				'<span class="important">Choix de l\'interface utilisateur grâce à UI::select($name) et UI::load($vars).</span>',
			);
			self::$_changes['v2.00.7'][self::$_categories[1]] = array(
				"<span class=\"important\">Ajout de la version 1.19.0 de GreenSock.</span>",
				"Ajout du bout de code void(0) lors d'un click sur le clicktag dans les templates dcm.",
			);
			self::$_changes['v2.00.7'][self::$_categories[3]] = array(
				"<span class=\"important\">Correctif sur les matrices initiales non stockées.</span>",
				"<span class=\"important\">Correctif sur les délais lors du lancement de la première animation décalée par une animation de valeur nulle.</span>",
			);
			self::$_changes['v2.00.6'][self::$_categories[0]] = array(
				"Ajout de l'helper dr(".'$sel, $dir'.") pour useDirection().",
				"Ajout de l'helper ic(".'$sel, $ic'.") pour useIterationCount().",
			);
			self::$_changes['v2.00.6'][self::$_categories[1]] = array(
				"<span class=\"important\">Optimisation global du template GDN (AdWords).</span>",
				"<span class=\"important\">Ajout du cdn automatique des bibliothèques GreenSock (hormis TimelineLite) de la version 1.18.0 (la configuration doit être GSAPEngine::version('1.18.0')) sur le template GDN.</span>",
				"<span class=\"important\">Ajout de l'ExitAPI sur le template GDN.</span>"
			);
			self::$_changes['v2.00.5'][self::$_categories[0]] = array(
				"<span class=\"important\">Ajout du Process de contrôle d'url https.</span>"
			);

			self::$_changes['v2.00.4'][self::$_categories[1]] = array(
				"Arrangement mineur de la structure de la classe Project + export/gsap => export.",
				"Désactivation temporaire de certaines fonctionnalitées de l'UI.",
				"Ajout de la valeur rem.",
				"Export mode => Add Style ou Append Style (Default) par le moteur GSAP.",
				"Export mode => Opacity devient Alpha.",
			);

			self::$_changes['v2.00.3'][self::$_categories[0]] = array(
				"<span class=\"important\">Ajout du Process d'archive.</span>",
			);

			self::$_changes['v2.00.2'][self::$_categories[1]] = array(
				"Amélioration de l'interface utilisateur avec responsivité.",
			);

			self::$_changes['v2.00.1'][self::$_categories[0]] = array(
				"<span class=\"important\">Facilité d'écriture grâce aux helpers.</span>",
			);

			self::$_changes['v2.00.1'][self::$_categories[3]] = array(
				"<span class=\"ultra important\">Correctif sur les matrices partagées.</span>",
				"<span class=\"ultra important\">Correctif sur les transformations 3d.</span>",
			);

			self::$_changes['v2.00.0'][self::$_categories[0]] = array(
				"<span class=\"important\">On peut rajouter des proriétés groupe comme 'Attr'(Permet d'animer des svg) ou 'Bezier'(Permet d'animer en courbe).</span>",
				"<span class=\"ultra important\">On peut switcher sur le moteur TweenLite ou TweenMax.</span>",
				"<span class=\"important\">Rajout de ease manquants (Power0, Power1, Power3, Power4, Stepped et SlowMo).</span>",
				"<span class=\"ultra important\">Les fichiers html, css et/ou js peuvent etre en php. De plus la méthode passData de la classe Project permet de transférer des données.</span>",
				"<span class=\"ultra important\">On peut utiliser SASS(SCSS) et/ou LESS.</span>",
				"<span class=\"important\">On peut utiliser des valeurs ou sélecteurs générés par le javascript grâce au préfixe 'js:'.</span>",
				"On peut décider d'activer l'import si nécessité de l'asset grâce à la méthode path de la classe AssetCollection.",
				"On peut utiliser les valeurs relatives (Attention à useIterationCount car cela ne devient plus un repeat sauf si la valeur init est existante et absolue).",
				"On peut utiliser les cubic Bezier en easing.",
				"On peut choisir sa version GreenSock avec GSAPEngine::version(".'$version'.").",
				"<span class=\"ultra important\">Rajout de la version et du Copyright.</span>",
				"<span class=\"important\">Ajout du template AdForm Standard.</span>",
			);

			self::$_changes['v2.00.0'][self::$_categories[1]] = array(
				"<span class=\"important\">Le fichier index à l'export a été épuré (gain en poids).</span>",
				"<span class=\"important\">Désactivation et suppression du moteur CSS3. L'initialisation des valeurs se fait en js via GreenSock (clarté du code + gain en poids).</span>",
				"La propriété groupe 'css' a été désactivée.",
				"<span class=\"important\">L'écriture des ease peut se faire en chaîne de caractères.</span>",
				"<span class=\"important\">Pas d'initialisation forcée de valeurs dans le data.</span>",
				"<span class=\"important\">La sécurité sur l'attente de fin d'animation a été désactivée.</span>",
				"<span class=\"important\">Suppression du dossier d'export à chaque nouvel export.</span>",
			);

			self::$_changes['v2.00.0'][self::$_categories[2]] = array(
				"<span class=\"important\">Les placements d'objet dans le gestionnaire d'animation se font automatiquement via le fichier data.</span>",
				"<span class=\"ultra important\">Les bases ou propriétés customisées se font automatiquement via le fichier data.</span>",
				"sizmek_dev_mode dans le type de template se fait uniquement via la méthode devMode de la classe Project.",
				"Changement de labels pour GetValueProcess.",
				"<span class=\"important\">Ajout des labels Loading et Init pour GetValueProcess (loading et init permet de décider nous même le lancement d'animation et d'initialisation d'objets GreenSock).</span>",
				"Tous les templates sont OneFile.",
				"<span class=\"important\">Suppression des styles et bordures prédéfinies dans les templates.</span>",
				"Suppression des User Project (Plus besoin grâce aux nouvelles fonctionnalités et l'import de fichier scss et less).",
			);

			self::$_changes['v2.00.0'][self::$_categories[3]] = array(
				"<span class=\"ultra important\">Correctif de la méthode useDelay après la méthode chain.</span>",
				"Correctif sur la méthode config (second paramètre) pour Elastic.ease.",
				"Correctif sur la classe BasicMinifier.",
				"<span class=\"important\">Correctif sur duration zéro grâce à immediateRender.</span>",
				"<span class=\"ultra important\">Correctif sur les http secure en Sizmek.</span>",
			);


			foreach(self::$_changes as $k => $v){
				self::$_html .= "<ul><li><h2>".$k."</h2></li><li><ul>";
				foreach($v as $k2 => $v2){
					self::$_html .= "<li class=\"n\"><h3>".$k2."<h3></li><li><ul>";
					foreach($v2 as  $v3){
						self::$_html .= "<li><span>";
						self::$_html .= "-&nbsp;&nbsp;&nbsp;".$v3;
						self::$_html .= "</span></li>";
					}
					self::$_html .= "</ul></li>";
				}
				self::$_html .= "</ul></li></ul>";
			}
		}

		public static function read(){
			self::gen();
			echo self::$_html;
		}

	}


?>
