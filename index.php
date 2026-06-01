<?php include "header.php"; ?>

<!-- HERO PRINCIPAL -->
<section class="hero d-flex align-items-center text-center"
         style="
            min-height:90vh;
            background:
                linear-gradient(rgba(8,10,20,.70), rgba(8,10,20,.70)),
                url('https://images.unsplash.com/photo-1588072432836-e10032774350');
            background-size:cover;
            background-position:center;
            color:white;
         ">
    <div class="container">

        <!-- ESCUDO -->
        <img src="assets/img/escudo-gca.png"
             alt="Gimnasio Castillo Americano"
             style="height:150px;"
             class="mb-4">

        <h1 class="display-5 fw-bold mb-3">
            BIENVENIDOS A NUESTRO CASTILLO
        </h1>

        <p class="lead mb-4" style="max-width:760px;margin:auto;">
            Educación con carácter, valores y excelencia académica.
        </p>

        <a href="login.php"
           class="btn btn-lg px-5 py-3"
           style="
                background:#c9a24d;
                color:#000;
                font-weight:600;
                border-radius:40px;
           ">
            Acceso al Sistema Académico
        </a>

    </div>
</section>

<!-- SECCIÓN IDENTIDAD -->
<section class="container my-5">
    <div class="row align-items-center g-5">

        <div class="col-md-6">
            <h2 class="fw-bold mb-3">Nuestra Identidad</h2>
            <p class="text-muted">
                El Gimnasio Castillo Americano es una institución comprometida
                con la formación integral de niños y jóvenes, basada en valores,
                disciplina y excelencia.
            </p>
            <p class="text-muted">
                Nuestro proyecto educativo fortalece el liderazgo, la
                responsabilidad y el pensamiento crítico como pilares del
                desarrollo humano.
            </p>
        </div>

        <div class="col-md-6">
            <img src="assets/img/img5.png"
                 class="img-fluid rounded-4 shadow"
                 alt="Identidad institucional">
        </div>

    </div>
</section>

<!-- VALORES INSTITUCIONALES -->
<section style="background:#f5f7fa;" class="py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="fw-bold">Nuestros Principios</h2>
            <p class="text-muted">
                La base de nuestra formación educativa
            </p>
        </div>

        <div class="row g-4 text-center">

           <div class="col-md-4">
    <div class="card h-100 p-4 border-0 shadow-sm text-center">

        <img 
            src="assets/img/colegio.png"
            class="img-fluid rounded mb-3"
            alt="Valores y Disciplina"
        >

        <h5 class="fw-bold">Valores y Disciplina</h5>
        <p class="text-muted">
            Formamos estudiantes íntegros,
            responsables y comprometidos con la sociedad.
        </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm">
                    <img src= "assets/img/img2.png"
                         class="img-fluid rounded mb-3"
                         alt="Excelencia">
                    <h5 class="fw-bold">Excelencia Académica</h5>
                    <p class="text-muted">
                        Procesos pedagógicos sólidos,
                        acompañamiento permanente y calidad educativa.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm">
                    <img src="assets/img/img3.png"
                         class="img-fluid rounded mb-3"
                         alt="Comunidad">
                    <h5 class="fw-bold">Comunidad Educativa</h5>
                    <p class="text-muted">
                        Trabajo conjunto entre familia,
                        institución y estudiantes.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- MENSAJE INSTITUCIONAL -->
<section class="py-5"
         style="
            background:
                linear-gradient(rgba(15,23,42,.85), rgba(15,23,42,.85)),
                url('https://images.unsplash.com/photo-1519452575417-564c1401ecc0');
            background-size:cover;
            background-position:center;
            color:white;
         ">
    <div class="container text-center">

        <h2 class="fw-bold mb-3">
            Cultivar para Cosechar
        </h2>

        <p class="mb-4" style="max-width:760px;margin:auto;color:#e5e7eb;">
            Educamos con visión de futuro, formando personas
            capaces de transformar su entorno con valores y conocimiento.
        </p>

        <a href="login.php"
           class="btn btn-lg px-5 py-3"
           style="
                background:#c9a24d;
                color:#000;
                font-weight:600;
                border-radius:40px;
           ">
            Ingresar al Sistema
        </a>

    </div>
</section>

<?php include "footer.php"; ?>
