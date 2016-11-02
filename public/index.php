<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">

    <title>Jeff Byrnes, web developer, bassist, Mac Tech</title>
    <meta name="description" content="">

    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/style.css">

    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.min.js"></script>
</head>
<body>
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
                    <li><a class="social-link ir" id="social-twitter" href="http://twitter.com/thejeffbyrnes" title="Follow me on Twitter">Twitter</a></li>
                    <li><a class="social-link ir" id="social-flickr" href="http://www.flickr.com/photos/berkleebassist/" title="Photos on Flickr">Flickr</a></li>
                    <li><a class="social-link ir" id="social-github" href="http://github.com/jeffbyrnes" title="Github">Github</a></li>
                </ul><!-- end .social-links -->
            </nav>
        </header>

        <div class="main" role="main">
            <p class="blurb">Based in Boston since 2002, I attended <a href="http://www.berklee.edu/">Berklee</a>, playing both upright and electric&nbsp;bass.<br>While at school, I ended up gravitating to tech, becoming a developer by the time I finished. I’m also a <a href="http://www.couchsurfing.org/people/jeffbyrnes/">CouchSurfer</a> and a SCUBA&nbsp;diver.</p>

            <p class="current-job">Currently, I work for <a href="https://darksky.net/">The Dark Sky Company</a>.</p>

            <section class="skills">
                <h1>I’m skilled in</h1>

                <ul>
                    <li>Automation</li>
                    <li>AWS</li>
                    <li>DevOps</li>
                    <li>Git</li>
                    <li>Ruby</li>
                    <li>PHP</li>
                    <li>HTML5</li>
                    <li>CSS3</li>
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

                    $username       = 'berkleebassist';
                    $user_id        = '79697399@N00';
                    $photoset_id    = '72157629119921020'; // 'Diving the Deep'
                    $jump_to        = null;
                    $safe_search    = 1; // show only safe content
                    $privacy_filter = 1; // show only public photos
                    $extras         = null;
                    $per_page       = 6;

                    // Get 6 photos from a particular photoset + its metadata
                    $photos        = $f->photosets_getPhotos($photoset_id, $extras, $privacy_filter, $per_page);
                    $photoset_info = $f->photosets_getInfo($photoset_id);

                    foreach ($photos['photoset']['photo'] as $photo) {
                        echo '<li class="flickr-thumb">';
                        // print out a link to the photo page, attaching the id of the photo
                        echo '<a href="http://www.flickr.com/photos/berkleebassist/' . $photo['id'] . '" title="View ' . $photo['title'] . '">';

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

                <h1><?php echo $photoset_info['description']; ?></h1>

                <a class="button" href="http://www.flickr.com/photos/berkleebassist/">More photos on Flickr</a>
            </div><!-- end .photos -->

            <figure class="quote">
                <hr>

                <blockquote>The important thing is not to stop questioning.</blockquote>

                <hr>

                <figcaption>Albert Einstein</figcaption>
            </figure><!-- end .quote -->

            <div class="twitter">
                <a class="twitter-timeline" href="https://twitter.com/thejeffbyrnes" data-widget-id="379704187694481408" data-chrome="noheader nofooter noborders transparent" data-tweet-limit="3">Tweets by @thejeffbyrnes</a>

                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

                <a class="button" href="http://twitter.com/thejeffbyrnes">@thejeffbyrnes</a>
            </div>
        </div><!-- end .main -->

        <footer>
            <hr>

            <hgroup>
                <h1>Thanks for stopping by</h1>
                <h2>Cheers!</h2>
            </hgroup>

            <hr>

            <a class="button" href="mailto:thejeffbyrnes@gmail.com?subject=Dropping a line from thejeffbyrnes.com">Drop me a line</a>
        </footer>
    </div><!-- end .container -->

    <div class="footer-image ir">
        <p>© 2012–<?php echo date('Y'); ?> Jeff Byrnes</p>
    </div>

    <!-- Google Universal Analytics beta
         analytics.blogspot.com/2013/03/expanding-universal-analytics-into.html -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-583944-15', 'thejeffbyrnes.com');
        ga('send', 'pageview');
    </script>

    <script>
        var GoSquared = {};
        GoSquared.acct = "GSN-085834-Q";
        (function(w){
            function gs(){
                w._gstc_lt = +new Date;
                var d = document, g = d.createElement("script");
                g.src = "//d1l6p2sc9645hc.cloudfront.net/tracker.js";
                var s = d.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(g, s);
            }
            w.addEventListener ?
                w.addEventListener("load", gs, false) :
                w.attachEvent("onload", gs);
        })(window);
    </script>
</body>
</html>
