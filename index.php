<?php

require_once 'lib/constants.php';

?>
<!doctype html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="Random number generator as-a-service.">

    <title>rnjees.us &mdash; RNG as a service</title>

    <link href="https://fonts.googleapis.com/css?family=Khula" rel="stylesheet">
    <link rel="stylesheet" href="css/app.css">
  </head>
  <body>
    <div class="backplate" id="backplate"></div>

    <section class="step" data-step="1">

      <header>
        <h1>rnjees.us</h1>
      </header>

      <div class="content">

        <p>Let's generate some RNG.</p>
        <p>If you'd prefer, there's an <a href="https://github.com/Pinjasaur/rnjeesus/blob/master/docs/API.md">API</a>.</p>

      </div>

      <button class="btn" data-target="2">Begin &rarr;</button>

      <footer class="site-footer">
        <ul>
          <li>
            By
            <a href="https://twitter.com/Pinjasaur">Paul</a>
            &amp;
            <a href="https://twitter.com/kwak_2331">Kris</a>
          </li>
          <li>
            <a href="https://github.com/Pinjasaur/rnjeesus">Source</a>
          </li>
          <li>
            <a href="https://github.com/Pinjasaur/rnjeesus/blob/master/docs/API.md">API</a>
          </li>
        </ul>
      </footer>

    </section>
    <section class="step" data-step="2">

      <header>
        <h1>Lower bound</h1>
      </header>

      <div class="content">

        <p>Choose your lower bound.</p>

        <div class="input">
          <input type="button" class="btn decrement" value="-" data-for="lower-bound">
          <input type="number" id="lower-bound" value="1" min="<?php echo BOUNDS_MIN ?>" max="<?php echo BOUNDS_MAX ?>">
          <input type="button" class="btn increment" value="+" data-for="lower-bound">
        </div>

      </div>

      <button class="btn" data-target="3">Next &rarr;</button>

    </section>
    <section class="step" data-step="3">

      <header>
        <h1>Upper bound</h1>
      </header>

      <div class="content">

        <p>Choose your upper bound.</p>

        <div class="input">
          <input type="button" class="btn decrement" value="-" data-for="upper-bound">
          <input type="number" id="upper-bound" value="5" min="<?php echo BOUNDS_MIN ?>" max="<?php echo BOUNDS_MAX ?>">
          <input type="button" class="btn increment" value="+" data-for="upper-bound">
        </div>

      </div>

      <button class="btn" data-target="4">Next &rarr;</button>

    </section>
    <section class="step" data-step="4">

      <header>
        <h1>Quantity</h1>
      </header>

      <div class="content">

        <p>How many numbers do you want?</p>

        <div class="input">
          <input type="button" class="btn decrement" value="-" data-for="quantity">
          <input type="number" id="quantity" value="1" min="<?php echo QUANTITY_MIN ?>" max="<?php echo QUANTITY_MAX ?>">
          <input type="button" class="btn increment" value="+" data-for="quantity">
        </div>

      </div>

      <form id="rnjeesus">
        <button class="btn">RNG Time!</button>
      </form>

    </section>
    <section class="step" id="results" data-step="5">

      <header>
        <h1>Your RNG</h1>
      </header>

      <div class="content"></div>

      <button class="btn" data-target="2">Roll Again?</button>

    </section>

    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/jquery.firefly.js"></script>
    <script src="js/app.js"></script>
    <script>
      !function(r,n,g){r.GoogleAnalyticsObject=g;r[g]||(r[g]=function(){
      (r[g].q=r[g].q||[]).push(arguments)});r[g].l=+new Date;var s=n.createElement('script'),
      e=n.scripts[0];s.src="//www.google-analytics.com/analytics.js";
      e.parentNode.insertBefore(s,e)}(window,document,"ga");

      ga("create", "UA-76467706-6", "auto");
      ga("send", "pageview");
    </script>
  </body>
</html>
