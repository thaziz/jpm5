{{-- @include('layouts._head')
<!DOCTYPE html>
<html>
<head>
<title></title>
<style type="text/css">
	.bg_utama{
		background-color: #fff0f0;
		height: 600px;
	}
	.bg_header{
		background-color: #22436c;
		height: 100px;
		color: white;
	}
	.company{
		font-weight: bold;
		font-family: georgia;
		font-size: 40px;
		color: red;
		/*margin-top: -4%;*/
	}
	.img{
		margin-left: 42%;
	}
	.isi{
		margin-top: 3%;
		/*margin-left: 40%;*/
		margin-bottom: 4%;
		margin: auto;
		border: none;
		background-color: #fff0f0;
		font-size: 15px;
		font-family: calibri;
	}
	.greet{
		margin-top: 5%;
		/*margin-left: 35%;*/
		margin: auto;

		width: 700px;
	}
	.regard{
		margin-top: 3%;
		/*margin-left: 40%;*/
		margin-bottom: 4%;
		margin: auto;
		font-size: 17px;
		font-family: calibri;
	}
	p{
		font-size: 17px;
		font-color:#909090;
	}
	.bg_footer{
		background-color: #22436c;
		height: 40px;
		color: white;

	}
	.foot{
		margin-left: 30%;
		padding-top: 0.5%;
	}
	
</style>
</head>
<body class="bg_utama">
	
	<div class="bg_header">
		<a href="https://brilliantpare.com/en/home/"><img src="https://image.ibb.co/eggFGd/icon.png" alt="icon" border="0" width="95px" style="margin-left: 47%" height="95px" ></a>
	</div>
	
	<div class="greet" >
		<b><p>HELLO!</b></p>
		
		<p>You Receive This Message Cause Someone Registered on https://brilliantpare.com/</p>

	</div>
	

	<table class="isi" width="30%">
		<tr>
			<td width="30%" >Name</td>
			<td width="15%" align="center">:</td>
			<th align="left">{{ $name }}</th>
		</tr>
		<tr>
			<td >Email</td>
			<td align="center">:</td>
			<th align="left" >{{ $email }}</th>
		</tr>
		<tr>
			<td >Password</td>
			<td align="center">:</td>
			<th align="left" >{{ $password }}</th>
		</tr>
		<tr>
			<td >Created at</td>
			<td align="center">:</td>
			<th align="left" >{{ date("d F Y", strtotime($date)) }}</th>
		</tr>
	</table>

	<div class="greet">
		<p><b>Regards,</b></p>
		
		<p>Brilliant Dev</p>

	</div>	

	<div class="bg_footer">	
		<p class="foot"> © Copyright Brilliant Indonesia Group 2018. All right reserved.</p>
	</div>
	
</body>
</html>

	

 --}}



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <style type="text/css">
	body {
		Margin: 0!important;
		padding: 15px;
		background-color: #FFF;
	}
	.wrapper {
		width: 100%;
		table-layout: fixed;
	}
	.wrapper-inner {
		width: 100%;
		background-color: #eee;
		max-width: 670px;
		Margin: 0 auto;
	}
	table {
		border-spacing: 0;
		font-family: sans-serif;
		color: #727f80;
	}
	.outer-table {
		width: 100%;
		max-width: 670px;
		margin: 0 auto;
		background-color: #FFF;
	}
	td {
	    padding: 0;
	}
	.header {
	    background-color: #22436c;
	    border-bottom: 3px solid #81B9C3;
	}
	p {
	    Margin:0;
	}
	.header p {
	    text-align: center;
	    /*padding: 5%;*/
	    font-weight: 500;
	    font-family: georgia;
	    font-size: 11px;
	    text-transform: uppercase;
	}
	a {
	    color: #F1F1F1;
	    text-decoration: none;
	}
	/*--- End Outer Table 1 --*/
	.main-table-first {
		width: 100%;
		max-width: 610px;
		Margin: 0 auto;
		background-color: #e1e1e1;
		border-radius: 6px;
		margin-top: 25px;
	}
	/*--- Start Two Column Sections --*/
	.two-column {
	    text-align: center;
	    font-size: 0;
	    padding: 5px 0 10px 0;
	}
	.two-column .section {
	    width: 100%;
	    max-width: 300px;
	    display: inline-block;
	    vertical-align: top;
	}
	.two-column .content {
	    font-size: 16px;
	    line-height: 20px;
	    text-align: justify;
	}
	.content {
	    width: 100%;
	    padding-top: 20px;
	}
	.center {
	    display: table;
	    Margin: 0 auto;
	}
	img {
	    border: 0;
	}
	img.logo {
	    /*float: left;*/
	    /*Margin-left: 5%;*/
	    max-width: 100px!important;
	}
	#callout {
	    float: right;
	    Margin: 4% 5% 2% 0;
	    height: auto;
	    overflow: hidden;
	}
	#callout img {
	    max-width: 20px;
	}
	.social {
	    list-style-type: none;
	    Margin-top: 1%;
	    padding: 0;
	}
	.social li {
	    display: inline-block;
	}
	.social li img {
	    max-width: 15px;
	    Margin-bottom: 0;
	    padding-bottom: 0;
	}
	/*--- Start Outer Table Banner Image, Text & Button --*/
	.image img {
	    width: 100%;
	    max-width: 670px;
	    height: auto;
	}
	.main-table {
	    width: 100%;
	    max-width: 610px;
	    margin: 0 auto;
	    background-color: #FFF;
	    border-radius: 6px;
	}
	.one-column .inner-td {
	    font-size: 16px;
	    line-height: 20px;
	    text-align: justify;
	}
	.inner-td {
	    padding: 10px;
	}
	.h2 {
	    text-align: center;
	    font-size: 23px;
	    font-weight: 600;
	    line-height: 45px;
	    Margin: 12px;
	    color: #4A4A4A;
	}
	p.center {
	    text-align: center;
	    max-width: 580px;
	    line-height: 24px;
	}
	.button-holder-center {
	    text-align: center;
	    Margin: 5% 2% 3% 0;
	}
	.button-holder {
	    float: right;
	    Margin: 5% 0 3% 0;
	}
	.btn {
	    font-size: 15px;
	    font-weight: 600;
	    background: #81BAC6;
	    color: #FFF;
	    text-decoration: none;
	    padding: 9px 16px;
	    border-radius: 28px;
	}
	/*--- Start Two Column Image & Text Sections --*/
	.two-column img {
	    width: 100%;
	    max-width: 280px;
	    height: auto;
	}
	.two-column .text {
	    padding: 10px 0;
	}
	/*--- Start 3 Column Image & Text Section --*/
	.outer-table-2 {
		width: 100%;
		max-width: 670px;
		margin: 22px auto;
		background-color: #22436c;
	    border-bottom: 3px solid #81B9C3;
	    border-top: 3px solid #81B9C3;
	}
	.three-column {
	    text-align: center;
	    font-size: 0;
	    padding: 10px 0 30px 0;
	}
	.three-column .section {
	    width: 100%;
	    max-width: 200px;
	    display: inline-block;
	    vertical-align: top;
	}
	.three-column .content {
	    font-size: 16px;
	    line-height: 20px;
	}
	.three-column img {
	    width: 100%;
	    max-width: 125px;
	    height: auto;
	}
	.outer-table-2 p {
		margin-top: 6px;
		color: #ffffff;
		font-size: 18px;
		font-weight: 500;
		line-height: 23px;
	}

	/*--- Start Two Column Article Section --*/
	.outer-table-3 {
	    width: 100%;
	    max-width: 670px;
	    margin: 22px auto;
	    background-color: #C2C1C1;
	    border-top: 3px solid #81B9C3;
	}
	.h3 {
		text-align: center;
		font-size: 21px;
		font-weight: 600;
		Margin-bottom: 8px;
		color: #4A4A4A;
	}
	/*--- Start Bottom One Column Section --*/
	.inner-bottom {
		padding: 22px;
	}
	.h1 {
	    text-align: center!important;
	    font-size: 25px!important;
	    font-weight: 600;
	    line-height: 45px;
	    Margin: 12px 0 20px 0;
	    color: #4A4A4A;
	}
	.inner-bottom p {
		font-size: 16px;
		line-height: 24px;
		text-align: justify;
	}
	/*--- Start Footer Section --*/
	.footer {
		width: 100%;
		background-color: #22436c;
		Margin: 0 auto;
	    color: #FFF;
	}
	.footer  img {
		max-width: 135px;
		Margin: 0 auto;
		display: block;
		padding: 4% 0 1% 0;
	}
	p.footer {
		text-align: center;
		color: #FFF!important;
		line-height: 30px;
		padding-bottom: 1%;
	    text-transform: uppercase;
	}
	/*--- Media Queries --*/
	@media screen and (max-width: 400px) {
		.h1 {
			font-size: 22px;
		}
		.two-column .column, .three-column .column {
			max-width: 100%!important;
		}
		.two-column img {
			width: 100%!important;
		}
		.three-column img {
			max-width: 60%!important;
		}
	}
	@media screen and (min-width: 401px) and (max-width: 400px) {

		.two-column .column {
			max-width: 50%!important;
		}
		.three-column .column {
			max-width: 33%!important;
		}
	}
	@media screen and (max-width:768px) {
		img.logo {
			float:none !important;
			margin-left:0% !important;
			max-width: 200px!important;
		}

		#callout {
			float:none !important;
			margin: 0% 0% 0% 0;
			height: auto;
			text-align:center;
			overflow: hidden;
		}
		#callout img {
		    max-width:26px !important; 
		}
		.two-column .section {
			width: 100% !important;
			max-width: 100% !important;
			display: inline-block;
			vertical-align: top;
		}

		.two-column img {
			width: 100% !important;
		 	height: auto !important;
		}
		img.img-responsive {
		    width:100% !important;
		    height:auto !important;
		    max-width:100% !important;
		}
		.content {
			width: 100%;
			padding-top:0px !important;
		}
		
	}
	.data {
			width: 70%;
			margin: auto;
			padding-top:0px !important;
		}
</style>
 </head>
<body>
	<div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <div class="wrapper">
    	<div class="wrapper-inner">
    		<table class="outer-table">
    			<tr>
    				<td class="header">
    					<p><a href="index.html#"><img src="https://image.ibb.co/hU8pgd/icon.png" alt="icon" border="0" class="logo">{{-- BRILLIANT ENGLISH COURSE --}}</a></p>
    				</td>
    			</tr> <!--- End Header -->
            </table> <!--- End Outer Table -->
            <br>
            <table class="main-table">
    			<tr>
    				<td class="one-column">
    					<table width="100%">
    						<tr>
    							<td class="inner-td">
	    							 <p class="h2">MEMBER PROFILE</p>
	    							 <p class="center">Hy, You got this message because you have already became membership of <b>Brilliant English Course</b>. Here your Personal Data <br><b>Do not tell Everyone </b></p>
    							 	  <br>
	    								<table class="data">
    										<tr>
    											<td width="40%">Name</td>
    											<td width="10%">:</td>
    											<td>{{ $name }}</td>

    										</tr>
    										<tr>
    											<td>Email</td>
    											<td>:</td>
    											<td>{{ $email }}</td>
    										</tr>
    										<tr>
    											<td>Password</td>
    											<td>:</td>
    											<td>{{ $password }}</td>
    										</tr>
    										<tr>
    											<td>Sign up Date</td>
    											<td>:</td>
    											<td>{{ date("d F Y", strtotime($date)) }}</td>
    										</tr>
    									</table>
    							 	  <br>
    								<p class="button-holder-center">
    									<a class="btn" href="#">Learn more</a>
    								</p>
    							</td>
    						</tr>
    					</table>
    				</td>
    			</tr> <!--- End Heading, Paragraph & Button Section -->
    			
            </table> <!--- End Main Table -->
            {{-- <table class="outer-table-2">
    			<tr>
    				<td class="text">
    					<p class="center note">Pendaftaran online ke lembaga Brilliant  tidak dipungut biaya alias Gratis.  Tidak ada perbedaan biaya antara kamu mendaftar secara online atau mendaftar dengan datang langsung ke kampung inggris.</p>
    				</td>
    			</tr> <!-End Three Column Section ->
            </table> --}} <!-- End Outer Table 2 -->
      
            <table class="outer-table-3">
    			<tr>
    				<td class="one-column">
    					<table width="100%">
    						<tr>
    							<td class="footer">
    								<p class="footer">Brilliant Indonesia Group 2018. All right reserved.<br>&copy; ESSENSI CREATIVE, 2017.<br></p>
    							</td>
    						</tr>
    					</table>
    				</td>
    			</tr>
    		</table> <!--- End Main Table -->
    	</div> <!--- End Wrapper Inner -->
    </div> <!--- End Wrapper -->
    <br>
</body>
</html>