<?php
function fetch_menu($data)
{
	$show = '';
	$active = '';

	$ci =& get_instance();
	$menu1 = "";
	foreach ($data as $menu) {
		$menu_active = $ci->session->userdata('menu_active');
		$sub_menu_active = $ci->session->userdata('sub_menu_active');

		// echo $menu_active.' | '.$menu_slug;die;

		if ($menu_active != '') {
			if ($menu_active == $menu->slug) {
				$active = 'active';
			}else{
				$active = '';
			}
		}

		if ($sub_menu_active != '') {
			if($menu_active == $menu->slug){
				$show = 'show';
			}else{
				$show = '';
			}
		}

		$menu1 .= '<li class="'.$active.'">';

		if (!empty($menu->sub)) {

			$menu1 .= '<a class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false" href="#' . $menu->slug . '"><i class="' . $menu->icon . '"></i><span>' . $menu->name . '</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>';
			$menu1 .= '<ul id="' . $menu->slug . '" class="iq-submenu collapse '.$show.'" data-parent="#iq-sidebar-toggle">';

			$menu1 .= fetch_sub_menu($menu->sub);

			$menu1 .= '</ul>';
		} else {

			$menu1 .= '<a class="iq-waves-effect" href="' . site_url($menu->slug) . '"><i class="' . $menu->icon . '"></i><span>' . $menu->name . '</span></a>';
		}

		$menu1 .= '</li>';
	}
	return $menu1;
}

function fetch_sub_menu($sub_menu)
{
	$sub = "";
	$active = '';
	$ci =& get_instance();
	$sub_menu_active = $ci->session->userdata('sub_menu_active');

	foreach ($sub_menu as $menu) {

		if($sub_menu_active == $menu->slug){
			$active = 'active';
		}else{
			$active = '';
		}

		$sub .= '<li class="'.$active.'">';

		if (!empty($menu->sub)) {
			$sub .= '<ul><li>';
			$sub .= '<a class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false" href="#' . $menu->slug . '"><i class="' . $menu->icon . '"></i><span>' . $menu->name . '</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>';
			$sub .= '<ul id="' . $menu->slug . '" class="iq-submenu iq-submenu-data collapse">';

			$sub .= fetch_sub_menu($menu->sub);

			$sub .= '</ul>';
			$sub .= '</li></ul>';
		} else {
			$sub .=  '<a href="' . site_url($menu->slug) . '"><i class="' . $menu->icon . '"></i><span>' . $menu->name . '</span></a>';
		}

		$sub .= '</li>';
	}

	return $sub;
}

/* End of file menus_helper.php and path \application\helpers\menus_helper.php */
