jQuery(document).ready(function($) {
    $('#create-attendance').on('click', function() {
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'create_attendance_post'
            },
            success: function(response) {
                if (response.success) {
                    // Update the attendanceContainer with the new class
                    alert(response.data.message); // Show success message
                } else {
                    alert(response.data); // Show error message
                }
            }
        });
    });
});