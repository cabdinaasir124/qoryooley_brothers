$(document).ready(function () {
    // Pre-fill form with current data
    $.ajax({
        url: '../api/get_user_profile.php', // separate API for fetching profile
        type: 'GET',
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success') {
                $('input[name="username"]').val(res.data.username);
                $('input[name="email"]').val(res.data.email);
            }
        }
    });

    // Submit form via AJAX
    $('#updateProfileForm').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '../api/update_profile.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    toastr.success(res.message);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function () {
                toastr.error('Something went wrong');
            }
        });
    });
});

$(document).ready(function () {
    $.ajax({
        url: '../api/get_user_profile.php',
        method: 'GET',
        dataType: 'json',
    success: function (response) {
    if (response.status === 'success') {
        const user = response.data;
        $('#user-name').text(user.username);
        $('#user-role').text(user.role);

        // Check for profile image, fallback to default if empty or null
        const imagePath = (user.profile_image && user.profile_image !== '')
            ? '../upload/profile/' + user.profile_image
            : '../upload/profile/image.png'; // your default image path

        $('#user-profile-image').attr('src', imagePath);
    } else {
        console.error(response.message);
    }
},
error: function () {
    console.error('Failed to fetch user profile.');
}

    });
});

