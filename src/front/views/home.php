<?php require_once __DIR__ . '/includes/shared-head.php'; ?>

<link rel="stylesheet" href="/src/front/css/home.css">
<script type="module" src="/src/front/scripts/home/buttons-scroll.js" defer></script>

<?php echo generateSEOTags('Chef Manuelle Webpage', 'This is the home page of Chef Manuelle webpage, here you can find all related services to him.'); ?>

</head>

<body>
    <?php require_once __DIR__ . '/includes/shared-components.php'; ?>

    <?php
    $midHeader =
        '<li class="italic"><a id="chef-scroll">The Chef</a></li>
    <li class="italic"><a id="experience-scroll">The Experience</a></li>
    <li class="italic"><a href="/menu">The Menu</a></li>';

    echo createHeader($midHeader);
    ?>
    <main>
        <section id="hero">
            <div id="hero-text">
                <h1>A healthy meal delivered to your door, every single day</h1>
                <h6>The smart 365-days-year food subscription that will make you eat healthy again. Tailored to your personal tastes and nutritional needs.</h6>
                <div id="hero-buttons">
                    <a class="btn-primary" href="/menu">Check the Menu</a>
                </div>
            </div>
            <div>
                <img src=" /src/front/assets/imgs/hero-image.webp" alt="hero-image">
            </div>
        </section>
        <section id="chef">
            <h2>The Chef</h2>
            <div id="chef-body">
                <div>
                    <img src="/src/front/assets/imgs/chef-img.webp" alt="chef-image">
                </div>
                <div id="chef-text">
                    <h3>
                        Chef Manuelle: A culinary journey</h3>
                    <p>Meet Chef Manuelle, a culinary virtuoso with over 25 years of culinary expertise. Her journey in the world of gastronomy has been nothing short of extraordinary. Having honed her skills in the most prestigious kitchens around the globe, she now stands at the threshold of a new culinary adventure.</p>
                    <p id="second-p">Now, Chef Manuelle embarks on a new standalone project, bringing her unparalleled passion and expertise directly to you. Her dedication to culinary excellence remains unwavering as she introduces a range of experiences on this webpage that reflect her commitment to culinary innovation and the art of food.</p>
                    <div id="chef-buttons">
                        <a href="/" class="btn-secondary">Check my Instagram</a>
                    </div>
                </div>
            </div>
        </section>
        <section id="experience">
            <h2>The Experience</h2>
            <div id="experience-body">
                <article id="exp-1">
                    <h3>
                        Chef-curated food delivered to you
                    </h3>
                    <div class="exp-small-img">
                        <img src="/src/front/assets/imgs/home-img-1.webp" alt="focaccia">
                    </div>
                    <p>
                        Indulge in a delightful culinary experience from the comfort of your own home with Manuelle's exclusive food delivery service. Experience the magic of having a skilled chef prepare and deliver exquisite, handcrafted meals right to your doorstep.
                    </p>
                    <div class="cta">
                        <a href="/menu" class="btn-primary">Check the Menu</a>
                    </div>
                </article>
                <div id="exp-2">
                    <img src="/src/front/assets/imgs/home-img-1.webp" alt="focaccia">
                </div>
                <article id="exp-3">
                    <h3>
                        Private chef for your favourite events
                    </h3>
                    <div class="exp-small-img">
                        <img src="/src/front/assets/imgs/home-img-2.webp" alt="focaccia">
                    </div>
                    <p>
                        Manuelle offers a private chef service that caters to a range of events, including weddings, birthdays, and company meals. From intimate gatherings to large celebrations, she provides a personalized culinary experience that is tailored to your tastes and preferences.
                    </p>
                    <div class="cta">
                        <a href="/404" class="btn-primary">Book an Event</a>
                    </div>
                </article>

                <div id="exp-4">
                    <img src="/src/front/assets/imgs/home-img-2.webp" alt="focaccia">
                </div>
                <article id="exp-5">
                    <h3>
                        Cooking Classes and Demonstrations
                    </h3>
                    <div class="exp-small-img">
                        <img src="/src/front/assets/imgs/home-img-3.webp" alt="focaccia">
                    </div>
                    <p>
                        Meet Chef Manuelle, a culinary virtuoso with over 25 years of culinary expertise. Her journey in the world of gastronomy has been nothing short of extraordinary. Having honed her skills in the most prestigious kitchens around the globe, she now stands at the threshold of a new culinary adventure.
                    </p>
                    <div class="cta">
                        <a href="/404" class="btn-primary">Book a Worskop</a>
                    </div>
                </article>

                <div id="exp-6">
                    <img src="/src/front/assets/imgs/home-img-3.webp" alt="focaccia">
                </div>


        </section>
    </main>
    <?php require_once __DIR__ . '/includes/footer.php';
