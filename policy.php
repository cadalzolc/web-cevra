<?php

session_start();

include('./libs/base.php');
include('./libs/db.php');

$today = date("D, M j, Y");
$GLOBALS["tabs"] = "Policy";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>CEVRA - Policy</title>
    <link rel="icon" href="<?php echo BASE_URL() . 'assets/base/img/icon.png' ?>" type="image/png" sizes="16x16">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/fontface' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/unicons.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/style.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/responsive.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/night-mode.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/all.min.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/owl.carousel.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/owl.theme.default.min.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/bootstrap-select.min.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/base/css/custom.css' ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL() . 'assets/plugins/css/toastr.css' ?>">
</head>

<body class="d-flex flex-column h-100">
    <?php include("./website/layouts/header.php"); ?>
    <div class="wrapper">
        <div class="breadcrumb-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-10">
                        <div class="barren-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL() ?>">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Policy</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="explore-events p-80">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="panel-body">
                            <strong>
                                <h3>POLICY</h3>
                            </strong>
                            <br />
                            <p>The Calbayog Events Venue Rentals Web Application (CEVRWA) is committed to protecting and
                                respecting your privacy.
                                This policy (together with our terms of use and any other documents referred to in it)
                                sets out the basis on which any personal data we collect from you, or that you provide
                                to us, will be processed by us. Please read the following carefully to understand our
                                views and practices regarding your personal data and how we will treat it.
                            </p>
                            <br />
                            <strong>
                                <h4 style="color:#ff0000;">CLIENTS</h4>
                            </strong>
                            <br>
                            <strong>
                                <h4 style="color:#ff0000;">Information We Collect</h4>
                            </strong>
                            <p>We collect information about you that you provide to us when using the Site, such as your
                                name, address, phone number, e-mail address, preferred event details, length of use of
                                service, and your CEVRWA account password for accommodation reservations.
                                If you decide to book event venues through our Site, depending on the type of events you
                                are reserving, there may be limited additional information that we may collect from you,
                                including number and name of the guest, maximum hours of service usage, selected gateway
                                interfaces account information for payment and information about any special
                                requirements that we need to consider in connection with your reservation.
                                Where you are making a booking with other guests whose details you provide to us as part
                                of your reservation, or if you make a booking on behalf of someone else, it is your
                                responsibility to ensure that the person or people you have provided personal
                                information about are aware that you have done so, and have understood and accepted how
                                CEVRWA uses their information (as described in this Privacy Policy).
                            </p>
                            <strong>
                                <h4 style="color:#ff0000;">How We Use the Information We Collect</h4>
                            </strong>
                            <p>We may use information collected through the Site to:
                                • Provide you with the requested services, such as creating a user account, processing
                                and confirming your reservation, and communicating with you about services requested
                                (e.g., pre-reservation or post booking information support (excluding payment
                                information), special request, cancellations, and refunds.
                                • Maintain and improve the Site, tailor the user experience, and for internal training
                                • Protect the security of you and the Site
                                • Exercising a right or obligation conferred or imposed by law, including responding to
                                request and legal demands
                                If you have not finalized a reservation online, we will give you minimum days to
                                finalize your booking depending on the business entities rules and regulations. Please
                                note that the confirmation emails sent after your booking are not marketing messages.
                                These messages are part of your accommodation reservation process. Respectively, they
                                contain information for you to access the service you reserved for.
                                As mentioned above, if you are completing the booking for another person who will stay
                                at the reserved accommodation, you also have the option to insert the guest’s email
                                address for the purpose that the guest will receive the reservation confirmation.
                            </p>
                            <strong>
                                <h4 style="color:#ff0000;">Information We Collect</h4>
                            </strong>
                            <p>We collect information about you that you provide to us when using the Site, such as your
                                name, address, phone number, e-mail address, preferred event details, length of use of
                                service, and your CEVRWA account password for accommodation reservations.
                                If you decide to book event venues through our Site, depending on the type of events you
                                are reserving, there may be limited additional information that we may collect from you,
                                including number and name of the guest, maximum hours of service usage, selected gateway
                                interfaces account information for payment and information about any special
                                requirements that we need to consider in connection with your reservation.
                                Where you are making a booking with other guests whose details you provide to us as part
                                of your reservation, or if you make a booking on behalf of someone else, it is your
                                responsibility to ensure that the person or people you have provided personal
                                information about are aware that you have done so, and have understood and accepted how
                                CEVRWA uses their information (as described in this Privacy Policy).
                            </p>
                            <strong>
                                <h4 style="color:#ff0000;">RESERVATION</h4>
                            </strong>
                            <br />
                            <strong>
                                <h4 style="color:#ff0000;">Mobile Devices</h4>
                            </strong>
                            <p>We will send you push notifications with information about your reservation. You may
                                grant us access to your location information or contact details in order to provide
                                services requested by you. </p>
                            <strong>
                                <h4 style="color:#ff0000;">Security</h4>
                            </strong>
                            <p>We maintain reasonable security measures to protect your information and require our
                                service providers to do the same. We maintain reasonable physical, electronic, and
                                organizational security measures to protect your information against accidental or
                                unlawful destruction or accidental loss, alteration, or unauthorized disclosure or
                                access. Your user password will be encrypted and not visible to the platform owner. </p>
                            <strong>
                                <h4 style="color:#ff0000;">Data Retention</h4>
                            </strong>
                            <p>We will retain your information for the period necessary to provide and secure our Sites
                                and services, and to exercise our legal rights and comply with our legal or regulatory
                                obligations. When CEVWRA no longer needs to use your information, we will – unless we
                                need to keep your information to comply with applicable legal or regulatory obligations
                                or the information is required to carry out corporate tasks and conduct our business –
                                remove it from our systems and records and/or take steps to properly anonymize it so
                                that you can no longer be identified from it. <p>
                                    <strong>
                                        <h4 style="color:#ff0000;">Data Subject Rights</h4>
                                    </strong>
                                    <p>WYou may exercise certain rights of access, correction, deletion, portability, or
                                        object to certain processing of your information.
                                        You can easily correct your account name, the booking holder name (subject to
                                        the cancellation policy attached to the booking) and contact number at any time
                                        by signing in to your account on the website.
                                        • Access: You are entitled at any time to obtain information about your personal
                                        information that we store, in accordance with applicable law and without any
                                        fee.
                                        • Rectification: You can rectify any of your personal information that is
                                        incomplete or incorrect.
                                        • Deletion: You may request that we delete your account.
                                        • Data Portability: If applicable, you may request us to send you your personal
                                        information which we store, in a commonly used and machine readable format which
                                        shall be decided at our sole discretion.
                                        We would like to remind that you have the full access only to your account. Any
                                        problems that you will encounter because of the information you changed is not
                                        our responsibilities. You have to make sure that the data you input to your
                                        account are valid and reliable.
                                    </p>
                                    <strong>
                                        <h4 style="color:#ff0000;">Business Entities</h4>
                                    </strong>
                                    <p>Calbayog Events Venue Rentals Web Application will take your Business name,
                                        Business permit, and business information, details of offered services and
                                        business accounts. The payment needed your personal information to manage and
                                        process the payment.
                                        CEVRWA will not have access to payment details provided to the Payment
                                        Processor. Please note that CEVRWA cannot guarantee the security of data which
                                        You send us by email. Accordingly, please do not send CEVRWA any payment
                                        information using email.
                                        Information provided in your application will be shared with relevant personnel
                                        for the purposes of selection where the business is legit and valid business or
                                        organization.
                                        Photos and Images of the business will be taken to be inputted into the system
                                        for reservation and business details purposes.
                                        Sales report that will be provided by the system is ensured to be safe and
                                        secured.
                                        <p>
                                            <strong>
                                                <h4 style="color:#ff0000;">Management</h4>
                                            </strong>
                                            <p>Business entities will personally manage their business information and
                                                details at the same time aide the booking process. Business entities
                                                will confirm and cancel the reservation based on the business entities
                                                rules and regulations.
                                                <br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo BASE_URL() . 'assets/base/js/jquery-3.6.0.min.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/bootstrap.bundle.min.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/owl.carousel.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/bootstrap-select.min.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/custom.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/night-mode.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/plugins/js/toastr.js' ?>"></script>
    <script src="<?php echo BASE_URL() . 'assets/base/js/app.js' ?>"></script>
</body>

</html>