<!-- Optional JavaScript -->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?= base_url('assets/js/') ?>jquery.min.js"></script>
<script src="<?= base_url('assets/js/') ?>popper.min.js"></script>
<script src="<?= base_url('assets/js/') ?>bootstrap.min.js"></script>
<!-- Appear JavaScript -->
<script src="<?= base_url('assets/js/') ?>jquery.appear.js"></script>
<!-- Countdown JavaScript -->
<script src="<?= base_url('assets/js/') ?>countdown.min.js"></script>
<!-- Counterup JavaScript -->
<script src="<?= base_url('assets/js/') ?>waypoints.min.js"></script>
<script src="<?= base_url('assets/js/') ?>jquery.counterup.min.js"></script>
<!-- Wow JavaScript -->
<script src="<?= base_url('assets/js/') ?>wow.min.js"></script>
<!-- Apexcharts JavaScript -->
<script src="<?= base_url('assets/js/') ?>apexcharts.js"></script>
<!-- Slick JavaScript -->
<script src="<?= base_url('assets/js/') ?>slick.min.js"></script>
<!-- Select2 JavaScript -->
<script src="<?= base_url('assets/js/') ?>select2.min.js"></script>
<!-- Owl Carousel JavaScript -->
<script src="<?= base_url('assets/js/') ?>owl.carousel.min.js"></script>
<!-- Magnific Popup JavaScript -->
<script src="<?= base_url('assets/js/') ?>jquery.magnific-popup.min.js"></script>
<!-- Smooth Scrollbar JavaScript -->
<script src="<?= base_url('assets/js/') ?>smooth-scrollbar.js"></script>
<!-- lottie JavaScript -->
<script src="<?= base_url('assets/js/') ?>lottie.js"></script>
<!-- am core JavaScript -->
<script src="<?= base_url('assets/js/') ?>core.js"></script>
<!-- am charts JavaScript -->
<script src="<?= base_url('assets/js/') ?>charts.js"></script>
<!-- am animated JavaScript -->
<script src="<?= base_url('assets/js/') ?>animated.js"></script>
<!-- am kelly JavaScript -->
<script src="<?= base_url('assets/js/') ?>kelly.js"></script>
<!-- Flatpicker Js -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- Chart Custom JavaScript -->
<script src="<?= base_url('assets/js/') ?>chart-custom.js"></script>
<!-- Custom JavaScript -->
<script src="<?= base_url('assets/js/') ?>custom.js"></script>
<script src="<?= base_url('assets/js/') ?>simple.money.format.js"></script>
<script src="<?= base_url('assets/vendor/jQuery-Mask-Plugin/dist/jquery.mask.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('.notif').toast('hide');

    function notification(type, message) {

        if (type == 'error') {
            $('.notif').addClass('bg-danger');
            $('.toast-header').addClass('bg-danger');
        } else if (type == 'warning') {
            $('.notif').addClass('bg-warning');
            $('.toast-header').addClass('bg-warning');
        } else {
            $('.notif').addClass('bg-primary');
            $('.toast-header').addClass('bg-primary');
        }

        $('.toast-title').html(type.toUpperCase());
        $('.toast-body').html(message);

        $('.notif').toast('show');
    }

    $('.nis-mask').mask('9999999999');
    $('.nik-mask').mask('999.9999.9999.999.99');
    $('.npwp-mask').mask('99.999.999.9-999.999');
    $('.date-mask').mask('00/00/0000');
    $('.time-mask').mask('00:00:00');
    $('.date_time-mask').mask('00/00/0000 00:00:00');
    $('.cep-mask').mask('00000-000');
    $('.phone-mask').mask('620000000000000');
    $('.phone_with_ddd-mask').mask('(00) 0000-0000');
    $('.phone_us-mask').mask('(000) 000-0000');
    $('.mixed-mask').mask('AAA 000-S0S');
    $('.cpf-mask').mask('000.000.000-00', {
        reverse: true
    });
    $('.cnpj-mask').mask('00.000.000/0000-00', {
        reverse: true
    });
    $('.money-mask').mask('000.000.000.000.000,00', {
        reverse: true
    });
    $('.money2-mask').mask("#.##0", {
        reverse: true
    });
    $('.ip_address-mask').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
        translation: {
            'Z': {
                pattern: /[0-9]/,
                optional: true
            }
        }
    });
    $('.ip_address-mask').mask('099.099.099.099');
    $('.percent').mask('##0,00%', {
        reverse: true
    });
    $('.clear-if-not-match-mask').mask("00/00/0000", {
        clearIfNotMatch: true
    });
    $('.placeholder-mask').mask("00/00/0000", {
        placeholder: "__/__/____"
    });
    $('.fallback-mask').mask("00r00r0000", {
        translation: {
            'r': {
                pattern: /[\/]/,
                fallback: '/'
            },
            placeholder: "__/__/____"
        }
    });
    $('.selectonfocus-mask').mask("00/00/0000", {
        selectOnFocus: true
    });

    $('.select2').select2({
        placeholder: 'Select an option',
        theme: 'bootstrap4'
    });

    // notification('error', 'Halo terima kasih sudah melakukan update');
</script>

<?php
if (!empty($plugin)) {
    $this->load->view($plugin);
}
?>