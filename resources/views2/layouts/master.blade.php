
<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Omnipool</title>

<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

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
		background-color: white;
		width: 40px;
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

</style>
  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<nav class="main-header navbar navbar-expand navbar-white navbar-light">

<ul class="navbar-nav">
<li class="nav-item">
<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
</li>
<li class="nav-item d-none d-sm-inline-block">
<a href="index3.html" class="nav-link">Home</a>
</li>
<li class="nav-item d-none d-sm-inline-block">
<a href="#" class="nav-link">Contact</a>


                                          
                            
 
</li>
</ul>

<ul class="navbar-nav ml-auto">

<li class="nav-item">
<a class="nav-link" data-widget="navbar-search" href="#" role="button">
<i class="fas fa-search"></i>
</a>
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
<i class="far fa-comments"></i>
<span class="badge badge-danger navbar-badge">3</span>
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
<a class="nav-link" data-toggle="dropdown" href="#">
<i class="far fa-bell"></i>
<span class="badge badge-warning navbar-badge">15</span>
</a>
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
<li class="nav-item">
<a class="nav-link" data-widget="fullscreen" href="#" role="button">
<i class="fas fa-expand-arrows-alt"></i>
</a>
</li>
<li class="nav-item">
<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
<i class="fas fa-th-large"></i>
</a>
</li>
<li class="nav-item">
  <form id="logout-form" action="{{ route('logout') }}" method="POST"  >    
 <input class="btn btn-danger btn-sm" type="submit" value="Logout">
   {{ csrf_field() }}
 
   </li>                                     </form>
</ul>
</nav>


<aside class="main-sidebar sidebar-dark-primary elevation-4">

<div class="container icon">
	<div class="row">
		<div class="col">
		<a href="" class="brand-link text-center">
			<div class=" ">	
				<img id="ic1" src="{{ asset('image/omnipool_logo.png') }}" alt="Logo" class="img-fluid logoimg icon" style="">
				<img id=" " src="{{ asset('image/omnipool_logo2.png') }}" alt="Logo" class="img-fluid logoimg icon" style="opacity: 1; display: none;">
			</div>	
		</a>
	</div>
</div>

<a href="index3.html" class="brand-link text-center">
	<div>
		<span class=" brand-text font-weight-light">Omnipool</span>
	</div>	
</a>

<div class="sidebar">

<div class="user-panel mt-3 pb-3 mb-3 d-flex">
<div class="iconbox ">
	 
	<i class="fa-solid fa-user-tie fa-2xl  whiteicon"></i>
	<!-- <i class="fa-regular fa-user-tie fa-2xl"></i> -->
<!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
</div>
<div class="info">
<a href="#" class="d-block">Fname Lname</a>
</div>
</div>

<div class="form-inline">
<div class="input-group" data-widget="sidebar-search">
<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
<div class="input-group-append">
<button class="btn btn-sidebar">
<i class="fas fa-search fa-fw"></i>
</button>
</div>
</div>
</div>

<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

<li class="nav-item menu-open">
<a href="#" class="nav-link active">
<i class="nav-icon fas fa-tachometer-alt"></i>
<p>
Dashboard
<i class="right fas fa-angle-left"></i>
</p>
</a>
<ul class="nav nav-treeview">
<li class="nav-item">
<a href="#" class="nav-link active">
<i class="far fa-circle nav-icon"></i>
<p>Active Page</p>
</a>
</li>
<li class="nav-item">
<a href="#" class="nav-link">
<i class="far fa-circle nav-icon"></i>
<p>Inactive Page</p>
</a>
</li>
</ul>
</li>
<li class="nav-item">
<a href="#" class="nav-link">
<i class="nav-icon fas fa-th"></i>
<p>
Simple Link
<span class="right badge badge-danger">New</span>
</p>
</a>
</li>
</ul>
</nav>

</div>

</aside>

<div class="content-wrapper">

<div class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1 class="m-0">Dashboard</h1>
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
<div class="container-fluid">
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-body">
<h5 class="card-title">View Account</h5>
<p class="card-text">
Some quick example text to build on the card title and make up the bulk of the card's
content.aaa
@yield('searchuser')
</p>
<a href="#" class="card-link">Card link</a>
<a href="#" class="card-link">Another link</a>
</div>
</div>
<div class="card card-primary card-outline">
<div class="card-body">
<h5 class="card-title">Card title1</h5>
<p class="card-text">
Some quick example text to build on the card title and make up the bulk of the card's
content.
</p>
<a href="#" class="card-link">Card link</a>
<a href="#" class="card-link">Another link</a>
</div>
</div>

<div class="card card-primary card-outline">
<div class="card-body">
<h5 class="card-title">Card title2</h5>
<p class="card-text">
@yield('content')
</p>
<a href="#" class="card-link">Card link</a>
<a href="#" class="card-link">Another link</a>
</div>
</div>

</div>

<div class="col-12">
<div class="card">
<div class="card-header">
<h5 class="m-0">Featured1</h5>
</div>
<div class="card-body">
<h6 class="card-title">Special title treatment</h6>
<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
<a href="#" class="btn btn-primary">Go somewhere</a>
</div>
</div>

 
	<div id="uploadapp">
		<div class="card card-primary card-outline">
		<div class="card-header">
		<h5 class="m-0">Upload Transactions</h5>
		</div> <!-- header -->
		<div class="card-body">
		<!-- <h6 class="card-title">Special title treatment</h6> -->
		<!-- <p class="card-text">Upload Transactions Here</p> -->
		<custom-uploadtransactions></custom-uploadtransactions>
		
		</div> <!-- body -->
		</div> <!-- card -->
	</div>
</div>
 
</div>

</div>
</div>

</div>




<aside class="control-sidebar control-sidebar-dark">

<div class="p-3">
<h5>Title</h5>
<p>Sidebar content</p>
</div>
</aside>


<footer class="main-footer">

<div class="float-right d-none d-sm-inline">
Anything you want
</div>

<strong>Copyright &copy; 2014-2021 <a href="https://omnipool.co">Omnipool</a>.</strong> All rights reserved.
</footer>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
	  const Swal = SweetAlert;

	 if (document.querySelector('#uploadapp')) {
     const uploadapp = Vue.createApp({
        delimiters: ['${','}'],
        data() {
         return {
            
         }
        },
    })

    // Define a new global component called button-counter
    uploadapp.component('custom-uploadtransactions', {
      delimiters: ['${','}'],
      created() {
       //initDataTables();              
      },
      props: ['email'],
      methods: {
        loaddata2(event) {
         
          
        },
        loaddata(event) {
          
         
          
        },
        submit_transactions(event) {

        	Swal.fire({
			  title: 'Are you sure?',
			  text: "You won't be able to revert this!",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
			  if (result.isConfirmed) {

			  	axios.post('/submittransactions',{
                transactions: this.ltransactions,
	              }) 
	             .then(results => {

	             	 Swal.fire(
				      'Done!',
				      'Your data has been saved.',
				      'success'
				    )
	             	
	                 console.log(results)
	  
	             })


			   
			  }
			})

           	
        }
      },
      computed: {
        

      },
      data() {
        return {
          count: 0,
          ltransactions: ""
        }
      },
      template: `
  <div>
  	<!-- <h3>Upload Transactions</h3> -->
  	<textarea v-model="ltransactions" style="width:100%"></textarea>
  	<br>
    <a @click="submit_transactions" href="#" class="btn btn-primary">Upload</a> 
  </div>

  `
    })

    uploadapp.mount('#uploadapp');
  
  }   


</script>



<script src="{{ asset('js/app.js') }}"></script>

 
</body>
</html>

