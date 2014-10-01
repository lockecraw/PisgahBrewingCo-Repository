$(document).ready(function(){
	
	$('#theOverlay').toggle(
 		function () {
        	$(this).fadeTo(100,0);
        	console.log('Overlay hidden');
        
     	},
     	function () {
        	$(this).fadeTo(100,0.7);
        
		},
      	function () {
        	$(this).fadeTo(100,1);
        	console.log('Overlay shown');
        	
        
      	})
});