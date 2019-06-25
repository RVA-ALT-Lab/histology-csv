<?php
/**
 * Plugin Name: HISTOLOGY CSV 
 * Plugin URI: https://github.com/woodwardtw/
 * Description: 6 ft 1, dark hair, dark eyes
 * Version: 1.1
 * Author: Tom Woodward
 * Author URI: http://bionicteaching.com
 * License: GPL2
 */
 
 /*   2016 Tom  (email : bionicteaching@gmail.com)
 
 	This program is free software; you can redistribute it and/or modify
 	it under the terms of the GNU General Public License, version 2, as 
 	published by the Free Software Foundation.
 
 	This program is distributed in the hope that it will be useful,
 	but WITHOUT ANY WARRANTY; without even the implied warranty of
 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 	GNU General Public License for more details.
 
 	You should have received a copy of the GNU General Public License
 	along with this program; if not, write to the Free Software
 	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/*
$args = array(
	'sort_order' => 'asc',
	'sort_column' => 'post_title',
	'hierarchical' => 1,
	'exclude' => '',
	'include' => '',
	'meta_key' => '',
	'meta_value' => '',
	'authors' => '',
	'child_of' => 0,
	'parent' => -1,
	'exclude_tree' => '',
	'number' => '',
	'offset' => 0,
	'post_type' => 'page',
	'post_status' => 'publish'
); 
$pages = get_pages($args); 
$num = count($pages);
$i = 0;
while ($i < $num){
	var_dump($pages[$i]->ID);
	var_dump($pages[$i]->post_title);

	$i++;
}

*/

if ( isset($_GET['run_my_script']) ) {
    //add_action('init', 'makePages', 10);
        add_action('init', 'getData', 10);
    add_action('init', 'script_finished', 20);
}
 
 
function script_finished() {
    add_option('my_script_complete', 1);
    die("Script finished.");
}


function makePages($titles){
	$titles = ['foo', 'bar', 'moo'];

	$i = 0;
	while ($i < count($titles)){
			$title = $titles[$i];
			var_dump($title);

			 $my_post = array(
			 		'post_type' => 'page',
	                'post_title' => $title,
	                'post_status' => 'publish',
	                'post_author'   => 1,
					'page_template' => 'page-test-big.php',
					'post_parent' => 159,               
	                );
	                     
	         $the_post = wp_insert_post( $my_post ); 
	         echo $the_post;
	         $i++;   
	     }                        
}

/*

        $my_post = array(
                'post_title' => $title,
                'post_content' => '',
                'post_status' => 'publish',
                'post_author'   => 1,
				'page_template' => 'page-test-big',
				'post_parent' => 159,               
                );
                     
         $the_post_id = wp_insert_post( $my_post ); 


*/

function getParentId($pages, $name){
	$size = sizeof($pages);
	$i = 0;
	while ($i < $size){
		if ($name === $pages[$i]->post_title) {
			echo $pages[$i]->ID . '- '. $pages[$i]->post_title .'<br>';

		} else {
			echo 'make new-' . $pages[$i]->post_title . '<br>';
		}
		$i++;
	}
}        

function getData (){
$pages = get_pages(); 
$name = 'Cells';
getParentId($pages, $name);

$file = fopen("http://192.168.33.10/histology/demo.csv","r");
while(! feof($file))
  {
  $data = fgetcsv($file);
  $parent = $data[0];
  $child = $data[1];
  $childtwo = $data[2];
  $childthree = $data[3];
  $size = sizeof($data);

  echo '<h3>' . $size . '</h3>';

  echo $parent . '- p <br>';
  echo $child . '-c1 <br>';
  echo $childtwo . '-c2 <br>';
  if($childthree) {echo $childthree . '-c3 <br>';}else {echo 'fooooooo<br>';}

  }  
fclose($file);
}