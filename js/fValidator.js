/* ************************************************************************************* *\
 * The MIT License
 * Copyright (c) 2007 Fabio Zendhi Nagao - http://zend.lojcomm.com.br
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this
 * software and associated documentation files (the "Software"), to deal in the Software
 * without restriction, including without limitation the rights to use, copy, modify,
 * merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following
 * conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * 
\* ************************************************************************************* */

var fValidator = new Class({
	options: {
		msgContainerTag: "div",
		msgClass: "fValidator-msg",

		styleNeutral: {"background-color": "#FFF", "border-color": "#8E3B1B"},
		styleInvalid: {"background-color": "#FFF4F4", "border-color": "#8E3B1B"},
		styleValid: {"background-color": "#FFFFFF", "border-color": "#8E3B1B"},

		required: {type: "required", re: /[^.*]/, msg: "Este Campo es requerido."},
		filarequired: {type: "required", re: /[^.*]/, msg: "Complete todos los campos."},
		required1: {type: "required", re: /[^.*]/, msg: "Por favor, seleccione un item del listado"},
		maxlength: {type: "maxlength", msg: "M�ximo 150 palabras."},
		minlength: {type: "minlength", msg: "Pocas palabras."},
		alpha: {type: "alpha", re: /^[a-z ._-]+$/i, msg: "Por favor, ingrese s\xF3lo caracteres num\xE9ricos."},
		alphanum: {type: "alphanum", re: /^[a-z0-9 ._-]+$/i, msg: "Por favor, ingrese s\xF3lo caracteres alfanum\xE9ricos."},
		integer: {type: "integer", re: /^([-+]?\d+)?$/, msg: "Por favor, ingresar un n\xFAmero entero v\xE1lido."},
		real: {type: "real", re: /^([-+]?\d*\.?\d+)?$/, msg: "Por favor, ingresar un n\xFAmero."},
                montomax: {type: "montomax", re: /^([-+]?\d*\.?\d+)?$/, msg: "El monto m\xE1ximo es de $5000."},
		date: {type: "date", re:/^((0[1-9]|[12][0-9]|3[01])[/.](0[1-9]|1[012])[/.](19|20)\d\d)?$/, msg: "Por favor ingrese una fecha v\xE1lida (dd/mm/yyyy)."},
		daterango: {type: "daterango", msg: "Fuera del rango."},
		email: {type: "email", re: /^[a-z0-9._%-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i, msg: "Por favor, ingrese un mail v\xE1lido."},
		phone: {type: "phone", re: /^[\d\s ().-]+$/, msg: "Por favor, ingrese un tel\xE9fono v\xE1lido."},
		url: {type: "url", re: /^(http|https|ftp)\:\/\/[a-z0-9\-\.]+\.[a-z]{2,3}(:[a-z0-9]*)?\/?([a-z0-9\-\._\?\,\'\/\\\+&amp;%\$#\=~])*$/i, msg: "Por favor, ingrese una url v\xE1lida."},
		confirm: {type: "confirm", msg: "Las contrase\xF1as ingresadas no coinciden."},

		onValid: Class.empty,
		onInvalid: Class.empty
	},

	initialize: function(form, options) {
		this.form = $(form);
		this.setOptions(options);

		this.fields = this.form.getElements("*[class^=fValidate]");
		this.validations = [];

		this.fields.each(function(element) {
		    //LULY: Esto ->&&(this.options.styleInvalid == false) lo agregue yo
			if(!this._isChildType(element)&&(this.options.styleInvalid == false)){ 
				element.setStyles(this.options.styleNeutral);
			}
			element.cbErr = 0;
			//LULY->el siguiente if lo agregue yo
			if(this.options.styleInvalid == true){
				element.cbErr = 1;
			}
			
			var classes = element.getProperty("class").split(' ');
			classes.each(function(klass) {
				if(klass.match(/^fValidate(\[.+\])$/)) {
					var aFilters = eval(klass.match(/^fValidate(\[.+\])$/)[1]);
					for(var i = 0; i < aFilters.length; i++) {
						if(this.options[aFilters[i]]) this.register(element, this.options[aFilters[i]]);
						if(aFilters[i].charAt(0) == '=') this.register(element, $extend(this.options.confirm, {idField: aFilters[i].substr(1)}));
					}
				}
			}.bind(this));
		}.bind(this));

		this.form.addEvents({
			"submit": this._onSubmit.bind(this),
			"reset": this._onReset.bind(this)
		});
	},

	register: function(field, options) {
		field = $(field);
		this.validations.push([field, options]);
		field.addEvent("blur", function() {
			this._validate(field, options);
		}.bind(this));
	},

	//Este metodo verifica si el elemento es un radio o un check
	_isChildType: function(el) {
		var elType = el.type.toLowerCase();
		if((elType == "radio") || (elType == "checkbox")) return true;
		return false;
	},

	_validate: function(field, options) {
		switch(options.type) {
			case "confirm":
				if($(options.idField).getValue() == field.getValue()) this._msgRemove(field, options);
				else this._msgInject(field, options);
				break;
			case "maxlength":
				/*var primerBlanco = /^ /
				var ultimoBlanco = / $/
				var variosBlancos = /[ ]+/g
				var text = field.getValue();
				texto = texto.replace(variosBlancos," ");
				texto = texto.replace(primerBlanco,"");
				texto = texto.replace(ultimoBlanco,"");
				results =texto.split(" ");*/
				results =field.getValue().split(" ");
				if(results.length>150) this._msgInject(field, options);
				else this._msgRemove(field, options);
				break;
			case "minlength":
				results =field.getValue().split(" ");
				if(results.length<300) this._msgInject(field, options);
				else this._msgRemove(field, options);
				break;
			case "daterango":
				var dt_ini = document.getElementById('dt_ini');
				var dt_fin = document.getElementById('dt_fin');
				var fechaArray = field.getValue().split("/");
				var iniArray = dt_ini.value.split("/");
				var finArray = dt_fin.value.split("/");
				var fecha = fechaArray[2]+fechaArray[1]+fechaArray[0];
				var ini = iniArray[2]+iniArray[1]+iniArray[0];
				var fin = finArray[2]+finArray[1]+finArray[0];
				
				if((fecha!='NaN')&&((fecha<ini)||(fecha>fin))) this._msgInject(field, options);
				else this._msgRemove(field, options);
				break;
                        case "montomax":
				if(field.getValue()>5000) this._msgInject(field, options);
				else this._msgRemove(field, options);
				break;
			default:
				if(options.re.test(field.getValue()))
				{
					this._msgRemove(field, options);
				}
				else
				{
				    this._msgInject(field, options);
				}
		}
	},

	_validateChild: function(child, options) {
		var nlButtonGroup = this.form[child.getProperty("name")];
		var cbCheckeds = 0;
		var isValid = true;
 		for(var i = 0; i < nlButtonGroup.length; i++) {
			if(nlButtonGroup[i].checked) {
				cbCheckeds++;
				if(!options.re.test(nlButtonGroup[i].getValue())) {
					isValid = false;
					break;
				}
			}
		}
		if(cbCheckeds == 0 && options.type == "required") isValid = false;
		if(isValid) this._msgRemove(child, options);
		else this._msgInject(child, options);
	},

	_msgInject: function(owner, options) {
		if(!$(owner.getProperty("id") + options.type +"_msg")) {
			var msgContainer = new Element(this.options.msgContainerTag, {"id": owner.getProperty("id") + options.type +"_msg", "class": this.options.msgClass})
				.setHTML(options.msg)
				.setStyle("opacity", 0)
				.injectAfter(owner)
				.effect("opacity", {
					duration: 500,
					transition: Fx.Transitions.linear
				}).start(0, 1);
			owner.cbErr++;
			this._chkStatus(owner, options);
		}
	},

	_msgRemove: function(owner, options, isReset) {
		isReset = isReset || false;
		if($(owner.getProperty("id") + options.type +"_msg")) {
			var el = $(owner.getProperty("id") + options.type +"_msg");
			el.effect("opacity", {
				duration: 500,
				transition: Fx.Transitions.linear,
				onComplete: function() {el.remove()}
			}).start(1, 0);
			if(!isReset) {
				owner.cbErr--;
				this._chkStatus(owner, options);
			}
		}
	},

	_chkStatus: function(field, options) {
		//LULY: Cambie if(field.cbErr == 0) por if(field.cbErr <= 0)
		if(field.cbErr < 0) {
			//LULY: Esta linea la agregue yo
			field.cbErr = 0;
			field.effects({duration: 500, transition: Fx.Transitions.linear}).start(this.options.styleValid);
			this.fireEvent("onValid", [field, options], 50);
		} else {
			field.effects({duration: 500, transition: Fx.Transitions.linear}).start(this.options.styleInvalid);
			this.fireEvent("onInvalid", [field, options], 50);
		}
	},

	_onSubmit: function(event) {
		event = new Event(event);
		var isValid = true;

		//validation es un array de array (field, option)
		this.validations.each(function(array) {
			if(this._isChildType(array[0])){ 
				this._validateChild(array[0], array[1]);
			}
			else {
				this._validate(array[0], array[1]);
			}
			if(array[0].cbErr > 0) isValid = false;
		}.bind(this));

		if(!isValid) event.stop();
		return isValid;
	},

	_onReset: function() {
		this.validations.each(function(array) {
			if(!this._isChildType(array[0])) array[0].setStyles(this.options.styleNeutral);
			array[0].cbErr = 0;
			this._msgRemove(array[0], array[1], true);
		}.bind(this));
	}
});
fValidator.implement(new Events); // Implements addEvent(type, fn), fireEvent(type, [args], delay) and removeEvent(type, fn)
fValidator.implement(new Options);// Implements setOptions(defaults, options)