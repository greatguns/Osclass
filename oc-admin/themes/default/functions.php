<?php
function printLocaleTabs($locales = null){
	if($locales==null) { $locales = osc_get_locales(); }
    $num_locales = count($locales);
    if($num_locales>1) {
    echo '<div id="language-tab" class="ui-osc-tabs ui-tabs ui-widget ui-widget-content ui-corner-all"><ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">';
	    foreach($locales as $locale) {
	    	echo '<li class="ui-state-default ui-corner-top"><a href="#'.$locale['pk_c_code'].'">'.$locale['s_name'].'</a></li>';
	    }
    echo '</ul></div>';
	};
}
function printLocaleTitle($locales = null){
	if($locales==null) { $locales = osc_get_locales(); }
	if($item==null) { $item = osc_item(); }
    $num_locales = count($locales);
    foreach($locales as $locale) {
    	echo '<div class="input-has-placeholder input-title-wide"><label for="title">' . __('Enter title here') . ' *</label>';
    	$title = (isset($item) && isset($item['locale'][$locale['pk_c_code']]) && isset($item['locale'][$locale['pk_c_code']]['s_title'])) ? $item['locale'][$locale['pk_c_code']]['s_title'] : '' ;
	    if( Session::newInstance()->_getForm('title') != "" ) {
	        $title_ = Session::newInstance()->_getForm('title');
	        if( $title_[$locale['pk_c_code']] != "" ){
	            $title = $title_[$locale['pk_c_code']];
	        }
	    }
	   	$name = 'title'. '[' . $locale['pk_c_code'] . ']';
	    echo '<input id="' . $name . '" type="text" name="' . $name . '" value="' . osc_esc_html(htmlentities($title, ENT_COMPAT, "UTF-8")) . '"  />' ;
	    echo '</div>';
    }
}
function printLocaleDescription($locales = null){
	if($locales==null) { $locales = osc_get_locales(); }
	if($item==null) { $item = osc_item(); }
    $num_locales = count($locales);
    foreach($locales as $locale) {
	   	$name = 'description'. '[' . $locale['pk_c_code'] . ']';

        echo '<div><label for="description">' . __('Description') . ' *</label>';
        $description = (isset($item) && isset($item['locale'][$locale['pk_c_code']]) && isset($item['locale'][$locale['pk_c_code']]['s_description'])) ? $item['locale'][$locale['pk_c_code']]['s_description'] : '';
        if( Session::newInstance()->_getForm('description') != "" ) {
            $description_ = Session::newInstance()->_getForm('description');
            if( $description_[$locale['pk_c_code']] != "" ){
                $description = $description_[$locale['pk_c_code']];
            }
        }
        echo '<textarea id="' . $name . '" name="' . $name . '" rows="10">' . $description . '</textarea></div>' ;
    }
}
function jsLoacaleSelector(){
	$locales = osc_get_locales();
	$codes = array();
    foreach($locales as $locale) {
		$codes[] = '\''.osc_esc_js($locale['pk_c_code']).'\'';
	}
	?>
	<script type="text/javascript">
		var locales = new Object;
		locales.current = '<?php echo osc_esc_js($locales[0]['pk_c_code']); ?>';
		locales.codes = new Array(<?php echo join(',',$codes); ?>);

		locales.string = '[name*="'+locales.codes.join('"],[name*="')+'"]';
		$(function(){
			$('#language-tab li a').click(function(){
				$('#language-tab li').removeClass('ui-state-active').removeClass('ui-tabs-selected');
				$(this).parent().addClass('ui-tabs-selected ui-state-active');
				var currentLocale = $(this).attr('href').replace('#','');
			    $(locales.string).parent().hide();
			    $('[name*="'+currentLocale+'"]').parent().show();
			    locales.current = currentLocale;
			    return false;
			}).triggerHandler('click');
		});
		function tabberAutomatic(){
			$('.tabber:hidden').show();
			$('.tabber h2').remove();
			$(locales.string).parent().hide();
			$('[name*="'+locales.current+'"]').parent().show();
		}
	</script>
	<?php
}
osc_add_hook('admin_header','jsLoacaleSelector');
/*
foreach($locales as $locale) {
    if($num_locales>1) { echo '<h2>' . $locale['s_name'] . '</h2>'; };







    echo '<div><label for="title">' . __('Title') . ' *</label></div>';
    $title = (isset($item) && isset($item['locale'][$locale['pk_c_code']]) && isset($item['locale'][$locale['pk_c_code']]['s_title'])) ? $item['locale'][$locale['pk_c_code']]['s_title'] : '' ;
    if( Session::newInstance()->_getForm('title') != "" ) {
        $title_ = Session::newInstance()->_getForm('title');
        if( $title_[$locale['pk_c_code']] != "" ){
            $title = $title_[$locale['pk_c_code']];
        }
    }
    self::title_input('title', $locale['pk_c_code'], $title);


    echo '<div><label for="description">' . __('Description') . ' *</label></div>';
    $description = (isset($item) && isset($item['locale'][$locale['pk_c_code']]) && isset($item['locale'][$locale['pk_c_code']]['s_description'])) ? $item['locale'][$locale['pk_c_code']]['s_description'] : '';
    if( Session::newInstance()->_getForm('description') != "" ) {
        $description_ = Session::newInstance()->_getForm('description');
        if( $description_[$locale['pk_c_code']] != "" ){
            $description = $description_[$locale['pk_c_code']];
        }
    }
    self::description_textarea('description', $locale['pk_c_code'], $description);
 }*/