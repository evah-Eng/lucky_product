<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: index.php"); // redirect to register if not logged in
    exit;
}
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lucky Product — Home</title>
  <meta name="description" content="Lucky Product — high-quality products designed to bring you luck. View gallery, features, and contact us." />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --accent:#db2777;
      --muted:#6b7280;
      --bg:#fdf2f8;
      --card:#ffffff;
      --radius:14px;
      --maxw:1100px;
    }
p {
    text-align: center;
    color: #0f172a;
    font-size: 15px;
    border: 1px solid #e6edf0;
    padding: 8px;
    border-radius: 6px; /* optional, makes corners rounded */
}


    *{box-sizing:border-box;font-family:'Poppins',system-ui,-apple-system,Segoe UI,Roboto,'Helvetica Neue',Arial;margin:0;padding:0;}
    body{background:var(--bg);color:#0f172a;line-height:1.4;}
    a{text-decoration:none;}
    .container{max-width:var(--maxw);margin:0 auto;padding:28px;}

    /* Header */
    header{display:flex;align-items:center;justify-content:space-between;padding:18px 0;}
    .brand{display:flex;align-items:center;gap:12px;}
    .logo{width:56px;height:56px;border-radius:12px;background:linear-gradient(135deg,var(--accent),#10b981);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:20px;}
    nav ul{list-style:none;display:flex;gap:18px;}
    nav ul li{display:inline-block;}
    nav a{color:var(--muted);font-weight:600;}
    .cta{background:var(--accent);color:white;padding:10px 14px;border-radius:10px;font-weight:700;}

    /* Hero */
    .hero{display:grid;grid-template-columns:1fr 480px;gap:28px;align-items:center;margin-top:18px;}
    .hero-content h1{font-size:40px;margin-bottom:12px;}
    .hero-content p{color:var(--muted);margin-bottom:18px;}
    .hero-actions{display:flex;gap:12px;}
    .btn{padding:12px 16px;border-radius:10px;font-weight:700;}
    .btn-primary{background:var(--accent);color:white;}
    .btn-outline{border:2px solid var(--accent);color:var(--accent);background:transparent;}
    .hero-card{background:var(--card);border-radius:16px;box-shadow:0 6px 24px rgba(2,6,23,0.06);overflow:hidden;}
    .hero-card img{width:100%;height:360px;object-fit:cover;display:block;}

    /* Features */
    .features{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-top:20px;}
    .feature{background:var(--card);padding:18px;border-radius:12px;box-shadow:0 6px 18px rgba(2,6,23,0.04);}
    .feature h3{margin-bottom:8px;}
    .feature p{color:var(--muted);margin:0;}

    /* Gallery */
    .gallery{margin-top:28px;display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
    .gallery img{width:100%;height:260px;object-fit:cover;border-radius:12px;cursor:pointer;}

    /* About & Contact */
    .two-col{display:grid;grid-template-columns:1fr 360px;gap:18px;margin-top:28px;}
    .card{background:var(--card);padding:18px;border-radius:12px;box-shadow:0 6px 18px rgba(2,6,23,0.04);}
    form label{display:block;font-weight:600;margin-top:12px;}
    form input, form textarea{width:100%;padding:10px;border-radius:10px;border:1px solid #e6edf0;margin-top:6px;}
    form button{margin-top:12px;padding:12px 16px;border-radius:10px;border:none;cursor:pointer;}

    footer{margin-top:40px;padding:24px 0;color:var(--muted);text-align:center;}

    /* Lightbox */
    .lightbox{position:fixed;inset:0;background:rgba(2,6,23,0.7);display:flex;align-items:center;justify-content:center;padding:20px;z-index:60;visibility:hidden;opacity:0;transition:opacity .18s,visibility .18s;}
    .lightbox.open{visibility:visible;opacity:1;}
    .lightbox img{max-width:100%;max-height:90vh;border-radius:12px;}

    /* Responsive */
    @media (max-width:980px){
      .hero{grid-template-columns:1fr;}
      .hero-card{height:auto;}
      .two-col{grid-template-columns:1fr;}
      .features{grid-template-columns:1fr 1fr;}
      .gallery{grid-template-columns:repeat(2,1fr);}
    }
    @media (max-width:520px){
      .features{grid-template-columns:1fr;}
      .gallery img{height:160px;}
      .logo{width:44px;height:44px;}
    }
    #menuToggle{ display:none; font-size:28px; background:none; border:none; }
@media (max-width:768px){
  #menuToggle{ display:block; }
  #navMenu ul{ display:none; flex-direction:column; }
  #navMenu.open ul{ display:flex; }
}
.m-pesa-flex {
    display: flex;
    align-items: center;
    gap: 20px; /* space between image and text */
}

.m-pesa-flex .payment-info {
    flex: 1; /* allow payment info to take available space */
}

.delivery-image img {
    max-width: 600px; /* smaller image */
    height: auto;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}



  </style>
</head>
<body>
 
  <div class="container">
    <!-- HEADER -->
    <header>
      <div class="brand">
        <div class="logo">LP</div>
        <div>
          <div style="font-weight:700">Lucky Product</div>
          <div style="font-size:12px;color:var(--muted)">Bring luck to your life</div>
        </div>
      </div>
      <!-- Add this in header -->
<button id="menuToggle">☰</button>

 <nav id="navMenu">
        <ul>
          <li><a href="#home">Home</a></li>
          <li><a href="#products">Products</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#contact">Contact</a></li>
          <li><a class="cta" href="#contact">Buy Now</a></li>
          
        <p><a href="logout.php">Logout</a></p>
        </ul>
      </nav>
    </header>


    <!-- HERO -->
     <h2> Welcome to Lucky product press your order and enjoy the product</h2>

    <section id="home" class="hero">
      <div class="hero-content">
        <h1>Lucky Product — Find your lucky charm</h1>
        <p>Hand-selected products crafted to bring style and a little extra luck. Browse our gallery, learn the features, or contact us to order.</p>
        <div class="hero-actions">
          <a class="btn btn-primary" href="#products">Explore Products</a>
          <a class="btn btn-outline" href="#about">Our Story</a>
        </div>
        <div class="features">
          <div class="feature">
            <h3>Premium Quality</h3>
            <p>Only the best materials and careful craftsmanship.</p>
          </div>
          <div class="feature">
            <h3>Unique Design</h3>
            <p>Each piece is unique — made to stand out.</p>
          </div>
          <div class="feature">
            <h3>Satisfaction</h3>
            <p>Easy returns and friendly customer support.</p>
          </div>
        </div>
      </div>
      <div>
        <div class="hero-card">
          <img src="./img/product one.png" alt="Lucky Product hero image" />
        </div>
      </div>
    </section>

    <!-- PRODUCTS / GALLERY -->
    <section id="products">
      <h2 style="margin-top:30px">Products Gallery</h2>
      <p style="color:var(--muted)">Click any image to enlarge.</p>
      <div class="gallery">
        <img src="./img/product 2.png" alt="Product 1" loading="lazy">
        <img src="./img/product 5.png" alt="Product 2" loading="lazy">
        <img src="./img/product 4.png" alt="Product 3" loading="lazy">
      </div>
    </section>

    <!-- ABOUT + CONTACT -->
    <section class="two-col">
      <div>
        <div class="card" id="about">
          <h2>About Lucky Product</h2>
          <p style="color:var(--muted)">Lucky Product began with a simple idea: small things can make a big difference. Our mission is to create beautiful, meaningful items that bring joy and confidence to daily life. Each product undergoes quality checks and is shipped with care.</p>
          <ul style="color:var(--muted);margin-top:12px">
            <li>Locally made</li>
            <li>Eco-friendly packaging</li>
            <li>30-day satisfaction guarantee</li>
          </ul>
        </div>
        <div style="margin-top:18px">
          <h3 style="margin-bottom:8px">Why customers love us</h3>
          <div class="card">
            <div class="delivery-image">
      <img src="./img/derivery.png" alt="delivery image">
    </div>
            <p style="margin:0;color:var(--muted)">"Fast delivery and a product that felt special." — A satisfied customer</p>
           
        </div>
   
      </div>


      <div>
        <div class="card" id="contact">
          <h3>Place Your Order</h3>
          <form method="post" action="order.php" id="orderForm">
            <label for="name">Name</label>
            <input type="text" name="name" required placeholder="Your name" />

            <label for="email">Email</label>
            <input type="email" name="email" required placeholder="you@example.com" />

            <label for="contact">Contact Number</label>
            <input type="text" name="contact" required placeholder="+255 7XXXXXXXXX" />
            <label for="location"> Location</label>
            <input type="text" name="location"required placeholder="eg. ushirombo"/>

            <label>Number of Packets (500 TSH each)</label>
            <input type="number" min="0" value="0" name="qty500" id="qty500" />

            <label>Number of Packets (1000 TSH each)</label>
            <input type="number" min="0" value="0" name="qty1000" id="qty1000" />

            <p id="total">Total: 0 TSH</p>

            <button class="btn btn-primary" type="submit">Order Now</button>
          </form>
        </div>
      </div>
    </section>

  <p style="color:red; font-weight:bold;">After payment, please send confirmation to our contact email or WhatsApp.</p>
  <p> WhaatsApp via :0747456589</P>
  <p> E-mail via : Bahati12.eva@gmail.com</p>
</div>



    <footer>
      <div style="max-width:var(--maxw);margin:0 auto;padding:12px 0">© <span id="year"></span> Lucky Product • All rights reserved</div>
    </footer>
  </div>

  <!-- Lightbox -->
  <div id="lightbox" class="lightbox">
    <img id="lightboxImg" src="" alt="enlarged" />
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Total calculation
      const qty500 = document.getElementById('qty500');
      const qty1000 = document.getElementById('qty1000');
      const totalEl = document.getElementById('total');

      function calculateTotal() {
        const total = (parseInt(qty500.value)||0)*500 + (parseInt(qty1000.value)||0)*1000;
        totalEl.textContent = "Total: " + total.toLocaleString() + " TSH";
      }

      qty500.addEventListener('input', calculateTotal);
      qty1000.addEventListener('input', calculateTotal);
      calculateTotal();

      // Lightbox
      const lightbox = document.getElementById('lightbox');
      const lightboxImg = document.getElementById('lightboxImg');

      document.querySelectorAll('.gallery img').forEach(img=>{
        img.addEventListener('click',()=>{
          lightboxImg.src = img.src;
          lightbox.classList.add('open');
        });
      });

      lightbox.addEventListener('click', e => {
        if(e.target === lightbox) lightbox.classList.remove('open');
      });

      // Footer year
      document.getElementById('year').textContent = new Date().getFullYear();
    });
    // Toggle nav on phones
document.getElementById("menuToggle").addEventListener("click",()=>{
  document.getElementById("navMenu").classList.toggle("open");
});

  </script>
</body>
</html>
