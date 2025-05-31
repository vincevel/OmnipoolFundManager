	
<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name', 'Omnipool') }}</title>

<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="https://unpkg.com/vue3-date-time-picker@latest/dist/main.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<link rel="icon" type="image/png" href={{ asset('image/omnipool_logo.png') }}/>
 

<style type="text/css">
	.logo-box {
		height: 200px;
		 
	}
	.redbox {
		background-color: red;
	}
	.logoimg {
		height: 150px;
	}
	.whitebg {
		//background-color: white;
		 
	}
	
	.iconbox {
		margin-top: 5px;
		margin-left: 5px;
		margin-right: 5px;
	}
	.whiteicon {
		
		color: white;
 
	}

	#ic1:hover {
		opacity: 0.5;
	} 


	  @media only screen and (max-width: 768px) {
	  /* For mobile phones: */
	  	 .icondisplay {
	      width: 10px;
	      border: 2px solid red;
	      display: none;
	      
	    }
	  }
	  .logo-box {
		height: 200px;
		 
	}
	.redbox {
		background-color: red;
	}
	.logoimg {
		height: 150px;
	}
	.whitebg {
		//background-color: white;
		 
	}
	
	.iconbox {
		margin-top: 5px;
		margin-left: 5px;
		margin-right: 5px;
	}
	.whiteicon {
		
		color: white;
 
	}

	#ic1:hover {
		opacity: 0.5;
	} 


	  @media only screen and (max-width: 768px) {
	  /* For mobile phones: */
	  	 .icondisplay {
	      width: 10px;
	      border: 2px solid red;
	      display: none;
	      
	    }
	  }
	  .bg-info, .bg-info>a {
    color: #fff!important;
}
.bg-info {
    background-color: #17a2b8!important;
}
@media (max-width: 767.98px){
    .small-box {
        text-align: center;
    }
    
}

.small-box {
    border-radius: 0.25rem;
    box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
    display: block;
    margin-bottom: 20px;
    position: relative;
}
.bg-success, .bg-success>a {
    color: #fff!important;
}
.bg-warning, .bg-warning>a {
    color: #fff!important;
}

.bg-success {
    background-color: #28a745!important;
}
.small-box .icon > i {
    font-size: 51px;
    position: absolute;
    right: 15px;
    top: 15px;
    transition: -webkit-transform 0.3s linear;
    transition: transform 0.3s linear;
    transition: transform 0.3s linear, -webkit-transform 0.3s linear;
}

.small-box .icon {
    color: rgba(255, 255, 255, 0.71);
    z-index: 0;
}



  

</style>
  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" style="width: 100%;border: 0px solid red">

<nav class="main-header navbar navbar-expand navbar-white navbar-light">

<ul class="navbar-nav">
<li class="nav-item">
<a class="nav-link sidebar-toggle-btn"  data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
</li>
<li class="nav-item d-none d-sm-inline-block">
<a href="#" class="nav-link">Home</a>
</li>
<li class="nav-item d-none d-sm-inline-block">
<!-- <a href="#" class="nav-link">Contact</a>
 -->

                                          
                            
 
</li>
</ul>

<ul class="navbar-nav ml-auto">

<li class="nav-item">
<!-- <a class="nav-link" data-widget="navbar-search" href="#" role="button">
<i class="fas fa-search"></i>
</a> -->
<div class="navbar-search-block">
<form class="form-inline">
<div class="input-group input-group-sm">
<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
<div class="input-group-append">
<button class="btn btn-navbar" type="submit">
<i class="fas fa-search"></i>
</button>
<button class="btn btn-navbar" type="button" data-widget="navbar-search">
<i class="fas fa-times"></i>
</button>


</div>
</div>
</form>


</div>
</li>

<li class="nav-item dropdown">
<a class="nav-link" data-toggle="dropdown" href="#">
<!-- <i class="far fa-comments"></i>
<span class="badge badge-danger navbar-badge">3</span> -->
</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
<a href="#" class="dropdown-item">

<div class="media">
<img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
<div class="media-body">
<h3 class="dropdown-item-title">
Brad Diesel
<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
</h3>
<p class="text-sm">Call me whenever you can...</p>
<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
</div>
</div>

</a>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item">

<div class="media">
<img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
<div class="media-body">
<h3 class="dropdown-item-title">
John Pierce
<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
</h3>
<p class="text-sm">I got your message bro</p>
<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
</div>
</div>

</a>
<div class="dropdown-divider"></div>
 <a href="#" class="dropdown-item">

<div class="media">
<img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
<div class="media-body">
<h3 class="dropdown-item-title">
Nora Silvester
<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
</h3>
<p class="text-sm">The subject goes here</p>
<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
</div>
</div>

</a>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
</div>
</li>

<li class="nav-item dropdown">
<!-- <a class="nav-link" data-toggle="dropdown" href="#">
<i class="far fa-bell"></i>
<span class="badge badge-warning navbar-badge">15</span>
</a> -->
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
<span class="dropdown-header">15 Notifications</span>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item">
<i class="fas fa-envelope mr-2"></i> 4 new messages
<span class="float-right text-muted text-sm">3 mins</span>
</a>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item">
<i class="fas fa-users mr-2"></i> 8 friend requests
<span class="float-right text-muted text-sm">12 hours</span>
</a>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item">
<i class="fas fa-file mr-2"></i> 3 new reports
<span class="float-right text-muted text-sm">2 days</span>
</a>
<div class="dropdown-divider"></div>
<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
</div>
</li>

<div id="showDepositApp">
	<custom-showdeposit></custom-showdeposit>
</div>


<li class="nav-item">
<a class="nav-link" data-widget="fullscreen" href="#" role="button">
<i class="fas fa-expand-arrows-alt"></i>
</a>
</li>

</li>
<li class="nav-item">
  <form id="logout-form" action="{{ route('logout') }}" method="POST"  >    
 <input class="btn btn-danger btn-sm" type="submit" value="Logout">
   {{ csrf_field() }}
 
   </li>                                     </form>
</ul>
</nav>


<aside class="main-sidebar sidebar-dark-primary elevation-4" style="border: 0px solid yellow">

<div class="container icon" >
	<div class="row">
		<div class="col">
		<a href="" class="brand-link logo-switch text-center">
			<div class="customicon">	
				<img id="ic1" src="{{ asset('image/omnipool_logo.png') }}" alt="Logo" class="img-fluid logoimg icon " style="">
				<img id=" " src="{{ asset('image/omnipool_logo2.png') }}" alt="Logo" class="img-fluid logoimg icon " style="opacity: 1; display: none;">
			</div>	
		</a>
	</div>
</div>

<a href="#" class="brand-link text-center">
	<div>
		<span class=" brand-text font-weight-light">{{ config('app.name', 'Omnipool') }}</span>
	</div>	
</a>

<div class="sidebar">

<div class="user-panel mt-3 pb-3 mb-3 d-flex" >
<div class="iconbox ">
	 
	<i class="fa-solid fa-user-tie fa-2xl  whiteicon"></i>
	<!-- <i class="fa-regular fa-user-tie fa-2xl"></i> -->
<!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
</div>
<div class="info">
<a href="#" class="d-block">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
</div>
</div>

<div class="form-inline" >
<!-- <div class="input-group" data-widget="sidebar-search">
<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
<div class="input-group-append">
<button class="btn btn-sidebar">
<i class="fas fa-search fa-fw"></i>
</button>
</div> -->
</div>
</div>

<nav class="mt-2" >
<ul class="nav nav-pills nav-sidebar" data-widget="treeview" role="menu" data-accordion="false" style="border: 0px solid green">

<li class="nav-item menu-open" style="width: 100%;border: " >
<a href="{{ route('home') }}" class="nav-link active" style="">
<i class="nav-icon fas fa-tachometer-alt"></i>
<p id="adminlabel">
	
<span  class="">Admin Dashboard</span>

</p>
<i class="right fas fa-angle-left"></i>
</a>
<!-- <ul class="nav nav-treeview"> -->


<!-- <li class="nav-item"> -->
<!-- <a href="home#" class="nav-link active" style="width: 100%">
<i class="far fa-circle nav-icon"></i>
<p>Current Page</p>
</a> -->
<!-- </li> -->
<!-- <li class="nav-item">
<a href="#" class="nav-link" style="width: 100%">
<i class="far fa-circle nav-icon"></i>
<p>Inactive Page</p>
</a>
</li> -->
<!-- </ul> -->
</li>



<li class="nav-item menu-open" style="width: 100%;border: " >
<a href="{{ route('performance') }}" class="nav-link" style="">
<!-- <i class="nav-icon fa-regular fa-chart-mixed"></i> -->
 <i class="nav-icon fa-solid fa-chart-line"></i>
<p class="">Data Room</p>

 
<!-- <i class="right fas fa-angle-left"></i> -->
</a>
 
</li>


<li class="nav-item menu-open" style="width: 100%;border: " >
<a href="{{ route('order_transactions') }}" class="nav-link" style="">
<!-- <i class="nav-icon fa-regular fa-chart-mixed"></i> -->
 <!-- <i class="nav-icon fa-solid fa-chart-line"></i> -->
 <i class="nav-icon fa-solid fa-table"></i>
<span class="">Order Transactions</span>

 
<!-- <i class="right fas fa-angle-left"></i> -->
</a>
 
</li>
<li class="nav-item menu-open" style="width: 100%;border: " >
	<a href="{{ route('paid_payouts') }}"  class="nav-link" style="">
	<!-- <i class="nav-icon fa-regular fa-chart-mixed"></i> -->
	 <i class="nav-icon fa-solid fa-chart-line"></i>
	<span class="">Paid Payouts</span>
	
	<!-- <i class="right fas fa-angle-left"></i> -->
	</a>
	 
	</li>

<!-- <li class="nav-item">
<a href="#" class="nav-link" >
<i class="nav-icon fas fa-th"></i>
<p>
Simple Link
<span class="ml-3 badge badge-danger">New</span>
</p>
</a>
</li> -->
</ul>
</nav>

</div>

</aside>

<div class="content-wrapper" style=" " >

<div class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
@yield('header1')	
<!-- <h1 class="m-0">Admin Dashboard</h1> -->
</div>
<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Dashboard</li>
</ol>
</div>
</div>
</div>
</div>


<div class="content">
<div class="container-fluid" style=" ">
<div class="row">
<div class="col" style=" ">
<div class="card">
	<div class="card-header">
		
	</div>

<div class="card-body">

<p class="card-text">
 
@yield('searchuser')
</p>
 
</div>
</div>
 

</div>
 

 	@if (Auth::user()->admin == 1)
	 
 
	@endif
</div>
 
</div>

</div>
</div>

</div>




<!-- <aside class="control-sidebar control-sidebar-dark">

<div class="p-3">
<h5>Title</h5>
<p>Sidebar content</p>
</div>
</aside> -->
 


<footer class="main-footer">

<div class="float-right d-none d-sm-inline">
.
</div>
 
<strong>Copyright &copy; {{ date('Y') }} <a href="https://omnipool.co">{{ config('app.name', 'OmniPool') }}</a>.</strong> All rights reserved.
</footer>
</div>

  <script>
  
 
    </script>
 
 
<script src="{{ mix('/js/app.js') }}"></script>

 <script defer >
	
		$('.sidebar-toggle-btn').PushMenu(options)
	
   

 
    </script>

 
</body>
</html>

