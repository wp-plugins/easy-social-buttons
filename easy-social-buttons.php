<?php /*
Plugin Name: Easy Social Buttons
Plugin URI: http://esb.neosun.pro/
Description: It is very easy and simple Plugin for showing your social links using a simple widget so that people can connect with you more easily.
Version: 1.2
Author: Kossykh Sergey
Author URI: https://profiles.wordpress.org/psyhonaut/
License: GPLv2 or later
Text Domain: easy-social-buttons
Domain Path: /languages
*/

/* Adds EasySocialButtons widget. */
class EasySocialButtons extends WP_Widget {

	/* Register widget with WordPress. */
	function __construct() {
		load_plugin_textdomain( 'easy-social-buttons', false, 'http://psyhonaut.com/wp-content/plugins/easy-social-buttons/languages/' );
        parent::WP_Widget(
			'EasySocialButtons', 
			$name = 'Easy Social Buttons',
			array( 'description' => __( "Links to your profiles on social networks.", 'easy-social-buttons' ) )
		);	
	}
	
	/* Back-end widget form. */
    function form($instance) {
        $social = array('Facebook','GooglePlus','Instagram','MyWorld','Odnoklassniki','Pinterest','Tumblr','Twitter','VK','YouTube');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Widget Title", 'easy-social-buttons'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo ( $instance ) ? esc_attr($instance['title']) : '' ?>" placeholder="<?php _e("Title of your widget on the site.", 'easy-social-buttons'); ?>"/>
        </p>
		
		<!--Icons in "Metro Light" style-->
		<p>
            <label for="<?php echo $this->get_field_id('color'); ?>"><?php _e("Color of icon", 'easy-social-buttons'); ?></label>
            <input size="6" id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>" type="text" value="<?php echo ( $instance ) ? esc_attr($instance['color']) : '' ?>" value="#333" />
        </p>		
		
        <p><?php _e("<b>Note:</b> Please enter the URL by starting with 'http://' or 'https://' in order to link the social icon properly with your profile.", 'easy-social-buttons'); ?></p>
		
        <?php
        foreach ($social as $social_item)
        {
            ?>
            <p>
                <label for="<?php echo $this->get_field_id($social_item); ?>"><?php _e($social_item, 'easy-social-buttons'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id($social_item); ?>" name="<?php echo $this->get_field_name($social_item); ?>" type="text" value="<?php echo ( $instance ) ? esc_attr($instance[$social_item]) : '' ?>" placeholder=" http://www.example.com" />
            </p>
            <?php
        }
    }

	/* Sanitize widget form values as they are saved. */
    function update($new_instance, $old_instance) {
        $social = array('Facebook','GooglePlus','Instagram','MyWorld','Odnoklassniki','Pinterest','Tumblr','Twitter','VK','YouTube');
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
		$instance['color'] = strip_tags($new_instance['color']);
        foreach ($social as $social_item) {
            $instance[$social_item] = strip_tags($new_instance[$social_item]);
        }
        return $instance;
    }

	/* Front-end display of widget. */	
    function widget($args, $instance)
    {
		/* Proper way to enqueue scripts and styles. */
		wp_enqueue_style( 'easy-social-buttons', plugins_url('/assets/easy-social-buttons.css', __FILE__), array(), '1.0.1' );
	
        extract( $args );
        $social = array('Facebook','GooglePlus','Instagram','MyWorld','Odnoklassniki','Pinterest','Tumblr','Twitter','VK','YouTube');
		$svg = array(
			'<path class="icon" fill="'.$instance["color"].'" d="M1378 1926l0 -699 259 0 38 -300 -297 0 0 -192c0,-87 24,-146 149,-146l159 0 0 -269c-28,-4 -122,-12 -232,-12 -229,0 -386,140 -386,397l0 222 -259 0 0 300 259 0 0 770 5 0c108,-7 210,-32 305,-71z"/>',
			
			'<path class="icon" fill="'.$instance["color"].'" d="M1414 1188l0 -176 -176 0 0 -86 176 0 0 -176 90 0 0 176 176 0 0 86 -176 0 0 176 -90 0zm-654 -792c-46,0 -96,18 -125,53 -30,37 -39,89 -39,134 0,117 70,311 222,311 45,0 93,-25 121,-53 41,-40 44,-92 44,-123 0,-126 -76,-322 -223,-322l0 0zm-100 804c-39,14 -153,56 -153,180 0,124 123,213 313,213 170,0 261,-80 261,-189 0,-89 -59,-136 -194,-230 -14,-2 -23,-2 -40,-2 -16,0 -112,3 -187,28l0 0zm463 -798l-105 0c41,34 122,98 122,231 0,129 -75,191 -149,248 -23,23 -50,48 -50,86 0,39 27,60 46,75l64 49c78,65 149,124 149,245 0,165 -167,332 -472,332 -257,0 -377,-122 -377,-251 0,-63 32,-153 137,-214 110,-66 259,-75 339,-80 -25,-32 -53,-65 -53,-119 0,-30 9,-47 18,-68 -20,1 -39,3 -57,3 -188,0 -295,-138 -295,-275 0,-80 25,-175 102,-240 101,-82 230,-92 326,-92l370 0 -115 70z"/>',			
			
			'<path class="icon" fill="'.$instance["color"].'" d="M1532 1398c0,81 -50,133 -130,133 -268,1 -536,1 -804,0 -79,0 -129,-51 -130,-131 0,-267 0,-534 0,-801 1,-81 53,-131 135,-131 132,0 264,0 396,0 133,0 266,0 399,0 82,0 134,51 134,132 0,266 0,532 0,798zm-508 -71c-92,6 -174,-21 -242,-83 -95,-87 -125,-197 -102,-323 -30,0 -57,0 -85,0 -1,7 -2,12 -2,16 0,140 0,280 0,420 0,36 15,49 52,49 237,0 473,0 710,0 40,0 51,-13 51,-55 0,-134 0,-268 0,-402 0,-9 0,-19 0,-28 -31,0 -57,0 -86,0 44,233 -122,394 -296,406zm-24 -125c113,0 203,-91 202,-204 -1,-112 -92,-202 -204,-201 -110,1 -200,91 -200,202 0,113 90,203 202,203zm248 -408c18,0 37,0 56,0 19,0 39,0 59,0 27,0 42,-15 43,-42 1,-39 1,-78 0,-117 -1,-26 -15,-41 -41,-41 -39,0 -78,0 -118,0 -25,0 -40,13 -41,40 0,40 0,80 0,120 1,27 16,39 42,40z"/>
			',
			
			'<path class="icon" fill="'.$instance["color"].'" d="M1513 1348c-23,-1 -41,-12 -53,-32 -15,-26 -30,-52 -45,-77 -1,-3 -3,-5 -4,-8 -18,16 -34,31 -52,45 -65,52 -140,84 -222,102 -48,10 -98,15 -148,14 -108,-3 -211,-27 -304,-85 -30,-18 -58,-40 -83,-65 -3,-4 -6,-8 -11,-13 -2,4 -4,7 -5,9 -16,27 -31,53 -47,79 -13,22 -34,33 -59,31 -25,-2 -44,-15 -54,-38 -9,-21 -7,-41 5,-61 32,-55 64,-109 96,-164 11,-19 22,-38 33,-57 14,-23 40,-35 65,-31 27,4 47,23 53,50 4,17 1,33 -8,48 -10,17 -10,17 2,32 35,45 81,76 133,98 47,20 96,32 147,36 84,8 166,-3 243,-36 56,-24 104,-57 140,-106 5,-7 6,-11 1,-18 -12,-18 -17,-38 -10,-59 8,-26 26,-41 52,-45 28,-4 50,7 64,31 29,49 57,99 86,149 14,25 30,51 44,77 24,44 -9,96 -59,94zm-731 -740c56,0 102,48 101,105 0,58 -46,104 -104,104 -59,-1 -105,-47 -104,-107 0,-57 48,-102 107,-102zm442 0c57,0 104,47 104,104 0,58 -47,104 -104,105 -59,0 -105,-47 -105,-105 0,-58 47,-104 105,-104z"/>',
			
			'<path class="icon" fill="'.$instance["color"].'" d="M996 805c193,-2 191,-310 -16,-295 -196,14 -182,298 16,295zm370 853c-71,72 -146,5 -201,-48 -48,-45 -104,-102 -154,-141 -129,136 -234,300 -340,209 -128,-108 122,-268 183,-361 -63,-15 -170,-49 -221,-87 -50,-39 -59,-127 2,-171 73,-52 122,6 208,33 327,106 453,-189 550,-16 82,147 -198,212 -232,235 135,129 308,243 205,347zm-736 -1062c33,-217 243,-326 421,-295 209,35 323,228 298,406 -68,480 -792,368 -719,-111z"/>',		

			'<path class="icon" fill="'.$instance["color"].'" d="M1033 296c-384,0 -578,275 -578,505 0,139 52,263 165,309 19,8 36,1 41,-20 4,-14 13,-50 16,-65 6,-20 4,-27 -11,-45 -33,-38 -54,-88 -54,-159 0,-204 153,-387 399,-387 217,0 336,132 336,310 0,233 -103,430 -256,430 -85,0 -148,-70 -128,-156 25,-102 72,-213 72,-287 0,-66 -36,-121 -109,-121 -87,0 -157,89 -157,209 0,76 26,128 26,128 0,0 -88,375 -104,441 -31,131 -4,291 -2,307 1,10 13,12 19,5 8,-10 111,-138 146,-265 10,-36 57,-222 57,-222 28,54 110,101 198,101 260,0 436,-237 436,-555 0,-240 -203,-463 -512,-463z"/>',					
			
			'<path class="icon" fill="'.$instance["color"].'" d="M1315 1334c-23,11 -68,21 -101,22 -100,2 -119,-71 -120,-123l0 -389 251 0 0 -189 -250 0 0 -317c0,0 -180,0 -183,0 -3,0 -8,2 -8,9 -11,97 -57,268 -246,336l0 161 126 0 0 408c0,139 103,338 375,333 92,-2 193,-40 216,-73l-60 -178z"/>',
			
			'<path class="icon" fill="'.$instance["color"].'" d="M748 1552c-158,0 -304,-46 -428,-125 22,3 44,4 67,4 131,0 251,-45 346,-119 -122,-3 -225,-83 -260,-194 17,3 34,5 52,5 26,0 50,-4 74,-10 -128,-26 -224,-138 -224,-273 0,-2 0,-3 0,-4 38,21 81,34 126,35 -75,-50 -124,-135 -124,-232 0,-51 14,-99 38,-140 138,168 343,279 575,291 -5,-20 -7,-42 -7,-63 0,-154 124,-279 278,-279 81,0 153,34 204,88 64,-13 123,-36 177,-68 -21,65 -65,120 -123,154 57,-6 111,-21 161,-44 -38,56 -85,105 -140,145 1,12 1,24 1,36 0,368 -280,793 -793,793z"/>',
			
			'<path class="icon" fill="'.$instance["color"].'" d="M983 1399l82 0c0,0 24,-3 37,-16 12,-13 11,-36 11,-36 0,0 -1,-110 50,-126 50,-16 114,106 182,153 52,35 91,28 91,28l182 -3c0,0 95,-6 50,-81 -3,-6 -26,-55 -135,-157 -115,-106 -99,-89 38,-272 84,-112 118,-180 107,-209 -10,-28 -71,-21 -71,-21l-206 1c0,0 -15,-2 -26,5 -11,7 -18,22 -18,22 0,0 -33,87 -76,160 -91,155 -128,164 -143,154 -35,-23 -26,-90 -26,-138 0,-151 23,-214 -44,-230 -23,-5 -39,-9 -96,-9 -73,-1 -135,0 -171,17 -23,12 -41,37 -30,38 14,2 44,9 61,31 21,29 20,93 20,93 0,0 12,177 -28,199 -28,15 -66,-16 -147,-157 -42,-72 -74,-152 -74,-152 0,0 -6,-14 -17,-22 -13,-10 -31,-13 -31,-13l-195 1c0,0 -29,1 -40,14 -10,11 -1,34 -1,34 0,0 153,358 326,538 158,165 338,154 338,154l0 0z"/>',
			
			'<path class="icon" fill="'.$instance["color"].'" d="M1648 1298c-11,69 -67,130 -134,142 -23,5 -48,5 -73,6 -196,12 -392,22 -589,14 -117,-5 -233,-12 -350,-19 -72,-4 -138,-66 -150,-142 -19,-126 -26,-252 -22,-380 2,-86 9,-171 22,-256 12,-76 75,-134 151,-138 164,-8 329,-15 487,-22 147,6 287,12 427,18 33,1 67,2 100,7 71,13 123,71 133,146 15,114 23,228 21,343 -2,94 -9,188 -23,281zm-828 -131c121,-65 239,-128 360,-193 -121,-65 -240,-129 -360,-193 0,129 0,257 0,386z"/>'			
			);

        // these are the widget options
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;

        // Display the widget
		echo '<div id="easy-social-buttons">';

        // Check if title is set
        if ( $title )
        {
            echo $before_title . $title . $after_title;
        }

        foreach ($social as $key => $social_item)
        {
            // Check if $instance is set for each social item and
            // if it is set then only show on front-end
            if( $instance[$social_item]){
                echo '
					<a class="href" href="'.$instance[$social_item].'" target="_blank" title="Follow me '.$social_item.'">
						<svg class="'.$social_item.'" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="33px" height="33px" xml:space="preserve" viewBox="0 0 2000 2000">
							<circle class="background" stroke="'.$instance["color"].'" stroke-width="99" fill="transparent" cx="1000" cy="1000" r="950" />'
							.$svg[$key].
						'</svg>
					</a>';
            }
        }
		echo '</div>';
		
        echo $after_widget;
    }
}

function EasySocialButtons_register_widgets() {
	register_widget( 'EasySocialButtons' );
}

add_action( 'widgets_init', 'EasySocialButtons_register_widgets' );
?>