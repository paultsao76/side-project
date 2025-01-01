// JavaScript Document


		var cvs,ctx;
		window.onload=function(){
			cvs=document.getElementById('cvs');
			ctx=cvs.getContext('2d');
		};
	
		function loadFile(input){
			var file=input.files[0];
			var src=URL.createObjectURL(file);
			var img=new Image();	
			img.src=src;
			img.onload=function(){
				ctx.drawImage(this,0,0,cvs.width,cvs.height);
			};
		}