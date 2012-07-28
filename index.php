<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>Jeff Byrnes, web developer, bassist, Mac Tech</title>
    <meta name="description" content="">

    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="/css/style.css">

    <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

    <!-- All JavaScript at the bottom, except this Modernizr build.
             Modernizr enables HTML5 elements & feature detects for optimal performance.
             Create your own custom Modernizr build: www.modernizr.com/download/ -->
    <script src="/js/libs/modernizr-2.5.3.min.js"></script>
</head>
<body>
    <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you support IE 6.
             chromium.org/developers/how-tos/chrome-frame-getting-started -->
    <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->

    <div class="header-image">
        <img src="/img/avatar@2x.png" alt="Jeff Byrnes' avatar" width="52" height="61">
    </div>

    <div class="container">
        <header class="site-header">
            <hgroup>
                <h1>Hey there, I’m&nbsp;Jeff&nbsp;Byrnes</h1>
                <h2>I’m a web developer, bassist, and Mac Tech.</h2>
            </hgroup>

            <nav>
                <ul class="social-links clearfix">
                    <li><a class="social-link ir" id="social-facebook" href="http://www.facebook.com/jeffbyrnes" title="Facebook">Facebook</a></li>
                    <li><a class="social-link ir" id="social-twitter" href="http://twitter.com/berkleebassist" title="Follow me on Twitter">Twitter</a></li>
                    <li><a class="social-link ir" id="social-flickr" href="http://www.flickr.com/photos/berkleebassist/" title="Photos on Flickr">Flickr</a></li>
                    <li><a class="social-link ir" id="social-github" href="http://github.com/jeffbyrnes" title="Github">Github</a></li>
                </ul><!-- end .social-links -->
            </nav>
        </header>

        <div class="main" role="main">
            <p class="blurb">Based in Boston since 2002, I attended <a href="http://www.berklee.edu/">Berklee</a>, playing both upright and electric&nbsp;bass.<br>While at school, I ended up gravitating to tech, becoming a developer by the time I finished. I’m also a <a href="www.couchsurfing.org/people/jeffbyrnes/">CouchSurfer</a> and a SCUBA diver.</p>

            <p class="current-job">Currently, I work for <a href="http://www.hungryfishmedia.com/">Hungry Fish Media</a>.</p>

            <section class="skills">
                <h1>I’m skilled in</h1>

                <ul>
                    <li>HTML5</li>
                    <li>CSS3</li>
                    <li>PHP</li>
                    <li>Git</li>
                    <li>MySQL</li>
                </ul>

                <p>and various other bits and pieces</p>

                <a class="button" href="http://github.com/jeffbyrnes">My GitHub profile</a>
            </section><!-- end .skills -->

            <div class="photos">
                <ul class="flickr-photos clearfix">
                    <?php
                    $flickr_api_key = '62bed203339ef3c90ad78eba543be3cd';

                    require_once('inc/phpFlickr.php');
                    $f = new phpFlickr($flickr_api_key);

                    // Enable filesystem-based caching
                    $f->enableCache('fs', $_SERVER['DOCUMENT_ROOT'] . '/.flickr-cache');

                    $username    = 'berkleebassist';
                    $user_id     = '79697399@N00';
                    $jump_to     = NULL;
                    $safe_search = 1; // show only safe content
                    $extras      = NULL;
                    $per_page    = 6;
                    $page        = NULL;

                    // Get 6 recent photos of mine
                    $photos = $f->people_getPublicPhotos($user_id, $safe_search, $extras, $per_page, $page);

                    // echo '<pre>'; print_r($photos); echo '</pre>';

                    foreach ($photos['photos']['photo'] as $photo) {
                        echo '<li class="flickr-thumb">';
                        // print out a link to the photo page, attaching the id of the photo
                        echo '<a href="photo.php?id=' . $photo['id'] . '" title="View ' . $photo['title'] . '">';

                        // This next line uses buildPhotoURL to construct the location of our image,
                        // and we want the 'Large Square' size
                        // It also gives the image an alt attribute of the photo's title
                        echo '<img src="'
                                . $f->buildPhotoURL($photo, 'large_square')
                                .  '" alt="'
                                . $photo['title']
                                . '">
                        ';

                        // close link & list item
                        echo '</a></li>';
                    }
                    ?>
                </ul>

                <h1>SCUBA diving in the Caribbean and the South Pacific, 2006.</h1>

                <a class="button" href="http://www.flickr.com/photos/berkleebassist/">More photos on Flickr</a>
            </div><!-- end .photos -->

            <figure class="quote">
                <hr>

                <blockquote>The important thing is not to stop questioning.</blockquote>

                <hr>

                <figcaption>Albert Einstein</figcaption>
            </figure><!-- end .quote -->

            <div class="twitter">
                <ul>
                    <li class="toot">
                        <a class="toot-time toot-permalink" href="#">4 hours ago</a>

                        <p><a href="http://twitter.com/amyullman">@AmyUllman</a> Haha, I hear yah! Easy to resist with work to return to though.</p>
                    </li>

                    <li class="toot">
                        <a class="toot-time toot-permalink" href="#">13 hours ago</a>

                        <p>Hanging with the <a>@litmusapp</a> folks! (with <a>@jennamarino</a>, Patrick, and Justine at <a>@litmusapp</a>) — <a>path.com/p/2nFnPi</a></p>
                    </li>

                    <li class="toot">
                        <a class="toot-time toot-permalink" href="#">19 hours ago</a>

                        <p><a href="http://twitter.com/ctconnors">@ctconnors</a> YUP</p>
                    </li>
                </ul>

                <a class="button" href="http://twitter.com/berkleebassist">@berkleebassist</a>
            </div>
        </div><!-- end .main -->

        <footer>
            <hgroup>
                <h1>Thanks for stopping by</h1>
                <h2>Bye now!</h2>
            </hgroup>

            <a class="button" href="mailto:jeff@jeffbyrn.es?subject=Dropping a line from jeffbyrn.es">Drop me a line</a>
        </footer>
    </div><!-- end .container -->

    <div class="footer-image ir">
        <p>© <?php echo date('Y'); ?> Jeff Byrnes</p>
    </div>


    <!-- JavaScript at the bottom for fast page loading -->

    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.2.min.js"><\/script>')</script>

    <!-- scripts concatenated and minified via build script -->
    <script src="/js/plugins.js"></script>
    <script src="/js/script.js"></script>
    <!-- end scripts -->

    <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
             mathiasbynens.be/notes/async-analytics-snippet -->
    <script>
        var _gaq=[['_setAccount','UA-583944-9'],['_setDomainName', 'jeffbyrn.es'],['_trackPageview']];
        (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>

    <script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</body>
</html>