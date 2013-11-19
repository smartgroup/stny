<style type="text/css">
	#center_cndns11 {
		position: absolute;
		float:left;
		background-color:#000000;
	}
	
	#slidemxr_cndns11 {
		position: absolute;
		width: <?php echo $img_width;?>px;
		height: <?php echo $img_height;?>px;		
		overflow: hidden;	
		border: 0px solid #ff0000;
		background-color:#FFFFFF;
	}
	#slidemxr_cndns11 .slidemx {
		position: absolute;
		top: 0px;
		height: <?php echo $img_height;?>px;	
		width: 604px;
		float:left;

		overflow: hidden;
		border-left: #000 solid 1px;
		cursor: default;
	}
	#slidemxr_cndns11 .title   {
		color: #F80;
		font-weight: bold;
		font-size: 1.2em;
		margin-right: 1.5em;
		text-decoration: none;
		
	}
	#slidemxr_cndns11 .backgroundText {
		position: absolute;
		width: 100%;
		height: 100%;
		top: 100%;
		background: #000;
		filter: alpha(opacity=80);
		opacity: 0.8;
	}
	#slidemxr_cndns11 .text {
		position: absolute;
		top: 1%;	
		color: #FFF;
		font-family: verdana, arial, Helvetica, sans-serif;
		font-size: 0.9em;
		text-align: justify;
		width:540px;		
		left: 10px;
	}
	#slidemxr_cndns11 .diapo {
		position: absolute;
		filter: alpha(opacity=100);
		opacity: 1;
		visibility: hidden;
	}

</style>
<?php
if( $img_ordernum>1){
?>
<div style="width:<?php echo $img_width;?>px; height:<?php echo $img_height;?>px; margin:0 auto; text-align:left">
<div id="center_cndns11">
	<div id="slidemxr_cndns11">
		
        	    <?php
		$kkk=1;
		foreach($img_order as $k=>$v){
			$urlhttp="#";
			if($linkaddr[$k]&&$islink[$k]=='yes'){$urlhttp=$linkaddr[$k];}
		?>
	<div class="slidemx">
			<a href="<?php echo $urlhttp;?>" <?php if (isset($img_open_type[$k+1][0])&&$img_open_type[$k+1][0]=='1'){ ?> target="_self" <?php }else{ ?> target="_blank"  <?php } ?>><img class="diapo"  width="<?php echo $img_width;?>" height="<?php echo $img_height;?>" src="<?php echo $img_src[$k]; ?>" alt="<?php echo $sp_title[$k];?>"></a>
			<div class="text">
				  <span class="title"><?php echo $kkk;?></span>
				  <?php echo $sp_title[$k];?> 
			</div>
		</div>
    <?php
		$kkk++;
		}
		?>
		
	
	</div>
</div>
</div>
<script type="text/javascript">
/* ==== slidemxr_cndns11 nameSpace ==== */
var slidemxr_cndns11 = function() {
	/* ==== private methods ==== */
	function getElementsByClass(object, tag, className) {
		var o = object.getElementsByTagName(tag);
		for ( var i = 0, n = o.length, ret = []; i < n; i++) {
			if (o[i].className == className) ret.push(o[i]);
		}
		if (ret.length == 1) ret = ret[0];
		return ret;
	}
	function setOpacity (obj,o) {
		if (obj.filters) obj.filters.alpha.opacity = Math.round(o);
		else obj.style.opacity = o / 100;
	}
	/* ==== slidemxr_cndns11 Constructor ==== */
	function slidemxr_cndns11(oCont, speed, iW, iH, oP) {
		this.slidemxs = [];
		this.over   = false;
		this.S      = this.S0 = speed;
		this.iW     = iW;
		this.iH     = iH;
		this.oP     = oP;
		this.oc     = document.getElementById(oCont);
		this.frm    = getElementsByClass(this.oc, 'div', 'slidemx');
		this.NF     = this.frm.length;
		this.resize();
		for (var i = 0; i < this.NF; i++) {
			this.slidemxs[i] = new Slide(this, i);
		}
		this.oc.parent = this;
		this.view      = this.slidemxs[0];
		this.Z         = this.mx;
		/* ==== on mouse out event ==== */
		this.oc.onmouseout = function () {
			this.parent.mouseout();
			return false;
		}
	}
	slidemxr_cndns11.prototype = {
		/* ==== animation loop ==== */
		run : function () {
			this.Z += this.over ? (this.mn - this.Z) * .5 : (this.mx - this.Z) * .5;
			this.view.calc();
			var i = this.NF;
			while (i--) this.slidemxs[i].move();
		},
		/* ==== resize  ==== */
		resize : function () {
			this.wh = this.oc.clientWidth;
			this.ht = this.oc.clientHeight;
			this.wr = this.wh * this.iW;
			this.r  = this.ht / this.wr;
			this.mx = this.wh / this.NF;
			this.mn = (this.wh * (1 - this.iW)) / (this.NF - 1);
		},
		/* ==== rest  ==== */
		mouseout : function () {
			this.over      = false;
			setOpacity(this.view.img, this.oP);
		}
	}
	/* ==== Slide Constructor ==== */
	Slide = function (parent, N) {
		this.parent = parent;
		this.N      = N;
		this.x0     = this.x1 = N * parent.mx;
		this.v      = 0;
		this.loaded = false;
		this.cpt    = 0;
		this.start  = new Date();
		this.obj    = parent.frm[N];
		this.txt    = getElementsByClass(this.obj, 'div', 'text');
		this.img    = getElementsByClass(this.obj, 'img', 'diapo');
		this.bkg    = document.createElement('div');
		this.bkg.className = 'backgroundText';
		this.obj.insertBefore(this.bkg, this.txt);
		if (N == 0) this.obj.style.borderLeft = 'none';
		this.obj.style.left = Math.floor(this.x0) + 'px';
		setOpacity(this.img, parent.oP);
		/* ==== mouse events ==== */
		this.obj.parent = this;
		this.obj.onmouseover = function() {
			this.parent.over();
			return false;
		}
	}
	Slide.prototype = {
		/* ==== target positions ==== */
		calc : function() {
			var that = this.parent;
			// left slidemxs
			for (var i = 0; i <= this.N; i++) {
				that.slidemxs[i].x1 = i * that.Z;
			}
			// right slidemxs
			for (var i = this.N + 1; i < that.NF; i++) {
				that.slidemxs[i].x1 = that.wh - (that.NF - i) * that.Z;
			}
		},
		/* ==== HTML animation : move slidemxs ==== */
		move : function() {
			var that = this.parent;
			var s = (this.x1 - this.x0) / that.S;
			/* ==== lateral slidemx ==== */
			if (this.N && Math.abs(s) > .5) {
				this.obj.style.left = Math.floor(this.x0 += s) + 'px';
			}
			/* ==== vertical text ==== */
			var v = (this.N < that.NF - 1) ? that.slidemxs[this.N + 1].x0 - this.x0 : that.wh - this.x0;
			if (Math.abs(v - this.v) > .5) {
				this.bkg.style.top = this.txt.style.top = Math.floor(2 + that.ht - (v - that.Z) * that.iH * that.r) + 'px';
				this.v = v;
				this.cpt++;
			} else {
				if (!this.pro) {
					/* ==== adjust speed ==== */
					this.pro = true;
					var tps = new Date() - this.start;
					if(this.cpt > 1) {
						that.S = Math.max(2, (28 / (tps / this.cpt)) * that.S0);
					}
				}
			}
			if (!this.loaded) {
				if (this.img.complete) {
					this.img.style.visibility = 'visible';
					this.loaded = true;
				}
			}
		},
		/* ==== light ==== */
		over : function () {
			this.parent.resize();
			this.parent.over = true;
			setOpacity(this.parent.view.img, this.parent.oP);
			this.parent.view = this;
			this.start = new Date();
			this.cpt = 0;
			this.pro = false;
			this.calc();
			setOpacity(this.img, 100);
		}
	}
	/* ==== public method - script initialization ==== */
	return {
		init : function() {
			// create instances of slidemxr_cndns11s here
			// parameters : HTMLcontainer name, speed (2 fast - 20 slow), Horizontal ratio, vertical text ratio, opacity
			this.s1 = new slidemxr_cndns11("slidemxr_cndns11", 12, 1.84/3, 1/3.2, 90);
			setInterval("slidemxr_cndns11.s1.run();", 16);
		}
	}
}();

</script>
<script type="text/javascript">
/* ==== start script ==== */
slidemxr_cndns11.init();
</script>
<?php
}else{
?>
<div style="width:<?php echo $img_width;?>px; height:<?php echo $img_height;?>px; margin:0 auto; padding:0; text-align:center;background-color:#FFFFFF;">
<div id="center_cndns11" style='position:relative;'>
  <?php
		$kkk=1;
		foreach($img_order as $k=>$v){
			$urlhttp="";
			if($linkaddr[$k]&&$islink[$k]=='yes'){$urlhttp=$linkaddr[$k];}
		if($kkk<2){
		?>
        <img width="<?php echo $img_width;?>" height="<?php echo $img_height;?>" class="diapo" src="<?php echo $img_src[$k]; ?>" alt="<?php echo $sp_title[$k];?>">

    <?php
	}		
		$kkk++;
		}
		?>

</div></div>
<?php
}
?>