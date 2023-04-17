<!-- Sidebar  -->
<div class="iq-sidebar">
	<div class="iq-sidebar-logo d-flex justify-content-between">
		<a href="index.html">
			<img src="<?= base_url('assets/images/' . _LOGO_FULL) ?>" class="img-fluid" alt="" />
		</a>
		<div class="iq-menu-bt-sidebar">
			<div class="iq-menu-bt align-self-center">
				<div class="wrapper-menu">
					<div class="main-circle">
						<i class="ri-arrow-left-s-line"></i>
					</div>
					<div class="hover-circle">
						<i class="ri-arrow-right-s-line"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="sidebar-scrollbar">
		<nav class="iq-sidebar-menu">
			<ul id="iq-sidebar-toggle" class="iq-menu">
				<li class="iq-menu-title"><i class="ri-subtract-line"></i><span>Apps</span></li>

				<?= $menus ?>
			</ul>
		</nav>
		<div class="p-3"></div>
	</div>
</div>