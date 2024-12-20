<?php
function codenimo_enqueue_styles() {
    // Get the path to the CSS file
    $css_file = get_template_directory() . '/css/general.css';
    $header_css_file = get_template_directory() . '/css/header.css';
    $footer_css_file = get_template_directory() . '/css/footer.css';
    $sidebar = get_template_directory() . '/css/sidebar.css';

    // Get the last modified time of the file
    $version = filemtime($css_file);
    $hversion = filemtime($header_css_file);
    $fversion = filemtime($footer_css_file);
    $sversion = filemtime($footer_css_file);
    
    // Enqueue the CSS file
    wp_enqueue_style('my-theme-style', get_template_directory_uri() . '/css/general.css', array(), $version);
    wp_enqueue_style('my-header-style', get_template_directory_uri() . '/css/header.css', array(), $version);
    wp_enqueue_style('my-footer-style', get_template_directory_uri() . '/css/footer.css', array(), $version);
    wp_enqueue_style('my-sidebar-style', get_template_directory_uri() . '/css/sidebar.css', array(), $sversion);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), null);
    
    if (is_page_template('template-edit-profile.php')) {
        $edit_profile_css_file = get_template_directory() . '/css/template-edit-profile.css';
        $edit_profile_version = filemtime($homepage_css_file);
        wp_enqueue_style('my-edit-profile-style', get_template_directory_uri() . '/css/template-edit-profile.css', array(), $edit_profile_version);
    }
    if (is_front_page()) {
        // Get the path to the homepage-specific CSS file
        $homepage_css_file = get_template_directory() . '/css/homepage.css';
        
        // Get the last modified time of the homepage CSS file
        $homepage_version = filemtime($homepage_css_file);
        
        // Enqueue the homepage-specific CSS file
        wp_enqueue_style('homepage-style', get_template_directory_uri() . '/css/homepage.css', array(), $homepage_version);
    }
}

add_action('wp_enqueue_scripts', 'codenimo_enqueue_styles');



function codenimo_enqueue_scripts() {
    if (is_page_template('template-edit-profile.php')) {
    // Get the path to the JavaScript file
    $js_file = get_template_directory() . '/js/custom-script.js';

    // Get the last modified time of the file
    $version = filemtime($js_file);

    // Enqueue the JavaScript file
    wp_enqueue_script('my-theme-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery'), $version, true);
    }
    if (is_front_page()) {
        $calendar_js_file = get_template_directory() . '/js/calendar.js';
        $attendance_js_file = get_template_directory() . '/js/calendar.js';

        $calendar_version = filemtime($calendar_js_file);
        $attendance_version = filemtime($attendance_js_file);
        wp_enqueue_script('my-calendar-script', get_template_directory_uri() . '/js/calendar.js', array('jquery'), $calendar_version, true);    
        wp_enqueue_script('attendance-script', get_template_directory_uri() . '/js/attendance.js', array('jquery'), $attendance_version, true);

        // Localize script to pass Ajax URL
        wp_localize_script('attendance-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }
}

add_action('wp_enqueue_scripts', 'codenimo_enqueue_scripts');


// Register a new sidebar
function add_widget_support() {
    register_sidebar( array(
                    'name'          => 'Sidebar',
                    'id'            => 'sidebar',
                    'before_widget' => '<div>',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h2>',
                    'after_title'   => '</h2>',
    ) );
    
}
add_action( 'widgets_init', 'add_widget_support' );


function add_custom_user_role() {
    // Remove the role if it already exists to update it
    remove_role('normal_user');

    // Add the updated role with the desired capabilities
    add_role(
        'normal_user', // Role ID
        'Normal User', // Display Name
        array(
            'read' => true, // This allows the user to log in
            'edit_posts' => true, // Allow editing their own posts
            'delete_posts' => false, // Do not allow deleting their own posts
            'publish_posts' => true, // Allow publishing posts
            'create_posts' => true, // Allow creating posts
            'edit_others_posts' => false, // Do not allow editing others' posts
            'delete_others_posts' => false, // Do not allow deleting others' posts
            'edit_pages' => true, // Allow editing their own pages
            'publish_pages' => true, // Allow publishing pages
            'create_pages' => true, // Allow creating pages
            'edit_others_pages' => false, // Do not allow editing others' pages
            'delete_others_pages' => false, // Do not allow deleting others' pages
            'edit_attendance' => true, // Allow editing attendance posts
            'publish_attendance' => true, // Allow publishing attendance posts
            'read_attendance' => true, // Allow reading attendance posts
            'delete_attendance' => false, // Do not allow deleting attendance posts
        )
    );
}
add_action('init', 'add_custom_user_role');




// function restrict_dashboard_access() {
//     if (is_user_logged_in() && current_user_can('normal_user') && !current_user_can('publish_posts')) {
//         // Redirect to homepage
//         wp_redirect(home_url());
//         exit;
//     }
// }
// add_action('admin_init', 'restrict_dashboard_access');

function redirect_to_home_after_login($redirect_to, $request, $user) {
    // Check if the user is logged in and is not an admin
    if (isset($user->roles) && is_array($user->roles)) {
        // Redirect all users who are not administrators to the homepage
        if (!in_array('administrator', $user->roles)) {
            return home_url(); // Redirect to homepage
        }
    }
    return $redirect_to; // Default redirect for admin users
}
add_filter('login_redirect', 'redirect_to_home_after_login', 10, 3);

// function restrict_admin_access() {
//     if (is_user_logged_in() && !current_user_can('administrator')) {
//         // Redirect non-admin users attempting to access wp-admin
//         wp_redirect(home_url());
//         exit;
//     }
// }
// add_action('admin_init', 'restrict_admin_access');





function remove_admin_bar_for_limited_users() {
    if (is_user_logged_in() && current_user_can('normal_user')) {
        // Remove the admin bar
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'remove_admin_bar_for_limited_users');

function redirect_if_not_logged_in() {
    if (!is_user_logged_in() && !is_page('wp-login.php')) {
        wp_redirect(wp_login_url());
        exit;
    }
}
add_action('template_redirect', 'redirect_if_not_logged_in');

// Register a custom registration form shortcode
function custom_registration_form() {
    ob_start(); ?>

    <form method="post" action="">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" required>
        </p>
        <p>
            <label for="email">Email</label>
            <input type="email" name="email" required>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </p>
        <p>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" required>
        </p>
        <p>
            <input type="submit" name="submit" value="Register">
        </p>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_registration', 'custom_registration_form');

// Handle registration
// Handle registration
function handle_registration() {
    if (isset($_POST['submit'])) {
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);
        $confirm_password = sanitize_text_field($_POST['confirm_password']);

        if ($password !== $confirm_password) {
            // echo '<p>Error: Passwords do not match.</p>';
            wp_redirect(wp_login_url() . '?passwordnotmatch=true');
            return;
        }
        // Create user with pending role
        $userdata = array(
            'user_login' => $username,
            'user_email' => $email,
            'user_pass'  => $password,
            'role'       => 'pending'
        );

        $user_id = wp_insert_user($userdata);

        if (!is_wp_error($user_id)) {
            // Send email notification to admin
            wp_mail('jaxsar.culpable@gmail.com', 'New User Registration', 'A new user has registered: ' . $username);

            // Redirect to homepage with query parameter
            wp_redirect(wp_login_url() . '?registeraccountpending=true');
            exit;
        } else {
          // echo '<p>Error: ' . $user_id->get_error_message() . '</p>';
          wp_redirect(wp_login_url() . '?accountalreadyregistered=true');
        }
    }

    // Check if the logged-in user's role is pending
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        if (in_array('pending', (array) $user->roles)) {
            wp_logout(); // Log out the user
            wp_redirect(wp_login_url() . '?accountstillinpending=true');
            exit;
        }
    }
}
add_action('init', 'handle_registration');



// Approve users manually via admin dashboard
function add_pending_user_role() {
    add_role('pending', 'Pending', array('read' => false));
}
add_action('init', 'add_pending_user_role');


add_action('login_enqueue_scripts', 'add_custom_login_script');
function add_custom_login_script() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            
            const urlParams = new URLSearchParams(window.location.search);

            const lostpasswordremover = document.querySelector('div#signup');
            const lostpasswordContainer = document.querySelector('.loginContainer');
            if (urlParams.get('action') === 'lostpassword') {
                lostpasswordremover.classList.add('display-none');
                lostpasswordContainer.classList.add('widthOptimizer');
            }

            if (urlParams.get('passwordnotmatch') === 'true') {
                const container = document.querySelector('div#signup .registerformContainer .txtContent');

                const loginErrorContainer = document.createElement('div');
                loginErrorContainer.id = 'login_error';
                loginErrorContainer.className = 'notice notice-error';

                const messageContent = document.createElement('p');
                messageContent.innerHTML = '<strong>Error:</strong> The passwords you entered do not match. Please try again.';

                loginErrorContainer.appendChild(messageContent);

                if (container) {
                    
                    container.insertAdjacentElement('afterend', loginErrorContainer);
                }

                const loginElement = document.getElementById('login');
                const signupElement = document.getElementById('signup');
                if (loginElement) {
                    loginElement.classList.add('active');
                }
                if(signupElement){
                    signupElement.classList.remove('active');
                }
            }





            if (urlParams.get('passwordnotmatch') === 'true') {
                const container = document.querySelector('div#signup .registerformContainer .txtContent');

                const loginErrorContainer = document.createElement('div');
                loginErrorContainer.id = 'login_error';
                loginErrorContainer.className = 'notice notice-error';

                const messageContent = document.createElement('p');
                messageContent.innerHTML = '<strong>Error:</strong> The passwords you entered do not match. Please try again.';

                loginErrorContainer.appendChild(messageContent);

                if (container) {
                    
                    container.insertAdjacentElement('afterend', loginErrorContainer);
                }

                const loginElement = document.getElementById('login');
                const signupElement = document.getElementById('signup');
                if (loginElement) {
                    loginElement.classList.add('active');
                }
                if(signupElement){
                    signupElement.classList.remove('active');
                }
            }
            if (urlParams.get('registeraccountpending') === 'true') {
                const container = document.querySelector('div#signup .registerformContainer .txtContent');



                const loginErrorContainer = document.createElement('div');
                loginErrorContainer.id = 'login-message';
                loginErrorContainer.className = 'notice notice-info message';

                const messageContent = document.createElement('p');
                messageContent.innerHTML = '<strong>Success:</strong> Your account is registered! Please wait for admin approval before you can log in.';

                loginErrorContainer.appendChild(messageContent);

                if (container) {
                    
                    container.insertAdjacentElement('afterend', loginErrorContainer);
                }

                const loginElement = document.getElementById('login');
                const signupElement = document.getElementById('signup');
                if (loginElement) {
                    loginElement.classList.add('active');
                }
                if(signupElement){
                    signupElement.classList.remove('active');
                }
            }

            if (urlParams.get('accountalreadyregistered') === 'true') {
                const container = document.querySelector('div#signup .registerformContainer .txtContent');

                const loginErrorContainer = document.createElement('div');
                loginErrorContainer.id = 'login_error';
                loginErrorContainer.className = 'notice notice-error';

                const messageContent = document.createElement('p');
                messageContent.innerHTML = '<strong>Error:</strong> This Account is already created or not approved by admin';

                loginErrorContainer.appendChild(messageContent);

                if (container) {
                    
                    container.insertAdjacentElement('afterend', loginErrorContainer);
                }

                const loginElement = document.getElementById('login');
                const signupElement = document.getElementById('signup');
                if (loginElement) {
                    loginElement.classList.add('active');
                }
                if(signupElement){
                    signupElement.classList.remove('active');
                }
            }


            if (urlParams.get('accountstillinpending') === 'true') {
                const containerlogin = document.querySelector('#login');
                const loginErrorContainer = document.createElement('div');
                loginErrorContainer.id = 'login_error';
                loginErrorContainer.className = 'notice notice-error';

                const messageContent = document.createElement('p');
                messageContent.innerHTML = '<strong>Error:</strong> Your account is pending approval. Please check back later.';

                loginErrorContainer.appendChild(messageContent);

                const header = containerlogin.querySelector('#login > h1');

                if (header) {
                    
                    header.insertAdjacentElement('afterend', loginErrorContainer);
                }
            }
        });
    </script>
    <?php
}

function custom_admin_scripts() {
    // Check if we're on the users.php page
    $screen = get_current_screen();
    if ($screen->id === 'users') {
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const roleCells = document.querySelectorAll('td.role.column-role');

                roleCells.forEach(cell => {
                    if (cell.textContent.trim() === 'Pending') {
                        cell.style.color = 'red';
                        cell.style.fontWeight = 'bold';
                    }
                });
            });
        </script>
        <?php
    }
}
add_action('admin_footer', 'custom_admin_scripts');



add_action('admin_menu', 'add_pending_users_count');

function add_pending_users_count() {
    // Get the number of users with the 'Pending' role
    $pending_users = count_users();
    $pending_count = $pending_users['avail_roles']['pending'] ?? 0;

    // Add a menu item with the count
    global $menu;
    foreach ($menu as $key => $value) {
        if ($value[0] == 'Users') {
            // Append the count to the Users menu item
            if($pending_count != 0){
            $menu[$key][0] .= ' <span class="awaiting-mod">' . $pending_count . '</span>';
            }
            
        }
    }
}
function display_user_info() {
    // Get current user
    $current_user = wp_get_current_user();

    if ($current_user->exists()) {
        // Get user information
        $username = esc_html($current_user->user_login);
        $first_name = esc_html($current_user->user_firstname);
        $last_name = esc_html($current_user->user_lastname);
        $user_email = esc_html($current_user->user_email); // Get user email

        // Determine display name
        $display_name = !empty($first_name) && !empty($last_name) ? $first_name . ' ' . $last_name : $username;

        // Get current profile picture
        $profile_picture_id = get_user_meta($current_user->ID, 'profile_picture', true);
        
        // Handle profile picture upload
        if (!empty($_FILES['profile_picture']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');

            // Upload the file
            $attachment_id = media_handle_upload('profile_picture', 0);
            if (is_wp_error($attachment_id)) {
                $errors[] = $attachment_id->get_error_message(); // Capture any upload errors
            } else {
                // Save the attachment ID to user meta
                update_user_meta($current_user->ID, 'profile_picture', $attachment_id);
                // Redirect to the same page with the query string
                wp_redirect(add_query_arg('profileupdated', 'true', get_permalink()));
                exit;
            }
        }

        // Display user info
        echo '<div class="user-info">';
        
        if ($profile_picture_id) {
            echo '<div class="img-nameContent">' . wp_get_attachment_image($profile_picture_id, 'thumbnail') .'</div>'; 
        } else {
            echo '<div class="img-nameContent"><img width="150" height="150" src="/Codenimo-login/wp-content/uploads/2024/10/f10ff70a7155e5ab666bcdd1b45b726d.jpg" class="attachment-thumbnail size-thumbnail" alt="" decoding="async"></div>';
        }
      
        echo '<div class="txtContent">';
        // Display the appropriate name and email
        echo '<p class="employeeName">' . $display_name . '</p>';
        echo '<p class="employeeEmail">' . $user_email . '</p>'; // Display the user email
        echo '</div>';
        echo '</div>';
    }
}

// Hook into WordPress (e.g., in a shortcode or directly in a template)
add_shortcode('user_info', 'display_user_info');


function create_attendance_post_type() {
    register_post_type('attendance',
        array(
            'labels' => array(
                'name' => __('Attendances'),
                'singular_name' => __('Attendance'),
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'author'), // Add support for title and content
        )
    );
}
add_action('init', 'create_attendance_post_type');


function create_attendance_post() {
    // Check user capabilities
    if (!current_user_can('publish_posts')) {
        wp_send_json_error('You do not have permission to create attendance posts.');
        wp_die();
    }

    $current_user_id = get_current_user_id();

    // Set the start and end of the day for the query
    $today_start = date('Y-m-d 00:00:00');
    $today_end = date('Y-m-d 23:59:59');

    // Create the attendance post
    $post_data = array(
        'author'        => $current_user_id,
        'post_title'   => 'Attendance for ' . date('Y-m-d H:i:s'),
        'post_content' => 'Attendance details here...', // Customize as needed
        'post_status'  => 'publish',
        'post_type'    => 'attendance',
    );

    $post_id = wp_insert_post($post_data);

    if ($post_id) {
        wp_send_json_success(array(
            'message' => 'Logged In Succesfully!'
        ));
    } else {
        wp_send_json_error('Failed to login');
    }

    wp_die(); // This is required to terminate immediately and return a proper response
}
add_action('wp_ajax_create_attendance_post', 'create_attendance_post');
add_action('wp_ajax_nopriv_create_attendance_post', 'create_attendance_post'); // For non-logged-in users, if needed




