<?php
/**
 * Directory Widget Class
 * 
 * This class defines the Common Elements Directory Widget
 * that is registered in the theme integration class.
 *
 * @package Common_Elements_Platform
 * @subpackage Widgets
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Common Elements Directory Widget Class
 * 
 * Implements a directory widget for the Common Elements Platform
 */
class Common_Elements_Directory_Widget extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'common_elements_directory_widget', // Base ID
            __( 'Common Elements Directory', 'common-elements-platform' ), // Name
            array( 
                'description' => __( 'Displays directory information for Common Elements Platform', 'common-elements-platform' ),
                'classname' => 'common-elements-directory-widget',
            ) // Args
        );
    }

    /**
     * Front-end display of widget
     *
     * @param array $args     Widget arguments
     * @param array $instance Saved values from database
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        
        // Widget content
        echo '<div class="common-elements-directory-widget-content">';
        
        // Display directory content
        $this->display_directory_content($instance);
        
        echo '</div>';
        
        echo $args['after_widget'];
    }

    /**
     * Display directory content
     * 
     * @param array $instance Widget instance settings
     */
    private function display_directory_content($instance) {
        $limit = !empty($instance['limit']) ? absint($instance['limit']) : 5;
        $category = !empty($instance['category']) ? $instance['category'] : '';
        
        // Query for directory entries
        $args = array(
            'post_type' => 'directory',
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
        );
        
        // Add category if specified
        if (!empty($category)) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'directory_category',
                    'field' => 'slug',
                    'terms' => $category,
                ),
            );
        }
        
        $entries = new WP_Query($args);
        
        if ($entries->have_posts()) {
            echo '<ul class="directory-list">';
            while ($entries->have_posts()) {
                $entries->the_post();
                echo '<li class="directory-item">';
                echo '<a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a>';
                
                // Get company info if available
                $company = get_post_meta(get_the_ID(), '_directory_company', true);
                if (!empty($company)) {
                    echo '<span class="directory-company">' . esc_html($company) . '</span>';
                }
                
                echo '</li>';
            }
            echo '</ul>';
            
            echo '<p class="view-all-directory"><a href="' . esc_url(home_url('/directory/')) . '">' . __('View Full Directory', 'common-elements-platform') . '</a></p>';
        } else {
            echo '<p>' . __('No directory entries found.', 'common-elements-platform') . '</p>';
        }
        
        wp_reset_postdata();
    }

    /**
     * Back-end widget form
     *
     * @param array $instance Previously saved values from database
     */
    public function form( $instance ) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Directory', 'common-elements-platform');
        $limit = !empty($instance['limit']) ? absint($instance['limit']) : 5;
        $category = !empty($instance['category']) ? $instance['category'] : '';
        
        // Get directory categories
        $categories = get_terms(array(
            'taxonomy' => 'directory_category',
            'hide_empty' => false,
        ));
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'common-elements-platform'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('limit')); ?>"><?php esc_html_e('Number of entries to show:', 'common-elements-platform'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('limit')); ?>" name="<?php echo esc_attr($this->get_field_name('limit')); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($limit); ?>" size="3">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php esc_html_e('Category:', 'common-elements-platform'); ?></label>
            <select id="<?php echo esc_attr($this->get_field_id('category')); ?>" name="<?php echo esc_attr($this->get_field_name('category')); ?>" class="widefat">
                <option value=""><?php esc_html_e('All Categories', 'common-elements-platform'); ?></option>
                <?php foreach ($categories as $cat) : ?>
                    <option value="<?php echo esc_attr($cat->slug); ?>" <?php selected($category, $cat->slug); ?>><?php echo esc_html($cat->name); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved
     *
     * @param array $new_instance Values just sent to be saved
     * @param array $old_instance Previously saved values from database
     *
     * @return array Updated safe values to be saved
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['limit'] = (!empty($new_instance['limit'])) ? absint($new_instance['limit']) : 5;
        $instance['category'] = (!empty($new_instance['category'])) ? sanitize_text_field($new_instance['category']) : '';

        return $instance;
    }
}
