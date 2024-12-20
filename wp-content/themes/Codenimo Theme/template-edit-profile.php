<?php
/* Template Name: Edit Profile */
ob_start(); // Start output buffering
get_header();


$current_user = wp_get_current_user();
$errors = []; // Initialize an array for error messages
$success_message = ''; // Variable for success message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user information
    $userdata = [
        'ID' => $current_user->ID,
        'first_name' => sanitize_text_field($_POST['first_name']),
        'last_name' => sanitize_text_field($_POST['last_name']),
        'nickname' => sanitize_text_field($_POST['nickname']),
        'user_email' => sanitize_email($_POST['user_email']),
    ];

    // Handle password change
    if (!empty($_POST['new_password']) || !empty($_POST['confirm_password'])) {
        if ($_POST['new_password'] === $_POST['confirm_password']) {
            $userdata['user_pass'] = $_POST['new_password']; // Add new password to the array
        } else {
            $errors[] = 'The passwords do not match. Please try again.';
        }
    }
    else {
        
    }
    // Update user profile
    if (empty($errors)) {
        $result = wp_update_user($userdata);

        // Check for errors in user update
        if (is_wp_error($result)) {
            $errors[] = $result->get_error_message();
        } else {
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
                }
            }

            // Check for errors and prepare the success message
            if (empty($errors)) {
                
                // Redirect to the same page with the query string
                wp_redirect(add_query_arg('profileupdated', 'true', get_permalink()));
                exit;
            }
        }
    }
}


// Display current profile picture
$profile_picture_id = get_user_meta($current_user->ID, 'profile_picture', true);
?>
    <?php if (!empty($errors)): // Display error messages ?>
        <div class="error-messages">
        
                <?php foreach ($errors as $error): ?>
               
                <?php endforeach; ?>
            
        </div>
    <?php endif; ?>
<section class="editTemplateSection">
    <div class="container">
        
        <div class="profile-edit-form">
            <div class="txtImgContent">
                <h2>Edit Profile</h2>

                

                <?php if ($profile_picture_id): ?>
                <div class="current-picture">
                    <img src="<?php echo wp_get_attachment_url($profile_picture_id); ?>" width="150" height="150" alt="" decoding="async">
                </div>
                <?php else: ?>
                <div class="current-picture">
                    <img width="150" height="150" src="/Codenimo-login/wp-content/uploads/2024/10/f10ff70a7155e5ab666bcdd1b45b726d.jpg" class="attachment-thumbnail size-thumbnail" alt="" decoding="async">
                </div>
                <?php endif; ?>
            </div>

          

            <form method="post" enctype="multipart/form-data" onsubmit="return confirmUpdate()">
                <div class="input-2colContent">
                    <div class="input-container">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" value="<?php echo esc_attr($current_user->first_name); ?>">
                    </div>
                    <div class="input-container">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" value="<?php echo esc_attr($current_user->last_name); ?>">
                    </div>  
                </div>
                <div class="input-container">
                    <label for="nickname">Nickname</label>
                    <input type="text" name="nickname" value="<?php echo esc_attr($current_user->nickname); ?>" required>
                </div>  
                <div class="input-container">
                    <label for="user_email">Email</label>
                    <input type="email" name="user_email" value="<?php echo esc_attr($current_user->user_email); ?>" required>
                </div>  
                <div class="input-container profilepictureInput">
                    <input type="file" name="profile_picture">
                </div>  
                <?php $error_class = !empty($errors) ? 'field-error' : ''; ?>
                <div class="input-container <?php echo esc_attr($error_class); ?>">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password">
                    <p><?php echo esc_html($error); ?></p>
                </div>  
                <div class="input-container <?php echo esc_attr($error_class); ?>">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" name="confirm_password">
                    <p><?php echo esc_html($error); ?></p>
                </div>  
                <input type="submit" value="Update Profile">
            </form>
            <?php if (isset($_GET['profileupdated']) && $_GET['profileupdated'] === 'true'): ?>
                    <div class="success-message">
                        <p>Your profile has been updated successfully!</p>
                    </div>
                <?php endif; ?>
            <script>
            function confirmUpdate() {
                return confirm('Are you sure you want to update your profile?');
            }
            </script>
             
        </div>
    </div>
</section>

<?php
get_footer();
ob_end_flush(); // Flush the output buffer
