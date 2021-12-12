<!DOCTYPE html>
<html>
<head>
<title>SheDoctr</title>
<style>
	body{
	margin:0px;
	padding:0px;
}
#top-logo{
	padding:20px;
}
#top-logo img{
	width:150px;
	height:auto;
}
.half-Colom{
	width:50%;
	height:auto;
	display:block;
	float:left;
}
.textcenter{
	text-align:center;
}
.imageright img{
	width:70%;
	height:auto;
	display:block;
	float:right;
}
.textcenter h2{
	font-family:Arial, Helvetica, sans-serif;
	font-size:42px;
	color:#e47c92;
	font-weight:300;
	padding:0;
	margin:80px 0 0 0;
}
.textcenter p{
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;
	color:#57585b;
	font-weight:100;
	padding:0;
	margin:0;
}

.icon img{
	width:150px;
	height:auto;
	display:inline-block;
}
.icon{
	width:100%;
	height:auto;
	display:inline-block;
	text-align:center;
	margin:40px 0
}
.site-link{
	width:100%;
	height:auto;
	display:inline-block;
	text-align:center;
}
.site-link a{
	width:auto;
	height:50px;
	display:inline-block;
	text-align:center;
	background:#e47c92;
	line-height:50px;
	text-decoration:none;
	
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;
	color:#FFF;
	font-weight:100;
	padding:0 30px;
	margin:0;
	border-radius: 50px 50px 50px 50px;
	-moz-border-radius: 50px 50px 50px 50px;
	-webkit-border-radius: 50px 50px 50px 50px;
	border: 0px solid #000000;
}
</style>
</head>
<body>
<section>
    <div id="top-logo"><img src="https://shedoctr.com/assets/activate-images/logo.png" width="200" height="51" /></div>
    <div class="half-Colom textcenter">
        @if ($status == 'success')
        <h2>congratulations!</h2>
        <p>Your account has been successfully activated</p>
        <div class="icon"><img src="https://shedoctr.com/assets/activate-images/succes-icon.png" width="263" height="262" /></div>
        <div class="site-link"><a href="{{ Config::get('sheDoctr.webapp.url') }}">go to shedoctr.com</a></div>
        @elseif ($status == 'expired')
        <h2>sorry!</h2>
        <p>Activation link expired. We have sent a new link</p>
        @else
        <h2>sorry!</h2>
        <p>Invalid activation link</p>
        @endif
    </div>
    <div class="half-Colom imageright"><img src="https://shedoctr.com/assets/activate-images/activation-page-bg.png" width="1031" height="1202" /> </div>
</section>

</body>
</html>