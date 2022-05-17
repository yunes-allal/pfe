<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title>Sass Test</title>
</head>
<body>
    <!-- Navbar -->

    <nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img height="70" src="assets/img/logo.png" alt="Logo of Guelma university"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item px-2"><a class="nav-link"href="">Accueil</a></li>
                    <li class="nav-item px-2"><a class="nav-link"href="#articles">Articles</a></li>
                    <li class="nav-item px-2"><a class="nav-link"href="guide">Guid</a></li>
                    <li class="nav-item ps-2 pe-4"><a class="nav-link"href="#footer">à propos</a></li>
                    <div class="vr"></div>
                    <li class="nav-item ps-4 pe-2"><a class="nav-link link-dark" href="{{ route('login') }}">Se connecter</a></li>
                </ul>
                <a href="{{ route('register') }}"><button class="btn btn-outline-primary my-2">S'inscrire</button></a>

          </div>
        </div>
      </nav>

        <!-- BODY -->
        <div style="height: 10rem"></div>
      <div class="container my-3">
        <div class="row align-items-center">
          <div class="col-md-6 col-sm-12">
            <h1 class="display-3">This is our title</h1>
            <h1 class="mt-2 lead lh-base">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti soluta ad ut animi maiores commodi labore itaque ipsum assumenda, sapiente qui numquam dolores nesciunt voluptatibus quae, vero debitis. Perspiciatis, deserunt?</p>
            <div class="mt-4 mb-2 text-center">
                <a href="{{ route('login') }}"><button class="mr-2 btn btn-primary">Se Connecter</button></a>

              <button class="ml-2 btn btn-outline-secondary">En Savoir Plus</button>
            </div>
          </div>
          <div class="col">
            <img class="img-responsive img-fluid" src="assets/img/undraw_organize_resume_re_k45b (2).svg" alt="">
          </div>
        </div>


        <div id="articles" style="height: 10rem;"></div>


        <section>
          <div class="text-center">
            <h6>Consultez notre</h6>
            <div class="row">
              <div class="col"><hr></div>
              <div class="col-6"><h2>Dernières nouvelles et articles</h2></div>
              <div class="col"><hr></div>
            </div>
            <i>Cliquez sur un titre d'actualité pour accéder à l'article</i>
          </div>
          <div class="row mt-5">
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <span class="position-absolute top-0 start-100 translate-middle badge bg-warning">
                    Nouveau
                    <span class="visually-hidden">Latest</span>
                  </span>
                  <h6>De: <small class="fw-medium text-primary">10-09-2022</small></h6>
                  <h6>à: <small class="fw-medium text-primary">20-09-2022</small></h6><br>
                  <a href=""><h5 class="card-title text-truncate">Titre d'article</h5></a>
                  <p class="card-text card-title text-truncate">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <p class="card-text"><small class="fw-light text-muted">10-03-2022</small></p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <div style="height: 8rem;"></div>
      </div>

      <!-- footer -->

      <footer class="footer-clean" style="text-align: center;"><img src="assets/img/logo.png" style="margin-top: 10px;margin-bottom: 20px;">
        <div class="container" style="margin-top: 20px;">
            <div class="row justify-content-center">
                <div class="col-sm-4 col-md-3 item">
                    <h3>Services</h3>
                    <ul>
                        <li><a href="#">Web design</a></li>
                        <li><a href="#">Development</a></li>
                        <li><a href="#">Hosting</a></li>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-3 item">
                    <h3>About</h3>
                    <ul>
                        <li><a href="#">Company</a></li>
                        <li><a href="#">Team</a></li>
                        <li><a href="#">Legacy</a></li>
                    </ul>
                </div>
                <div class="col-sm-4 col-md-3 item">
                    <h3>Careers</h3>
                    <ul>
                        <li><a href="#">Job openings</a></li>
                        <li><a href="#">Employee success</a></li>
                        <li><a href="#">Benefits</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a>
                    <p class="copyright">Company Name © 2022</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
