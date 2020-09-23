
/* Create Cookie Object*/
function Mycookie(name){
	this.name = name;
	
	this.createCookie = function(value, days){
			this.value = value;
			this.days = days;
			if (this.days ) {
			var date = new Date();
			date.setTime(date.getTime()+(this.days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
			}
			else var expires = "";
			document.cookie = this.name+"="+this.value+expires+"; path=/";
		};
	
	this.readCookie = function(){
			var nameEQ = this.name + "=";
			var ca = document.cookie.split(';');
			for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
			}
			return null;
		};
		
	this.deleteCookie = function(){
		this.createCookie("",-1);
	};
	
}