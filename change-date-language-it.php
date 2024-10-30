<?php
/*
Plugin Name: Change Date Language (Italian people)
Description: This plugin allows the users who have an Italian version of Wordpress to translate to other languages the Italian dates which appear on their own blog. It is thought for that Italian people who write their own blog in English or other languages but want to have an Italian version of Wordpress. The plugin simply use the preg_replace function to replace the months' and days' names and abbreviations with the names and the abbreviations decided by the users and inserted in the options page of the plugin.
Version: 0.2
Author: Marco Foggia
Author URI: http://marcofoggia.com
 */
 
 /* Add options */
 
 function cdl_it_add_options() {
	add_option('mesi_int');
	add_option('mesi_slug');
	add_option('giorni_int');
	add_option('giorni_slug');
 }
 
 register_activation_hook(__FILE__,'cdl_it_add_options');
 
 /* Register options group */
 
 function cdl_it_register_options_group() {
	register_setting('cdl_it_group','mesi_int');
	register_setting('cdl_it_group','mesi_slug');
	register_setting('cdl_it_group','giorni_int');
	register_setting('cdl_it_group','giorni_slug');
 }
 
 add_action('admin_init','cdl_it_register_options_group');
 
 /* Create options page */
 
 function cdl_it_create_options_form() { ?>
	<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('change-date-language-italian-people/style.css'); ?>"/>
	<div id="wrapper">
		<h2>Change Date Language (Italian people) - Settings</h2>
		<form method="post" action="options.php">
			<?php settings_fields('cdl_it_group'); ?>
			<p>A partire dal mese di <u>Gennaio</u>, scrivere i nomi dei mesi, <u>per intero</u>, con i quali si vuole rimpiazzare i nomi dei mesi in italiano, <u>separandoli con una virgola</u>:</p>
			<p class="es">(es. January,February,March,April,May,June,July,August,September,October,November,December)</p>
			<input type="text" value="<?php echo get_option('mesi_int'); ?>" name="mesi_int" class="options"/>
			<p>A partire dal mese di <u>Gennaio</u>, scrivere i nomi dei mesi, <u>abbreviati</u>, con i quali si vuole rimpiazzare le abbreviazioni dei mesi in italiano, <u>separandoli con una virgola</u>:</p>
			<p class="es">(es. Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec)</p>
			<input type="text" value="<?php echo get_option('mesi_slug'); ?>" name="mesi_slug" class="options"/>
			<p>A partire dal giorno di <u>Luned&igrave</u>, scrivere i nomi dei giorni, <u>per intero</u>, con i quali si vuole rimpiazzare i nomi dei giorni in italiano, <u>separandoli con una virgola</u>:</p>
			<p class="es">(es. Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday)</p>
			<input type="text" value="<?php echo get_option('giorni_int'); ?>" name="giorni_int" class="options"/>
			<p>A partire dal giorno di <u>Luned&igrave</u>, scrivere i nomi dei giorni, <u>abbreviati</u>, con i quali si vuole rimpiazzare le abbreviazioni dei giorni in italiano, <u>separandoli con una virgola</u>:</p>
			<p class="es">(es. Mon,Tue,Wed,Thu,Fri,Sat,Sun)</p>
			<input type="text" value="<?php echo get_option('giorni_slug'); ?>" name="giorni_slug" class="options"/>
			<br/><br/>
			<input type="submit" value="Salva"/>
			<input type="reset" value="Reimposta i valori precedentemente salvati"/>
		</form>
	</div>
<?php
}

function cdl_it_create_options_page() {
	add_options_page('Change Date Language (Italian people)','CDL (IT)','administrator','change-date-language-it','cdl_it_create_options_form');
}

add_action('admin_menu','cdl_it_create_options_page');

/* Change Date Language (Italian people) */

function cdl_translate_the_date($date) {
	$mesi_int_it = array('/gennaio/i','/febbraio/i','/marzo/i','/aprile/i','/maggio/i','/giugno/i','/luglio/i','/agosto/i','/settembre/i','/ottobre/i','/novembre/i','/dicembre/i');
	$mesi_slug_it = array('/gen/i','/feb/i','/mar/i','/apr/i','/mag/i','/giu/i','/lug/i','/ago/i','/set/i','/ott/i','/nov/i','/dic/i');
	$giorni_int_it = array('/lunedì/i','/martedì/i','/mercoledì/i','/giovedì/i','/venerdì/i','/sabato/i','/domenica/i');
	$giorni_slug_it = array('/lun/i','/mar/i','/mer/i','/gio/i','/ven/i','/sab/i','/dom/i');

	if(trim(get_option('mesi_int'))!="") {
		$date = preg_replace($mesi_int_it,explode(",",get_option('mesi_int')),$date);
	}

	if(trim(get_option('mesi_slug'))!="") {
		$date = preg_replace($mesi_slug_it,explode(",",get_option('mesi_slug')),$date);
	}
	if(trim(get_option('giorni_int'))!="") {
		$date = preg_replace($giorni_int_it,explode(",",get_option('giorni_int')),$date);
	}
	if(trim(get_option('giorni_slug'))!="") {
		$date = preg_replace($giorni_slug_it,explode(",",get_option('giorni_slug')),$date);
	}
	
	return $date;
}

/* Filter all the functions that return some dates */

add_filter('get_comment_date','cdl_translate_the_date');
add_filter('get_comment_time','cdl_translate_the_date');
add_filter('get_the_modified_date','cdl_translate_the_date');
add_filter('get_the_modified_time','cdl_translate_the_date');
add_filter('get_the_time','cdl_translate_the_date');
add_filter('the_date','cdl_translate_the_date');
add_filter('the_modified_date','cdl_translate_the_date');
add_filter('the_modified_time','cdl_translate_the_date');
add_filter('the_time','cdl_translate_the_date');
add_filter('the_weekday','cdl_translate_the_date');
add_filter('the_weekday_date','cdl_translate_the_date');

 ?>