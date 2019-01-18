<?php
/**
Plugin Name: Back to top Widget By Arbi
description: Adding Back to top button to your website
Version: 1
Author: Arbizzz
Author URI: http://arbizzz.com
 */
class back_to_top extends WP_Widget {
    function __construct(){
        parent::__construct(
                'back_to_top',
                'Back To Top Widget',
                array(
                    'classname'   => 'back-to-top',
                    'description' => 'Simple Back to top button'
                )
        );
    }
    //Front-end
    public function widget($args, $instance){
        extract($args);
        extract($instance);
  
        echo $before_widget;
        
        $img_url =  plugin_dir_url(__FILE__).'img/up-arrow.png' ;
        ?>
        <a id="back_to_top_btn" class="<?php echo 'bottom_'.$position .' '. $mobile_option;?>" href="#">
            <img src="<?php echo $img_url;?>" alt="top"/>
        </a>
        <script type="text/javascript">
            var $ = jQuery;
            var scroll_size =  '<?php echo $appear_in;?> ';
            var scroll_speed = '<?php echo $scroll_speed;?>';
            $(document).ready(function(){
                $('#back_to_top_btn').click(function () {
                    $("html, body").animate({ scrollTop: 0 }, scroll_speed );
                });
                $(window).scroll(function() {
                    if ($(window).scrollTop() > scroll_size) {
                        $('#back_to_top_btn').addClass('show');
                    }else{
                        $('#back_to_top_btn').removeClass('show');
                    }
                });
            });
        </script>
        <?php echo $after_widget;
    }
    //Admin form
    public function form($instance){
        $instance = wp_parse_args( (array) $instance, array(
                'position' => 'right' ,
                'mobile_option' => 'show_mobile',
                'appear_in' => '600',
                'scroll_speed' => '600'
        ) );
      extract($instance); ?>
        <p>
            Position : <br>
            <label for="<?php echo $this->get_field_id( 'right' ); ?>"><?php esc_attr_e( 'right', 'text_domain' ); ?></label>
            <input class="radio" type="radio" value="right" name="<?php echo $this->get_field_name( 'position' ); ?>" <?php checked( $position, 'right' ); ?> id="<?php echo $this->get_field_id( 'right' ); ?>" />

            <label for="<?php echo $this->get_field_id( 'left' ); ?>"><?php esc_attr_e( 'left', 'text_domain' ); ?></label>
            <input class="radio" type="radio" value="left" name="<?php echo $this->get_field_name( 'position' ); ?>" <?php checked( $position, 'left' ); ?>  id="<?php echo $this->get_field_id( 'left' ); ?>" />
        </p>
        <p>
            Mobile Options : (Under 736px)<br>
            <label for="<?php echo $this->get_field_id( 'show_mobile'); ?>"><?php esc_attr_e( 'show', 'text_domain' ); ?></label>
            <input class="radio" type="radio" value="show_mobile" name="<?php echo $this->get_field_name( 'mobile_option' ); ?>" <?php checked( $mobile_option, 'show_mobile' ); ?> id="<?php echo $this->get_field_id( 'show_mobile' ); ?>" />

            <label for="<?php echo $this->get_field_id( 'hide_mobile' ); ?>"><?php esc_attr_e( 'hide', 'text_domain' ); ?></label>
            <input class="radio" type="radio" value="hide_mobile" name="<?php echo $this->get_field_name( 'mobile_option' ); ?>" <?php checked( $mobile_option, 'hide_mobile' ); ?>  id="<?php echo $this->get_field_id( 'hide_mobile' ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'appear_in' ); ?>">
                Appear When scrolled to:
            </label>
            <input value="<?php echo $instance['appear_in'];?>" class="medium-text" type="number" name="<?php echo $this->get_field_name( 'appear_in'); ?>" id="<?php echo $this->get_field_id( 'appear_in' ); ?>" placeholder="<?php echo $appear_in;?>"/>(px)
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'scroll_speed' ); ?>">
                Set scrolling speed:
            </label>
            <input value="<?php echo $instance['scroll_speed'];?>" class="medium-text" value="<?php echo $this->get_field_name( 'scroll_speed'); ?>" type="number" name="<?php echo $this->get_field_name( 'scroll_speed'); ?>" id="<?php echo $this->get_field_id( 'scroll_speed' ); ?>" placeholder="<?php echo $scroll_speed;?>"/>(ms)
        </p>
<?php }
  //Save Options
  public function update( $new_instance, $old_instance ) {
    extract( $new_instance );
    $instance = array();
    
    $instance['position'] = ( !empty( $position ) ) ? sanitize_text_field( $position ) : null;
    $instance['mobile_option'] = ( !empty( $mobile_option ) ) ? sanitize_text_field( $mobile_option ) : null;
    $instance['appear_in'] = ( !empty( $appear_in ) ) ? sanitize_text_field( $appear_in ) : null;
    $instance['scroll_speed'] = ( !empty( $scroll_speed ) ) ? sanitize_text_field( $scroll_speed ) : null;
    
    return $instance;
  }
}
function back_to_top_register_widget() {
    register_widget( 'back_to_top' );
}
function assets(){
    wp_register_style('back_to_top', plugin_dir_url(__FILE__)  . 'css/back_to_top.css');
    wp_enqueue_style('back_to_top');
    wp_enqueue_script('jquery');
}
add_action( 'widgets_init', 'back_to_top_register_widget');
add_action( 'wp_enqueue_scripts', 'assets' );
?>
