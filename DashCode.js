var DashCode = {
	decode:function(a2,a1,a0){
		return (a2 << 16)+(a1 << 8)+a0;
	},
	toStr:function(img){
		var cv=document.createElement("canvas");
		cv.width=80;
		cv.height=1;
		var c=cv.getContext("2d");
		c.drawImage(img,0,0);
		
		var d=c.getImageData(0,0,80,1);
		d.getPX = function(x, y){
			//From the QR Code reader script
			point = (x * 4) + (y * this.width * 4);
			return {r:this.data[point], g:this.data[point + 1], b:this.data[point + 2]};
		}
		var res=[];
		
		var validation = [
			[255,0,0],
			[255,127,0],
			[255,255,0],
			[0,255,0],
			[0,255,255],
			[0,0,255],
			[127,0,255],
			
			[0,0,255],
			[0,255,255],
			[128,0,0],
			[127,0,255],
			[75,0,130],
			[255,0,0],
			[0,255,0],
			[255,215,0],
			[255,255,0]
		];
		
		for (var i = 0; i < 80; i++) {
			var s=d.getPX(i,0),val=i%5;
			if(val < 2){
				var c = (i-val)/5,v=validation[c];
				if(v[0]!=s.r||v[1]!=s.g||v[2]!=s.b) return false;
			}
			else{
				res.push(DashCode.decode(s.r,s.g,s.b));
			}
		}
		var fin="";
		
		for(var i in res){
			var b=String.fromCharCode(res[i]);
			if(b=="~")break;
			else fin+=b;
		}
		
		return fin;
	}
}