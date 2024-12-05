<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>{{ config('app.name', 'Tixtoria') }}</title>
  <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/x-icon">

  <style>
    .sidebar-bg {
      background: linear-gradient(to right, #1B1464, #640D5F);
      mix-blend-mode: normal;
    }
    aside {
      position: fixed;
    }
    a {
      font-size: 14px;
    }
    .navbar {
      position: fixed;
      overflow-x: auto;
    }
    .wrapper {
      margin-left: 215px; 
      height: 100vh;
      overflow-y: auto;
      width: 100%;
    }
    body {
      font-family: 'Poppins', sans-serif;
      color: #1B1464;
    }
    .active {
      background-color: white;
      color: #1B1464;
      font-weight: ;
      border-radius: 0.5rem;
    }
    .search-bar {
      margin-left: 280px;
    }
    .relative input {
      padding-right: 2.5rem;
      width: 400px; 
    }
    .relative .material-icons {
      position: absolute;
      top: 50%;
      right: 0.75rem;
      transform: translateY(-50%);
    }
    nav ul li {
      margin-bottom: 1rem;
    }
    h1 {
      color: #1B1464;
    }
    div {
      font-size: 14px;
    }
    ::-webkit-scrollbar {
      width: 12px; 
    }
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }
    ::-webkit-scrollbar-thumb {
      background-color: #640D5F; 
      border-radius: 6px; 
      border: 3px solid #f1f1f1; 
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #640D5F; 
    }
  </style>
</head>
<body class="flex bg-gray-100 h-screen">

  <!-- Sidebar -->
  <aside class="sidebar-bg w-[215px] h-full text-white flex flex-col">
    <div class="p-6 flex items-center">
      <img src="{{ asset('images/logo-wht.png') }}" alt="Tixtoria Logo" class="h-8 rounded-md">
    </div>
    <nav class="flex-1 px-4 mt-1">
      <ul class="space-y-1">
        <ul>
          <li>
            <a href="{{ route('user.dashboard') }}" class="flex items-center px-3 py-2 hover:bg-white hover:text-gray-900 rounded-lg transition" onclick="updateTitle('Dashboard', this)">
              <span class="material-icons text-lg mr-3">account_circle</span>
              Profile
            </a>
          </li>
          <li>
            <a href="{{ route('user.favorites') }}" class="flex items-center px-3 py-2 hover:bg-white hover:text-gray-900 rounded-lg transition" onclick="updateTitle('Favorites', this)">
              <span class="material-icons text-lg mr-3">favorite</span>
              Favorites
            </a>
          </li>       
          <li>
            <a href="{{ route('user.ticket') }}" class="flex items-center px-3 py-2 hover:bg-white hover:text-gray-900 rounded-lg transition" onclick="updateTitle('Manage Tickets', this)">
                <span class="material-icons text-lg mr-3">confirmation_number</span>
                Tickets
            </a>
          </li>
          <li>
            <form action="{{ route('logout') }}" method="POST" class="flex items-center px-3 py-2 hover:bg-white hover:text-gray-900 rounded-lg transition">
                @csrf
                <button type="submit" class="flex items-center w-full text-left" style="font-size: 13px">
                    <span class="material-icons text-lg mr-3">logout</span>
                    Log Out
                </button>
            </form>
        </li>        
        </ul>
      </nav>      
    </aside>

  <!-- Main Content -->
  <div class="wrapper h-screen w-full flex-col">
    <!-- Fixed Navbar -->
    <nav class="navbar bg-white shadow-md fixed top-0 left-0 z-50 w-full p-4 flex items-center justify-between" style="margin-left: 215px; width: calc(100% - 215px);">
      <h1 id="page-title" class="text-xl font-bold ml-5">Dashboard</h1>


      <!-- Notifications and Profile -->
      <div class="flex items-center space-x-4 mr-5">

        <img src="{{ $profileUrl }}" alt="Profile" class="w-10 h-10 rounded-full mr-4 object-cover">
      </div>
    </nav>

    <!-- Scrollable Main Content -->
    <main class="flex-1 pt-24 p-8 bg-gray-100 overflow-auto">
      @yield('content')
    </main>
  </div>

  <script>
    function updateTitle(title, element) {
      event.preventDefault();

      document.getElementById('page-title').innerText = title;

      // Fetch the new content
      const newUrl = element.getAttribute("href");
      history.pushState(null, title, newUrl);

      fetch(newUrl)
      .then(response => response.text())
      .then(data => {
        // Select only the content within the <main> tag and update it
        const newContent = new DOMParser().parseFromString(data, 'text/html').querySelector('main');
        document.querySelector('main').innerHTML = newContent.innerHTML; // Update the content inside <main>
      });

      document.querySelectorAll('nav a').forEach(link => link.classList.remove('active'));
      element.classList.add('active');
    }
    
    // For initial hover effect setup
    document.querySelectorAll('nav a').forEach(item => {
      item.addEventListener('mouseenter', function () {
        this.classList.add('hover:bg-white');
        this.classList.add('hover:text-gray-900');
      });
      item.addEventListener('mouseleave', function () {
        this.classList.remove('hover:bg-white');
        this.classList.remove('hover:text-gray-900');
      });
    });
  </script>
</body>
</html>
