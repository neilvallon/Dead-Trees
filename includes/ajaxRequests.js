function signUp(){
	$.post("includes/post.php", { action: "signUp", email: $('#email').val(), pass: $('#pass').val() }, 
		function(data){
			$('#status').html(data);
		});
}
function login(){
	$.post("includes/post.php", { action: "login", email: $('#email').val(), pass: $('#pass').val(), rem: $('#rem').is(':checked')?1:0}, 
		function(data){
			$('#status').html(data);
		});
}
function logout(){
	$.post("includes/post.php", { action: "logout", email: $('#email').val(), pass: $('#pass').val() }, 
		function(data){
			$('#status').html(data);
		});
}