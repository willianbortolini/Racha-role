 <!-- Navbar -->
 <nav class="navbar navbar-expand-lg">
     <div class="container-fluid">
         <a class="navbar-brand" href="#">Racha Role</a>
     </div>
 </nav>

 <!-- Main Content -->
 <div class="container mt-5">

     <!-- Introduction Section -->
     <div class="intro-section text-center">
         <h1 class="h4">Simplifique a divisão de despesas</h1>
         <p class="lead">Aqui você e seus amigos a viverem experiências juntos sem a preocupação de dividir as contas na hora. Aproveite os momentos sem pressa, nós cuidamos da divisão depois!</p>
     </div>

     <!-- How It Works Section -->
     <div class="mt-5">
         <h2 class="h5 text-center mb-4">Como Funciona</h2>

         <div class="row text-center">
             <div class="col-4">
                 <div class="feature-icon">
                     <i class="fas fa-money-bill-wave"></i>
                 </div>
                 <p>Adicione despesas</p>
             </div>
             <div class="col-4">
                 <div class="feature-icon">
                     <i class="fas fa-users"></i>
                 </div>
                 <p>Divida de forma automatica</p>
             </div>
             <div class="col-4">
                 <div class="feature-icon">
                     <i class="fas fa-chart-line"></i>
                 </div>
                 <p>Veja quem deve quanto</p>
             </div>
         </div>
     </div>

     <!-- Call to Action Buttons -->
     <div class="d-flex flex-column mt-5">
         <a href="<?php echo URL_BASE . "Users/create" ?>" class="btn btn-primary btn-lg mb-3">
             <i class="fas fa-user-plus"></i> Registrar-se
         </a>
         <a href="<?php echo URL_BASE . 'Login' ?>" class="btn btn-secondary btn-lg">
             <i class="fas fa-sign-in-alt"></i> Fazer Login
         </a>
     </div>

 </div>

 <!-- Footer -->
 <footer class="mt-5 text-center">
     <p class="text-muted">Racha Role © 2024</p>
 </footer>