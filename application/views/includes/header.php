<!doctype html>
<html>
<head>
	<title><?=$title?></title>
	<meta charset="utf-8">

	<link rel="icon" href="<?=base_url()?>assets/images/capture.jpg">
	<link rel="shortcut icon" href="images/capture.jpg">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?=base_url()?>assets/css/reservation.css">
	<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> 
	<!-- sweetalert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<!-- animatecss -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>


	<script>
		var base_url = "<?=base_url()?>";
	</script>

	<style>
	
	/*Background main + others*/
	.bgImage{background-image:url("<?=base_url()?>/assets/images/bg.JPG");background-size:cover;background-position:center center ;height:65vh;padding: 0}
	.overlay{background-color:rgba(138, 138, 138, 0.72);height:100%;}
	.underline{border-bottom:1px solid #e7e7e7;}
	.margin-bottom{margin-bottom:0}
	/*navbar*/
	.navbar-brand{margin:0;width:110px;height:105px;}
	.navbar-brand img{width:100%;}
	.logo-mobile{display:none}
	.logo-pc{display:inherit;}
	.nav-collapse{display:flex;justify-content:center}
	.nav-link{margin-left: 10px;margin-right:10px;font-size:1.125em;}
	.txt{font-size:14em;}


	input[type="date"]::-webkit-inner-spin-button {
		opacity: 0
	}
	input[type="date"]::-webkit-calendar-picker-indicator {
		background: url(https://cdn3.iconfinder.com/data/icons/linecons-free-vector-icons-pack/32/calendar-16.png) center/80% no-repeat;
		color: rgba(0, 0, 0, 0);
		opacity: 0.5
	}
	input[type="date"]::-webkit-calendar-picker-indicator:hover {
		background: url(https://cdn3.iconfinder.com/data/icons/linecons-free-vector-icons-pack/32/calendar-16.png) center/80% no-repeat;
		opacity: 0.8
	}
	.form-group{margin:0;}
	.row-checkin{padding:15px 5px;}
	.btn-availability input{font-size:0.9em;font-weight:500;border-radius: 0}
	.color-yellow{background-color: #f1c645 !important}
	.btn-control{width:100%;}
	.container-checkin-main{background-color:#343a40e8 !important}
	.container-checkin{display:flex;justify-content:center;transform:translateY(-50%);z-index: 2;padding: 0}

	.container-about{height:100vh;}
	.container-amenities{height:500px;background-color: #eaeaea!important}
	.img-amenities{height:240px;width:100%;}
	.bg-about{width:100%;height:550px;}
	.bg-about img{min-width:100%;min-height: 100%;max-width: 100%;max-height: 100%}
	.container-footer{height:40vh;padding: 15px;display:flex;justify-content:space-between; align-items: center;}
	.unhide{display:none;}

	.inner{position: relative;display:inline-block;padding: 0}
	.img-background{display:block;}
	.overlays{position: absolute;transition:all .3s ease;opacity: 0;background-color:#eee;}
	.inner:hover .overlays{
		opacity:1;
	}
	.text{color:white;font-family:quicksand,sans-serif;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);}
	.overlaysBottom{height:0;width:100%;bottom:0;left:0;background-color:#00b1ba63}
	.inner:hover .overlaysBottom{
		height:40%;
	}
	.text-paragraph{font-size:0.9em;}
	.bg-down{height:40vh;}
	.bg-reservations{height:90vh;background-image:url("<?=base_url()?>assets/images/swim4.jpg");background-size:cover;background-attachment:fixed}
	.overlay-new{background-color:#35b8ec99;height:90vh;}
	.bg-height{height:60vh;padding:50px}
	.bg-brown{background-color:#7e6547}
	/* For mobile phones: */
	@media (min-width: 992px)
	{
		.input-small{
			max-width: 12.7%;
		}
		.btn-availability{
			max-width:23%;
		}


	}
	@media(max-width: 778px){
		.navbar-nav .nav-item{font-size:0.9em;}
		.navbar-brand{margin:0;width:65px;height:65px;}
		.form-group{margin:1px;}

		.btn-availability{
			max-width:100%;
			width:100%
		}
		.container-about{height:75vh;}
		.img-amenities{height:145px;width:100%;}
		.bg-about {height:450px;}
		.text-small{font-size:1.5em;}
		.text-xs{font-size:1.3em;}
		.inner:hover .overlaysBottom{
			height:55%;
		}
	}
	@media (max-width: 686px) {
		.navbar-nav .nav-item{font-size:0.85em;}
		.navbar-brand{margin:0;width:55px;height:55px;}
		.bg-about{display:none}
		.container-new{height:50vh;padding:20px auto}
		.container-new .margin-top{margin-top:50px;}

	}
	@media (max-width: 668px) {
		/*backgrounnd main +others*/
		.bgImage{background-position:center}
		/*navbar*/
		.navbar-brand{margin:0;width:75px;height:75px;}
		.logo-mobile{display:inherit;}
		.logo-pc{display:none}
		.nav-collapse{display:initial;}
		.nav-link{margin-left:5px;margin-right:5px;font-size:1em;}
		.navbar.navbar-toggler-icon{border-color: white}

		.txt{font-size:3em;}

		.container-checkin{transform:translateY(0%);}
		.container-about-bg{background-image:url("<?=base_url()?>assets/images/room7.jpg");background-size:cover;max-width:100%}
		.text-white{color:#f8f9fa !important;}
		.p-small{font-size:0.9em;}
		.room-cp{display:none;}
		.amenities{padding:0}
		.container-new{height:100%;margin-bottom:25px}
		.hide{display: none}
		.container-amenities{height:100%;}
		.cont-amenities{padding: 0;height:100%;}
		.title{margin:15px;}
		.container-footer{height:100%}
		.unhide{display:initial}
		.container-footer{display:inherit;}
	}
</style>
</head>
<body >