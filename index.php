<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'albelpaskal1@gmail.com';
        $mail->Password   = 'iruc klwa uukj xnct';
        $mail->Port       = 587;
        $mail->setFrom('albelpaskal1@gmail.com', 'Albel Graphics & Web Design');
        $mail->addAddress($to);
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

$admin_email = "albelpaskal1@gmail.com";
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
    if (isset($_POST['subscriber'], $_POST['email'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (sendEmail($admin_email, "📧 New Subscriber Alert", "New subscriber email: $email")) {
            $msg_success = "Thanks for subscribing!";
        }
    }
    if (isset($_POST['name'], $_POST['phone'], $_POST['message'])) {
        $name = htmlspecialchars($_POST['name']);
        $phone = htmlspecialchars($_POST['phone']);
        $msg_content = htmlspecialchars($_POST['message']);
        if (sendEmail($admin_email,"📝 New Service Request","Name: $name\nPhone: $phone\nMessage:\n$msg_content")) {
            $msg_success = "Your request was sent! We'll be in touch.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Albel Portfolio</title>
  <style>
    html { scroll-behavior: smooth; }
    body { font:15px/1.5 Arial,sans-serif; margin:0; padding:0; background:#f4f4f4; }
    .container { width:80%; margin:auto; overflow:hidden; }
    header {
      background:#35424a; color:#fff; padding:20px 0; border-bottom:3px solid #e8491d;
    }
    .header-inner { display:flex; justify-content:space-between; align-items:center; }
    header h1 { margin:0; font-size:28px; }
    nav { margin-top:10px; }
    nav ul { list-style:none; display:flex; padding:0; margin:0; }
    nav li { margin:0 10px; }
    nav a { color:#fff; text-transform:uppercase; text-decoration:none; font-weight:bold; }
    .highlight { color:#e8491d; }
    #hero { text-align:center; padding:60px 0; background:#eee; }
    .hero-img { width:150px; border-radius:50%; display:block; margin:auto; }
    .tagline { font-size:18px; color:#333; }
    .button_1 { background:#e8491d; color:#fff; padding:10px 20px; border:none; cursor:pointer; text-decoration:none;}
    section { padding:40px 0; }
    h1{text-align: center;}
    h2 { text-align:left; margin-bottom:20px; }
    .case, .service, .testimonial { float:left; width:30%; margin:1.66%; background:#fff; padding:10px; box-sizing:border-box; border-radius:4px; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
    .case img, .service img { width:100%; border-radius:4px; }
    .quote { font-style:italic; margin:15px; border-left:4px solid #e8491d; padding-left:10px; background:#fff; }
    .success { padding:10px; background:#dfd; color:#060; margin:20px 0; text-align:center; }
    .dark { background:#35424a; color:#fff; padding:20px; }
    footer {text-align:center; background:#e8491d; color:#fff; padding:20px 0;}
    @media(max-width:768px) {
      .case,.service,.testimonial { width:100%; float:none; margin:10px 0; }
      nav ul { flex-direction:column; }
    }
  </style>
</head>
<body id="top">

<header>
  <div class="container header-inner">
    <div>
      <h1><span class="highlight">Albel</span> Graphics & Web Design</h1>
      <nav>
        <ul>
          <li><a href="#hero">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
        </ul>
      </nav>
    </div>
    <img src="1.png" alt="Logo" width="70" height="50">
  </div>
</header>

<?php if (!empty($msg_success)): ?>
  <div class="container"><p class="success"><?=htmlspecialchars($msg_success)?></p></div>
<?php endif; ?>

<section id="hero">
  <div class="container">
    <img src="albel.png" alt="Your Name" class="hero-img">
    <h1>Hello, I’m <span class="highlight">Albel</span></h2>
    <p class="tagline">Creative Web & Graphic Designer based in Arusha</p>
    <a href="#boxes" class="button_1">Explore My Services</a>
  </div>
</section>

<section id="cases">
  <div class="container">
    <h2>My Works</h2>
    <p class="tagline">Check out some of my recent projects...</p>
    <div class="case">Project 1<h3>Car Parking System</h3><p>Smart, sensor-based, and automated parking system offering real-time slot data, robotics, and enhanced efficiency. </p></div>

    <div class="case">Project 2<h3>Online Clearance Form</h3><p>Web-based clearance management for students, reducing delays and centralizing workflows.</p></div>
    
    <div class="case">Project 3<h3>Graphics And Web design System </h3><p>Full-stack design/development agency work ideal for white-label partnerships and complete branding/web solutions.  </p></div>
    <div style="clear:both;"></div>
  </div>
</section>

<section id="boxes">
  <div class="container">
    <h2 id="services">Services I Offer</h2>
    <p class="tagline">Below are the services that i offer to my clients...</p>
    <div class="service"><img src="Webdesign.jpg" alt="Website Design"><h3>Website Design</h3></div>
    <div class="service"><img src="Webdevelopment.jpg" alt="Website Development"><h3>Website Development</h3></div>
    <div class="service"><img src="Maintanance.jpg" alt="Website Maintenance"><h3>Website Maintenance</h3></div>
    <div class="service"><img src="Hosting.jpg" alt="Website Hosting"><h3>Website Hosting</h3></div>
    <div class="service"><img src="Database.jpg" alt="Database Creation"><h3>Database Creation</h3></div>
    <div class="service"><img src="Graphics.jpg" alt="Graphic Design"><h3>Graphic Design</h3></div>
    <div class="service"><img src="Network.jpg" alt="Networking Services"><h3>Networking Services</h3></div>
    <div style="clear:both;"></div>
  </div>
</section>

<section id="testimonials">
  <div class="container">
    <h2>Testimonials</h2>
    <p class="quote">“Albel transformed our website—fast, professional, and beautiful!” – Client A</p>
    <p class="quote">“Great communication and excellent design!” – Client B</p>
    <p class="quote">“Albel is a true professional. He delivered on time and exceeded my expectations-Client C"</p>
  </div>
</section>

<section id="faq">
  <div class="container">
    <h2>FAQ</h2>
    <p><strong>How long does a website take?</strong><br>Usually 2–4 weeks depending on scope.</p>
    <p><strong>What are your prices?</strong><br>Contact for a quote.</p>
  </div>
</section>

<section id="blog">
  <div class="container">
    <h2>Latest Insights</h2>
    <ul>
      <li><a href="color.php">How to choose your brand colors</a></li>
      <li><a href="tip.php">5 tips to speed up your site</a></li>
    </ul>
  </div>
</section>

<section id="newsletter">
  <div class="container dark">
    <h2>Subscribe</h2>
    <form method="POST">
      <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($_SESSION['csrf_token'])?>">
      <input type="email" name="email" placeholder="Your email" required>
      <button type="submit" name="subscriber" class="button_1">Subscribe</button>
    </form>
  </div>
</section>

<section id="main">
  <div class="container">
    <article id="about">
      <h2>About Me</h2>
      <p><b>Country</b> – Tanzania</p>
      <p><b>City</b> – Arusha</p>
      <p><b>I'm a creative web & graphic designer based in Arusha with expertise in...</b></p>
    </article>
    <article id="services">
      <h2>Contact Me</h2>
      <form method="POST">
        <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($_SESSION['csrf_token'])?>">
        <label>Name</label><input type="text" name="name" required><br><br>
        <label>Phone</label><input type="tel" name="phone" required><br><br>
        <label>Message</label><textarea name="message" required></textarea><br><br>
        <button type="submit" class="button_1">Send Request</button>
      </form>
    </article>
  </div>
</section>

<footer>
  <div class="container">
    <p>Contact me: albelpaskal1@gmail.com • +255 789 936 077</p>
    <p>Follow me: <a href="https://www.instagram.com/albelgraphics/profilecard/?igsh=dXJuM2p1Mzdtamx3" style="color:#fff;">Instagram</a> • <a href="https://www.instagram.com/albelgraphics/profilecard/?igsh=dXJuM2p1Mzdtamx3" style="color:#fff;">Facebook</a></p>
    <p>&copy; <?=date("Y")?> Albel Graphics & Web Design</p>
  </div>
</footer>

</body>
</html>


