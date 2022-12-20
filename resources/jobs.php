
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Job Board</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/slicknav.css">

    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid ">
                    <div class="header_bottom_border">
                        <div class="row align-items-center">
                            <div class="col-xl-3 col-lg-2">
                                <div class="logo">
                                    <a href="/">
                                        <img src="img/logo.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-7">
                                <div class="main-menu  d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="/">home</a></li>
                                            <li><a href="/jobs">Browse Job</a></li>
                                            <li><a href="#">pages <i class="ti-angle-down"></i></a>
                                                <ul class="submenu">
                                                    <li><a href="candidate.html">Candidates </a></li>
                                                    <li><a href="job_details.php">job details </a></li>
                                                    <li><a href="elements.html">elements</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#">blog <i class="ti-angle-down"></i></a>
                                                <ul class="submenu">
                                                    <li><a href="blog.html">blog</a></li>
                                                    <li><a href="single-blog.html">single-blog</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="contact.php">Contact</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 d-none d-lg-block">
                                <div class="Appointment">
                                    <div class="phone_num d-none d-xl-block">
                                        <a href="#">Log in</a>
                                    </div>
                                    <div class="d-none d-lg-block">
                                        <a class="boxed-btn3" href="#">Post a Job</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->

    <!-- bradcam_area  -->
    <div class="bradcam_area bradcam_bg_1">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text">
                        <!--Вывод числа вакансий -->
                        <h3><?=$count?>+ Jobs Available</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ bradcam_area  -->

    <!-- job_listing_area_start  -->
    <div class="job_listing_area plus_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="job_filter white-bg">
                        <div class="form_inner white-bg">
                            <h3>Filter</h3>
                            <form action="/jobs" method="get">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="single_field">
                                            <input type="text" placeholder="Search keyword" name="name" value="<?=$name?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="single_field">
                                            <select class="wide" name="loc">
                                                <option value=">=1" >Location</option>
                                                <!--Вывод списка локаций -->
                                                <?php foreach ($locations as $location):?>
                                                <option value="=<?=$location['id']?>" <?php if('='.$location['id'] == $loc):?> selected <?php endif; ?>><?=$location['name']?></option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="single_field">
                                            <select class="wide" name="cat" >
                                                <option data-display="Category" value=">=1" >Category</option>
                                                <!--Вывод списка категорий -->
                                                <?php foreach ($categories as $category):?>
                                                <option value="=<?= $category['id']?>" <?php if('='.$category['id'] == $cat):?> selected <?php endif; ?>><?=$category['name']?></option>
                                                <?php  endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="single_field">
                                            <select class="wide" name="exp">
                                                <option data-display="Experience" value=">=1">Experience</option>
                                                <!--Вывод списка существующего опыта -->
                                                <?php foreach ($experiences as $experience):?>
                                                <option value="=<?=$experience['id']?>" <?php if('='.$experience['id'] == $exp):?> selected <?php endif; ?>><?=$experience['name']?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="single_field">
                                            <select class="wide" name="job_t">
                                                <option data-display="Job type" value=">=1">Job type</option>
                                                <!--Вывод списка типов работы -->
                                                <?php foreach ($job_types as $job_type): ?>
                                                <option value="=<?=$job_type['id']?>" <?php if('='.$job_type['id'] == $job_t):?> selected <?php endif; ?>><?=$job_type['name']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="single_field">
                                            <select class="wide" name="qual">
                                                <option data-display="Qualification" value=">=1">Qualification</option>
                                                <!--Вывод списка квалификаций -->
                                                <?php foreach ($qualifications as $qualification):?>
                                                <option value='=<?=$qualification['id']?>' <?php if('='.$qualification['id'] == $qual):?> selected <?php endif; ?>><?= $qualification['name']?></option>
                                                <?endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="single_field">
                                            <select class="wide" name="gen">
                                                <option data-display="Gender" value=">=1">Gender</option>
                                                <!--Вывод списка гендеров -->
                                                <?php  foreach ($genders as $gender):?>
                                                <option value="=<?=$gender['id']?>" <?php if('='.$gender['id'] == $gen):?> selected <?php endif; ?>><?=$gender['name']?></option>
                                                <? endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                        </div>

                        <div class="reset_btn">
                            <a class="boxed-btn3 w-100" href="/jobs?loc=>=1&exp=>=1&cat=>=1&job_t=>=1&qual=>=1&gen=>=1&name=">Reset</a>
                        </div>
                        <input class="boxed-btn3 w-100 job_submit" id="jobs_submit" type="submit" value="Submit">
                        </form>
                    </div>



                </div>
                <div class="col-lg-9">
                    <div class="recent_joblist_wrap">
                        <div class="recent_joblist white-bg ">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4>Job Listing</h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="serch_cat d-flex justify-content-end">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="job_lists m-0">
                        <div class="row">
                            <!--Вывод списка вакансий -->
                            <?php foreach ($jobs as $job): ?>
                            <div class="col-lg-12 col-md-12">
                                <div class="single_jobs white-bg d-flex justify-content-between">
                                    <div class="jobs_left d-flex align-items-center">
                                        <div class="thumb">
                                            <img src=<?=$job['src']?> alt="">
                                        </div>
                                        <div class="jobs_conetent">
                                            <a href="/job/<?=$job['id']?>"><h4><?=$job['name']?></h4></a>
                                            <div class="links_locat d-flex align-items-center">
                                                <div class="location">
                                                    <p> <i class="fa fa-map-marker"></i> <?=$job['l_name']?></p>
                                                </div>
                                                <div class="location">
                                                    <p> <i class="fa fa-clock-o"></i> <?=$job['types_name']?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="jobs_right">
                                        <div class="apply_now">
                                            <a class="heart_mark" href="#"> <i class="fa fa-heart"></i> </a>
                                            <a href="job\<?=$job['id']?>" class="boxed-btn3">Apply Now</a>
                                        </div>
                                        <div class="date">
                                            <p>Date line: <?=$job['date']?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- job_listing_area_end  -->
    <?php require 'footer.php'?>


    <!-- link that opens popup -->
    <!-- JS here -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/ajax-form.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script src="js/scrollIt.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/nice-select.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/plugins.js"></script>
    <!-- <script src="js/gijgo.min.js"></script> -->
    <script src="js/range.js"></script>



    <!--contact js-->
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>


    <script src="js/main.js"></script>


	<script>
        $( function() {
            $("#slider-range").slider({
                range: true,
                min: 12,
                max: 180,
                values: [12, 180],
                slide: function( event, ui ) {
                    $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] +"/ Year" );
                    $("#salary_min").val( ui.values[0]);
                    $("#salary_max").val( ui.values[1]);
                }
            });
            $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
                " - $" + $( "#slider-range" ).slider( "values", 1 ) + "/ Year");

            $("#salary_min").val(  $( "#slider-range" ).slider("values")[0]);
            $("#salary_max").val( $( "#slider-range" ).slider("values")[1]);
        } );
        </script>
</body>

</html>