/**
 * Depo Hunter Login Page Scripts (jQuery)
 */
$(document).ready(function () {
    // Toggle Password Visibility
    $('#togglePasswordBtn').on('click', function (e) {
        e.preventDefault();
        const passwordInput = $('#passwordInput');
        const eyeIcon = $('#eyeIcon');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Form Submit Loading Feedback
    $('#loginForm').on('submit', function () {
        const btn = $('#loginSubmitBtn');
        btn.prop('disabled', true);
        btn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Memproses Autentikasi...');
    });

    // Smooth focus on first input
    if ($('#emailInput').val() === '') {
        $('#emailInput').focus();
    } else {
        $('#passwordInput').focus();
    }
});
