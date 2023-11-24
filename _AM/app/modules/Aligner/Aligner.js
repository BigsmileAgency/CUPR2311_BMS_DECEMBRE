/*!
 * VERSION: 1.00
 * DATE: 2017-03-28
 * 
 * @author: Big Smile Agency, info@bigsmile.be
 **/
(function(window, moduleName) {
	"use strict";
	var __defined = [], __statics = [],
		__globals = window.AMmodules = window.AMmodules || window,
		__doc = window.document,
		__class = function(n, func){
			if(__defined.indexOf(n) == -1){ __defined.push(n)};
			return func || function() {};
		},
		__static = function(n, object){
			if(__defined.indexOf(n) == -1){ __defined.push(n)};
			return object || {};
		};
		

		var __getComputedStyle = __doc.defaultView ? (__doc.defaultView.getComputedStyle ? __doc.defaultView.getComputedStyle : function(){}) : function(){};

		var __iframe = __globals.alignInIframe = function(sel){
			__doc = window.document.querySelector(sel).contentWindow.document || window.document.querySelector(sel).content.document;
		}	

/*
 * ----------------------------------------------------------------
 * Alignable
 * ----------------------------------------------------------------
 */

		var Alignable = __class('Alignable' ,function(selector, params) {
			var el = selector || 'body';
			this.element = __doc.querySelector(el);
			this.name = el;
			this._x = params && params.hasOwnProperty('x') ? params.left : undefined;
			this._y = params && params.hasOwnProperty('y') ? params.top  : undefined;
			this._width = params && params.hasOwnProperty('width') ? params.width : undefined;
			this._height = params && params.hasOwnProperty('height') ? params.height  : undefined;
		}), __proto = Alignable.prototype;

		__proto.constructor = Alignable,
		__proto.width = function(){
			return this._width != undefined ? this._width : __getComputedStyle(this.element).getPropertyValue('width');
		},__proto.height = function(){
			return this._height != undefined ? this._height : __getComputedStyle(this.element).getPropertyValue('height');
		},__proto.x = function(){
			return this._x != undefined  ? this._x :  __getComputedStyle(this.element).getPropertyValue('left');
		},__proto.y = function(){
			return this._y != undefined  ? this._y :  __getComputedStyle(this.element).getPropertyValue('top');
		},__proto.name = function(){
			return this.name;
		},__proto.element = function(){
			return  this.element;
		};

		__globals.Alignable = Alignable;

/*
 * ----------------------------------------------------------------
 * Aligner
 * ----------------------------------------------------------------
 */
		var Aligner = __static('Aligner', {
			alignables : [],
			aligned : [],
			blockAlignementForSecurity : true,
			defaultParent : null,
			getOnly : false,

			vars : {
				parent : null,
				mode : 0,
				size : {},
				position : {x: 0, y: 0}
			}
		});

		var Alignement = __globals.Alignement = {
			WIDTH : 'x',
			HEIGHT : 'y',
			HORIZONTAL : 'x',
			VERTICAL : 'y',
			WIDTH : 'x',
			HEIGHT : 'y',
		};

		Aligner.setDefaultParent = function(parent) {
			Aligner.defaultParent = parent.constructor == Alignable ? parent : new Alignable(parent);
		};

		Aligner.elements = function(alignables) {
			if(typeof(alignables) == 'object'){
				for(var o in alignables){ 
					Aligner.alignables.push(Aligner.getExistant(alignables[o])); 
				}
			} else {
				Aligner.alignables.push(Aligner.getExistant(alignables));
			}

			return Aligner;
		};

		Aligner.mode = function(alignement) {
			Aligner.vars.mode = alignement == 'x' || alignement == 'y' ? alignement : 0;
			return Aligner;
		};

		Aligner.parent = function(parent) {
			Aligner.vars.parent = parent.constructor == Alignable? parent : new Alignable(parent);
			return Aligner;
		};

		Aligner.width = function(width) {
			Aligner.vars.width = width;
			return Aligner;
		};

		Aligner.height = function(height) {
			Aligner.vars.height = height;
			return Aligner;
		};

		Aligner.zone = function(zone) {
			if(Aligner.vars.mode === Alignement.WIDTH) { Aligner.vars.size.width = zone; } 
			else if(Aligner.vars.mode === Alignement.HEIGHT) { Aligner.vars.size.height = zone; }
			else {
				Aligner.vars.size.width = zone;
				Aligner.vars.size.height = zone;
			}
			return Aligner;
		};

		Aligner.size = function(size) {
			return Aligner.zone(size);
		};

		Aligner.x = function(x) {
			Aligner.vars.x = x;
			return Aligner;
		};

		Aligner.y = function(y) {
			Aligner.vars.y = y;
			return Aligner;
		};

		Aligner.offset = function(offset) {
			if(Aligner.vars.mode === Alignement.WIDTH) {Aligner.vars.position.x = offset;}
			else if(Aligner.vars.mode === Alignement.HEIGHT) {Aligner.vars.position.y = offset;} 
			else {
				Aligner.vars.position.x = offset;
				Aligner.vars.position.y = offset;
			}
			return Aligner;
		};

		Aligner.infos = function(alignable) {
			var tmp = alignable.constructor == Alignable ? alignable : (typeof(alignable) == 'string' ? new Alignable(alignable) : null);
			var oa = [];

			var exist = Aligner.aligned.filter(function(e) {
				return e.name == tmp.name;
			});

			var result = (exist.length) ?  exist[0] : tmp;
			return {left: parseFloat(result.x()), top: parseFloat(result.y()), width: parseFloat(result.width()), height: parseFloat(result.height())};
		};

		Aligner.align = function() {
			if(!Aligner.alignables.length) {
				return;
			}
			var mode_get = Aligner.getOnly,
				total = 0, 
				alloc = 0, 
				space = 0,
				prop = Aligner.vars.mode === Alignement.WIDTH ?  'left' : ( Aligner.vars.mode === Alignement.HEIGHT ? 'top' : null),
				prop2 = Aligner.vars.mode === Alignement.WIDTH ?  'width' : ( Aligner.vars.mode === Alignement.HEIGHT ? 'height' : null),
				prop3 = Aligner.vars.mode === Alignement.WIDTH ?  'x' : ( Aligner.vars.mode === Alignement.HEIGHT ? 'y' : null),
				offset = 0,
				zone = 0,
				parent_element = null,
				method = prop2,
				get = [],
				reg = /^([-\+\*\/])=(-?(?:(?:(?:[0-9]+)(?:\.[0-9]+)?)|(?:(?:\.[0-9]+)?)))$/;
			
			if(typeof(Aligner.vars.size[prop2]) != 'undefined'){
				if(reg.test(Aligner.vars.size[prop2])) {
					var matches = reg.exec(Aligner.vars.size[prop2]);
					if(Aligner.vars.parent) { zone = parseFloat(Aligner.vars.parent[method]()); }
					else { zone = (Aligner.defaultParent ? parseFloat(Aligner.defaultParent[method]()) : 0);}
					switch(matches[1]) {
						case '+':
							zone += parseFloat(matches[2]);
							break;
						case '-':
							zone -= parseFloat(matches[2]);
							break;
						case '*':
							zone *= parseFloat(matches[2]);
							break;
						case '/':
							zone /= parseFloat(matches[2]);
							break;
					}
				} else { zone = parseFloat(parseFloat(Aligner.vars.size[prop2]));}
			} else if(Aligner.vars.parent) { zone = parseFloat(Aligner.vars.parent[method]());}
			else { zone = (Aligner.defaultParent ? parseFloat(Aligner.defaultParent[method]()) : 0);}
			if(typeof(Aligner.vars.position[prop3]) != 'undefined'){
				if(reg.test(Aligner.vars.position[prop3])) {
					var matches = reg.exec(Aligner.vars.position[prop3]);
					switch(matches[1]) {
						case '+':
							offset += parseFloat(matches[2]);
							break;
						case '-':
							offset -= parseFloat(matches[2]);
							break;
						case '*':
							offset = (Aligner.vars.parent ? parseFloat(Aligner.vars.parent[method]()) : (Aligner.defaultParent ? parseFloat(Aligner.defaultParent[method]()) : 0 )) * parseFloat(matches[2]);
							break;
						case '/':
							offset = (Aligner.vars.parent ? parseFloat(Aligner.vars.parent[method]()) : (Aligner.defaultParent ? parseFloat(Aligner.defaultParent[method]()) : 0 )) / parseFloat(matches[2]);
							break;
					}
				} else { offset = parseFloat(Aligner.vars.position[prop3]); }
			} else {offset = 0; }
			alloc = offset;

			if(Aligner.alignables.length < 2) {
				space = ((zone - parseFloat(Aligner.alignables[0][method]()))/2);
				if(mode_get){
					var tmp = {};
					tmp.element = Aligner.alignables[0].element;
					tmp[prop] = Math.round(space + alloc) + 'px';
					get.push(tmp);
				} else {
					if(!Aligner.blockAlignementForSecurity) { Aligner.alignables[0].element.style[prop] = Math.round(space + alloc) + 'px'; }
					Aligner.alignables[0]['_'+prop3] = Math.round(space + alloc);
					Aligner.update(Aligner.alignables[0]);
				}
				
			} else {
				for(var i = 0; i < Aligner.alignables.length; i++){
					var tmp2 = parseFloat(Aligner.alignables[i][method]());
					total += tmp2;
				}
				space = (zone - total) / (Aligner.alignables.length + 1);
				for(var i = 0; i < Aligner.alignables.length; i++){
					if(mode_get){
						var tmp = {};
						tmp.element = Aligner.alignables[i].element;
						tmp[prop] = Math.round(space + alloc) + 'px';
						get.push(tmp);
					} else {
						if(!Aligner.blockAlignementForSecurity) { Aligner.alignables[i].element.style[prop] = Math.round(space + alloc) + 'px' };
						Aligner.alignables[i]['_'+prop3] = Math.round(space + alloc);
						Aligner.update(Aligner.alignables[i]);
					}
					alloc += space + parseFloat(Aligner.alignables[i][method]());
				}
			}

			if(mode_get){
				Aligner.reset();
				return get;
			}

			return Aligner.reset();
		};

		Aligner.getAlignement = Aligner.get = function() {
			Aligner.getOnly = true;
			return Aligner.align();
		};

		Aligner.reset = function() {
			Aligner.alignables = [];
			
			Aligner.vars = {
				parent : null,
				mode : 0,
				size : {},
				position : {x: 0, y: 0}	
			};

			Aligner.getOnly = false;
			
			return Aligner;
		};

		Aligner.update = function(alignable) {
			var tmp = alignable.constructor == Alignable ? alignable : (typeof(alignable) == 'string' ? new Alignable(alignable) : null);
			var oa = [];
			var exist = Aligner.aligned.filter(function(e) {
				return e.name == tmp.name;
			});
			if(exist.length) {
				oa = Aligner.aligned.map(function(e) {
					return e.name == tmp.name ? tmp : e ;
				});
			} else {
				oa = Aligner.aligned;
				oa.push(tmp);
			}
	
			Aligner.aligned = oa;
		};

		Aligner.getExistant = function(alignable) {
			var tmp = alignable.constructor == Alignable ? alignable : (typeof(alignable) == 'string' ? new Alignable(alignable) : null);
			var exist = Aligner.aligned.filter(function(e) {
				return e.name == tmp.name;
			});
			if(exist.length) {
				exist = exist[0];
				exist._width = tmp._width != undefined ? tmp._width : exist._width;
				exist._height = tmp._height != undefined ? tmp._height : exist._height;
				exist._x = tmp._x != undefined ? tmp._x : exist._x;
				exist._y = tmp._y != undefined ? tmp._y : exist._y;
				return exist;
			} else {
				return tmp;
			}
		};

		Aligner.getAligned = function() {
			return Aligned.aligned;
		}

		__globals.Aligner = Aligner;
/*
 * ----------------------------------------------------------------
 * AlignerStylesheetRules
 * ----------------------------------------------------------------
 */
		var AlignerStylesheetRules = __static('AlignerStylesheetRules');

		AlignerStylesheetRules.formated_css = function(include_size){
			include_size = typeof(include_size) == 'undefined' ? false : include_size;
			var css = Aligner.aligned.map(function(e) {
				var str = e.name.trim() +' {\n';
				str += '\tleft: '+(typeof(e.x()) ==  'number' ?  e.x() + 'px' : (e.x() != 'auto') ? e.x() : '0px' )+';\n';
				str += '\ttop: '+(typeof(e.y()) ==  'number' ?  e.y() + 'px' : (e.y() != 'auto') ? e.y() : '0px' )+(include_size ? ';\n' : '\n');
				if(include_size) {
					str += '\twidth: '+(typeof(e.width()) ==  'number' ?  e.width() + 'px' : (e.width() != 'auto') ? e.width() : 'auto' )+';\n';
					str += '\theight: '+(typeof(e.height()) ==  'number' ?  e.height() + 'px' : (e.height() != 'auto') ? e.height() : 'auto' )+';\n';
				}
				str += '}\n\n';
				return str;
			});

			return css.join('');
		};

		AlignerStylesheetRules.css = function(include_size){
			include_size = typeof(include_size) == 'undefined' ? false : include_size;
			var css = Aligner.aligned.map(function(e) {
				var str = e.name.trim() +' {';
				str += 'left:'+(typeof(e.x()) ==  'number' ?  e.x() + 'px' : (e.x() != 'auto') ? e.x() : '0px' )+';';
				str += 'top:'+(typeof(e.y()) ==  'number' ?  e.y() + 'px' : (e.y() != 'auto') ? e.y() : '0px' )+(include_size ? ';' : '');
				if(include_size) {
					str += 'width:'+(typeof(e.width()) ==  'number' ?  e.width() + 'px' : (e.width() != 'auto') ? e.width() : 'auto' )+';';
					str += 'height:'+(typeof(e.height()) ==  'number' ?  e.height() + 'px' : (e.height() != 'auto') ? e.height() : 'auto' );
				}
				str += '}';
				return str;
			});

			return css.join('');
		};

		AlignerStylesheetRules.formated_scss = function(include_size){
			include_size = typeof(include_size) == 'undefined' ? false : include_size;
			var scss = Aligner.aligned.map(function(e) {
				var str = e.name.trim() +' {\n';
				str += '\t@include position('+(typeof(e.x()) ==  'number' ?  (e.x() == 0 ? '0' : e.x() + 'px') : (e.x() != 'auto') ? e.x() : '0' )+', '+(typeof(e.y()) ==  'number' ?  (e.y() == 0 ? '0' : e.y() + 'px') : (e.y() != 'auto') ? e.y() : '0' )+');\n';
				if(include_size) {
					str += '\t@include size('+(typeof(e.width()) ==  'number' ?  (e.width() == 0 ? '0' : e.width() + 'px') : (e.width() != 'auto') ? e.width() : 'auto' )+', '+(typeof(e.height()) ==  'number' ?  (e.height() == 0 ? '0' : e.height() + 'px') : (e.height() != 'auto') ? e.height() : 'auto' )+');\n';
				}
				str += '}\n\n';
				return str;
			});

			return scss.join('');
		};

		AlignerStylesheetRules.scss = function(include_size){
			include_size = typeof(include_size) == 'undefined' ? false : include_size;
			var scss = Aligner.aligned.map(function(e) {
				var str = e.name.trim() +' {';
				str += '@include position('+(typeof(e.x()) ==  'number' ?  (e.x() == 0 ? '0' : e.x() + 'px') : (e.x() != 'auto') ? e.x() : '0' )+', '+(typeof(e.y()) ==  'number' ?  (e.y() == 0 ? '0' : e.y() + 'px') : (e.y() != 'auto') ? e.y() : '0' )+');';
				if(include_size) {
					str += '@include size('+(typeof(e.width()) ==  'number' ?  (e.width() == 0 ? '0' : e.width() + 'px') : (e.width() != 'auto') ? e.width() : 'auto' )+', '+(typeof(e.height()) ==  'number' ?  (e.height() == 0 ? '0' : e.height() + 'px') : (e.height() != 'auto') ? e.height() : 'auto' )+');';
				}
				str += '}';
				return str;
			});

			return scss.join('');
		};

		__globals.AlignerStylesheetRules = AlignerStylesheetRules;
			
}((typeof(module) !== "undefined" && module.exports && typeof(global) !== "undefined") ? global : this || window, 'Aligner'));