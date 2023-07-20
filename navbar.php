
<style>
</style>
<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">

				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=inventory" class="nav-item nav-inventory"><span class='icon-field'><i class="fa fa-list"></i></span> Inventory</a>
				<a href="index.php?page=sales" class="nav-item nav-sales"><span class='icon-field'><i class="fa fa-coins"></i></span> Sales</a>
				<a href="index.php?page=receiving" class="nav-item nav-receiving nav-manage_receiving"><span class='icon-field'><i class="fa fa-file-alt"></i></span> Receiving</a>
				<a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-list"></i></span> Medicine Category</a>
				<a href="index.php?page=types" class="nav-item nav-types"><span class='icon-field'><i class="fa fa-th-list"></i></span> Medicine Types</a>
				<a href="index.php?page=product" class="nav-item nav-product"><span class='icon-field'><i class="fa fa-boxes"></i></span> Medicine List</a>
				<a href="index.php?page=expired_product" class="nav-item nav-expired_product"><span class='icon-field'><i class="fa fa-list"></i></span> Expired List</a>
				<a href="index.php?page=supplier" class="nav-item nav-supplier"><span class='icon-field'><i class="fa fa-truck-loading"></i></span> Supplier List</a>
				<a href="index.php?page=customer" class="nav-item nav-customer"><span class='icon-field'><i class="fa fa-user-friends"></i></span> Customer List</a>
				
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
<?php if($_SESSION['login_type'] != 1): ?>
	<style>
		.nav-item{
			display: none!important;
		}
		.nav-sales ,.nav-home ,.nav-inventory{
			display: block!important;
		}
	</style>
<?php endif ?>