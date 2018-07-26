<?php

// enqueue all themes/scripts, use 15 for the proper order
add_action( 'wp_enqueue_scripts', 'onepress_child_enqueue_styles', 15 );
function onepress_child_enqueue_styles() {
    wp_enqueue_style( 'onepress-child-style', get_stylesheet_directory_uri() . '/style.css' );
}
// hide parent theme templates
function tfc_remove_page_templates( $templates ) {
    unset( $templates['template-left-sidebar.php'] );
    unset( $templates['template-frontpage.php'] );
    unset( $templates['template-fullwidth.php'] );
    return $templates;
}
add_filter( 'theme_page_templates', 'tfc_remove_page_templates' );
/**
 * Creates Hero widget.
 */
class Hero_Widget extends WP_Widget {
  /**
   * Register widget with WordPress.
   */
  function __construct() {
    parent::__construct(
      'hero_widget', // Base ID
      esc_html__( 'Hero Widget', 'text_domain' ), // Name
      array( 'description' => esc_html__( 'Add a hero image', 'text_domain' ), ) // Args
    );
  }
  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {
//    echo $args['before_widget'];
    if ( ! empty( $instance['image'] ) ) {
      echo "<div id='hero_widget' style='background-image : url(\"" . $instance['image'] . "\") ; '>
      
           <div id='hero_text'>
      " ;
      
      if ( ! empty( $instance['title'] ) ) {
        echo "<h3>" . apply_filters( 'widget_title', $instance['title'] ) . "</h3>";
      }
      
      echo "</div></div>" ; 
      
    }
//    echo esc_html__( 'Hello, World!', 'text_domain' );
    echo $args['after_widget'];
  }
  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'My Hero Widget', 'text_domain' );
    $image = ! empty( $instance['image'] ) ? $instance['image'] : esc_html__( 'My Hero Image', 'text_domain' );
    ?>
    <p>
    
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
        <?php esc_attr_e( 'Hero Title:', 'text_domain' ); ?>
    </label> 
    
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    
    </p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>">
        <?php esc_attr_e( 'Image URL:', 'text_domain' ); ?>
    </label> 
    
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="text" value="<?php echo $image; ?>">
    
    </p>
    
    <?php 
  }
  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['image'] = ( ! empty( $new_instance['image'] ) ) ?  : '';
    return $instance;
  }
} // class Foo_Widget
// register Foo_Widget widget
function register_hero_widget() {
    register_widget( 'Hero_Widget' );
}
add_action( 'widgets_init', 'register_hero_widget' );
/* End hero widget */




/* Begin CDS calendar shortcode */


function get_cds_calendar_upcoming_year($xml) {
  
    $html = '';
  
    foreach ($xml->channel->item as $item) {
            
        $pubDate = $item->pubDate ;
        $event_unix_timestamp_utc = strtotime($pubDate); // Convert the pubDate string to a timestamp

        // Set the timezone of the timestamp to UTC, to be sure

        $original_timestamp = date( 'Y-m-d H:i:s', $event_unix_timestamp_utc ) ;
        // $utc = new DateTimeZone('UTC') ;  
        $brownTimeZone = new DateTimeZone('America/New_York');
      
        $datetime = new DateTime($original_timestamp, $brownTimeZone) ;
      
        $html .= '<li>' . $datetime->format('M jS g:i a') . ': <a href="' . $item->link .'">' . $item->title . '</a></li>';
    }

    if ($html != '') {
      $html = '<ul>' . $html . '</ul>';
    }
  
    return $html;
}

function get_cds_calendar_upcoming_week($xml) {
  
    // Data structure for the days of the week

    $weekDB = [[],[],[],[],[],[],[]];

    // Find the dateTimes for the beginning and end of week

    $now = new DateTime();
    $brownTimeZone = new DateTimeZone('America/New_York');

    $lastSunday = (new DateTime)->setTimezone($brownTimeZone)
                                ->setISODate($now->format('Y'), $now->format('W'), 0)
                                ->setTime(0, 0);

    $nextSunday = (new DateTime)->setTimezone($brownTimeZone)
                                ->setISODate($now->format('Y'), $now->format('W') + 1, 0)
                                ->setTime(0, 0);

    // Load the text of the feed into a variable and load into data structure ($weekDB)

    $html = '';

    foreach ($xml->channel->item as $item) {

      // echo "XXXXXXXXXXXXXXX\n" . print_r($item);
      // echo "XXXXXXXXXXXXXXX\n" . print_r($item->children('livewhale', true)->categories);
      
      
      $title = $item->title ;
      $link = $item->link ;

      $pubDate = $item->pubDate ;

      // Convert the pubDate string to a timestamp

      $event_unix_timestamp_utc = strtotime($pubDate) ;

      // Set the timezone of the timestamp to UTC, to be sure

      $original_timestamp = date( 'Y-m-d H:i:s', $event_unix_timestamp_utc ) ;
      // $utc = new DateTimeZone('America/New_York'); 
      // new DateTimeZone('UTC') ;
      $datetime = new DateTime($original_timestamp, $brownTimeZone);

      $weekDB[$datetime->format('w')][] = [
        'title' => (string) $item->title,
        'link' =>  (string) $item->link,
        'category' => (string) $item->children('livewhale', true)->categories,
        // ^^^^ this is how you reference children in a different namespace
        'datetime' => $datetime
      ];
    }

    // Now generate HTML from data structure

    $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 
                 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    for ($weekDay = 0; $weekDay < 7; $weekDay++) {

      $dayRow = '';
      $day = $weekDB[$weekDay];
      $dayCell = "<td>" . $dayNames[$weekDay] . "</td>\n";
      $eventsCell = '';

      if ($day) {

        foreach($day as $event) {
          $eventsCell .= '<li style="list-style-type: none">'
            . "<strong style='text-transform: uppercase; font-size: 70%; color: white; background-color: #900;'>&nbsp;{$event['category']}&nbsp;</strong> <em>" 
            . "<a href='{$event['link']}'>{$event['title']}</a>"
            . "</em> "
            . $event['datetime']->format('g:i a')
            . "</li>\n";
        }

        $eventsCell = "<td>\n" . $eventsCell . "</td>\n";
        $html .= "<tr>\n" . $dayCell . $eventsCell . "</tr>\n";
      }
    }

    if ($html != '') {
      $html = '<table class="table" id="cds-events-table"><tbody>' . $html . '</tbody></table>';
    }
  
    return $html;
}

// Main function for getting the calendar listing

function get_cds_calendar($atts) {
  
  // Get shortcode attributes
  
  $a = shortcode_atts( array(
          'scope' => 'next_7_days',
          'category' => ''
      ), $atts );

  // Right place, right time
  
  date_default_timezone_set('America/New_York');
  
  // Options for scope: current_week, current_semester, current_year, next_7_days, semester_to_end, year_to_end
    
  switch ($a['scope']) {
    case 'next_7_days':
        $startDate = new DateTime();
        $endDate = new DateTime();
        $endDate->modify("+7 day");
        break;
    case 'this_year':
        $startDate = new DateTime();
        $endDate = new DateTime();
        $endDate->modify("+1 year");
        break;
    // TO DO: ADD OTHER SCOPES
  }
  
  // URI of the events feed

  $url = "https://brownlibrary.lwcal.com/live/rss/events/tag/CDS/" 
       . "start_date/" . $startDate->format("mdY") 
       . "/end_date/" . $endDate->format("mdY");
  
  if ($a['category'] != '') {
    $url .= '/category/' . str_replace('+', '%20', urlencode($a['category']));
  }
  
  $ch = curl_init();
  
  print_r('<!-- FEED URL IS ' . $url . ' -->');
  
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_TIMEOUT, 2); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
  $feed = curl_exec($ch);
  
  curl_close($ch);

  if ($feed != '') {

    $xml = simplexml_load_string($feed);

    switch ($a['scope']) {
      case 'next_7_days':
        $html = get_cds_calendar_upcoming_week($xml); break;
      case 'this_year':
        $html = get_cds_calendar_upcoming_year($xml); break;
    }
    
    /* If no events, don't show the title */

    if ($html != '') {
      $html = '<h2>What&#8217;s happening this week</h2>'
        . '<p>All events in the Digital Studio (first floor, Rockefeller Library) unless noted.</p>'
        . $html;
    }

    return $html;
    
  } else {
    return '';
  }
}

/* End CDS calendar shortcode */


/**
 * Register our sidebars and widgetized areas.
 */

function arphabet_widgets_init() {
  register_sidebar( array(
    'name'          => 'Hero Image',
    'id'            => 'hero_image',
    'before_widget' => '<div id="hero_image">',
    'after_widget'  => '</div>',
  ) );
}
add_action( 'widgets_init', 'arphabet_widgets_init' );

add_shortcode('cds_cal', 'get_cds_calendar');


/* Add Google fonts */
function custom_add_google_fonts() {
 wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=IBM+Plex+Sans:200,300,400,500,600|IBM+Plex+Sans+Condensed:400,500', false );
 }
 add_action( 'wp_enqueue_scripts', 'custom_add_google_fonts' );
/* End add Google fonts */

?>