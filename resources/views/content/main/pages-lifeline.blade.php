<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Smart Home Page</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>
  <style>
    /* Custom Animations */
    @keyframes fade-in {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }



    .delay-500 {
      animation-delay: 0.5s;
    }

    .bg-grid-white\/10 {
      background-image: linear-gradient(to right, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                        linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
      background-size: 40px 40px;
    }

    .hover-scale {
      transition: transform 0.3s ease;
    }

    .hover-scale:hover {
      transform: scale(1.05);
    }

    .parallax {
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    .sticky-title {
      position: sticky;
      top: 0;
      z-index: 40;
      background: linear-gradient(to bottom, rgba(17, 24, 39, 1), rgba(17, 24, 39, 0.9));
      backdrop-filter: blur(10px);
      padding: 1rem 0;
    }

    .card-gradient {
      background: linear-gradient(145deg, rgba(55, 65, 81, 1), rgba(31, 41, 55, 1));
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .card-gradient:hover {
      background: linear-gradient(145deg, 0rgb(229, 70, 70), rgb(99, 241, 187));
    }
  </style>
</head>
<body class="bg-gray-900 text-white">
  <!-- Navbar -->
  <nav class="fixed top-0 left-0 w-full bg-gray-800/90 backdrop-blur-md z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <a href="#" class="text-2xl font-bold text-white">Lifeline</a>
      <div class="hidden md:flex space-x-8">
        <a href="#features" class="text-gray-300 hover:text-white">Features</a>
        <a href="{{ url('/auth/login-basic') }}" class="text-gray-300 hover:text-white">Sign In</a>
        <a href="{{ url('/auth/register-basic') }}" class="text-gray-300 hover:text-white">Register</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="relative h-screen flex items-center justify-center bg-gradient-to-r from-purple-900 to-indigo-800 overflow-hidden">
    <div class="text-center z-10">
      <h1 class="text-6xl font-bold mb-4 animate-fade-in">Welcome to Lifeline</h1>
      <h1 class="text-xl mb-8 animate-fade-in delay-500">Lifeline Hospital delivers advanced, compassionate healthcare with cutting-edge technology and a patient-centered approach.</h1>
      <a href="#features" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-full text-lg animate-bounce">Explore Features</a>
    </div>
    <div class="absolute inset-0 bg-grid-white/10"></div>
  </section>

  <!-- Sticky Title -->
  <div class="sticky-title">
    <h2 class="text-4xl font-bold text-center">Our Features</h2>
  </div>

  <!-- Features Section -->
  <section id="features" class="py-20 bg-gray-800">
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Feature 1 -->
        <div class="card-gradient p-8 rounded-lg shadow-lg hover-scale transition-all">
          <div class="text-4xl font-bold mb-4 text-blue-500">01</div>
          <h3 class="text-2xl font-bold mb-4">Super Animations</h3>
          <p class="text-gray-300">Engage your users with smooth, eye-catching animations powered by GSAP.</p>
        </div>
        <!-- Feature 2 -->
        <div class="card-gradient p-8 rounded-lg shadow-lg hover-scale transition-all">
          <div class="text-4xl font-bold mb-4 text-purple-500">02</div>
          <h3 class="text-2xl font-bold mb-4">Responsive Design</h3>
          <p class="text-gray-300">Our page looks great on all devices, from desktops to mobile phones.</p>
        </div>
        <!-- Feature 3 -->
        <div class="card-gradient p-8 rounded-lg shadow-lg hover-scale transition-all">
          <div class="text-4xl font-bold mb-4 text-green-500">03</div>
          <h3 class="text-2xl font-bold mb-4">Modern UI</h3>
          <p class="text-gray-300">Built with Tailwind CSS for a sleek and modern user interface.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Parallax Section -->
  <section class="parallax h-96 bg-fixed bg-center bg-cover" style="background-image: url('https://via.placeholder.com/1920x1080');">
    <div class="h-full flex items-center justify-center bg-black/50">
      <h2 class="text-4xl font-bold text-center">Experience the Future</h2>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section id="testimonials" class="py-20 bg-gray-900">
    <div class="container mx-auto px-6">
      <h2 class="text-4xl font-bold text-center mb-12">What Our Users Say</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Testimonial 1 -->
        <div class="card-gradient p-6 rounded-lg shadow-lg hover-scale transition-all">
          <p class="text-gray-300 mb-4">"This is the best website I've ever used! The animations are mind-blowing."</p>
          <div class="flex items-center">
            <div class="w-12 h-12 bg-gray-700 rounded-full mr-4"></div>
            <div>
              <h3 class="text-xl font-bold">John Doe</h3>
              <p class="text-gray-400">CEO, Company</p>
            </div>
          </div>
        </div>
        <!-- Testimonial 2 -->
        <div class="card-gradient p-6 rounded-lg shadow-lg hover-scale transition-all">
          <p class="text-gray-300 mb-4">"The design is so modern and responsive. Highly recommended!"</p>
          <div class="flex items-center">
            <div class="w-12 h-12 bg-gray-700 rounded-full mr-4"></div>
            <div>
              <h3 class="text-xl font-bold">Jane Smith</h3>
              <p class="text-gray-400">Designer, Studio</p>
            </div>
          </div>
        </div>
        <!-- Testimonial 3 -->
        <div class="card-gradient p-6 rounded-lg shadow-lg hover-scale transition-all">
          <p class="text-gray-300 mb-4">"The features are amazing, and the animations are so smooth."</p>
          <div class="flex items-center">
            <div class="w-12 h-12 bg-gray-700 rounded-full mr-4"></div>
            <div>
              <h3 class="text-xl font-bold">Mike Johnson</h3>
              <p class="text-gray-400">Developer, Tech</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action Section -->
  <section id="cta" class="py-20 bg-gradient-to-r from-purple-900 to-indigo-800">
    <div class="container mx-auto px-6 text-center">
      <h2 class="text-4xl font-bold mb-4">Ready to Get Started?</h2>
      <p class="text-xl mb-8">Join us today and experience the future of web design.</p>
      <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-4 rounded-full text-lg">Sign Up Now</a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-10 bg-gray-800">
    <div class="container mx-auto px-6 text-center">
      <p class="text-gray-300">&copy; 2023 SmartHome. All rights reserved.</p>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // GSAP Animations
      gsap.from('.animate-fade-in', {
        opacity: 0,
        y: 50,
        duration: 1,
        stagger: 0.3,
        ease: 'power2.out',
      });

      gsap.from('.bg-grid-white\\/10', {
        opacity: 0,
        duration: 2,
        ease: 'power2.out',
      });

      // Scroll-triggered animations
      gsap.utils.toArray('.card-gradient').forEach((card) => {
        gsap.from(card, {
          scrollTrigger: {
            trigger: card,
            start: 'top 80%',
          },
          opacity: 0,
          y: 50,
          duration: 1,
          ease: 'power2.out',
        });
      });
    });
  </script>
</body>
</html>
